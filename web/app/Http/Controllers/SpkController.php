<?php

namespace App\Http\Controllers;

use App\Jobs\SendMailJob;
use App\Jobs\SendWaJob;
use App\Models\Branch;
use App\Models\Color;
use App\Models\Customer;
use App\Models\Lead;
use App\Models\LeasingPartner;
use App\Models\Order;
use App\Models\Unit;
use App\Models\User;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SpkController extends Controller
{
    public function create(Request $request)
    {
        $unitId = $request->query('unit_id');
        $variantId = $request->query('variant_id');
        $branchId = null;
        $colorId = null;

        if ($unitId) {
            $dipilih = Unit::with('variant')->find($unitId);
            if ($dipilih && $dipilih->status === 'Tersedia' && $dipilih->variant->aktif) {
                $branchId = (string) $dipilih->branch_id;
                $colorId = (string) $dipilih->color_id;
                $variantId = (string) $dipilih->variant_id;
            } else {
                $unitId = null;
            }
        }

        $variants = Variant::with('carModel.brand')
            ->where('aktif', true)
            ->whereHas('units', fn ($q) => $q->tersedia())
            ->get()
            ->sortBy([
                fn ($a, $b) => $a->carModel->brand->nama <=> $b->carModel->brand->nama,
                fn ($a, $b) => $a->carModel->nama <=> $b->carModel->nama,
                fn ($a, $b) => $a->nama <=> $b->nama,
            ]);

        if (! $variantId && $variants->isNotEmpty()) {
            $variantId = (string) $variants->first()->id;
        }

        $units = $variantId
            ? Unit::with(['variant.carModel.brand', 'color', 'branch'])
                ->tersedia()
                ->where('variant_id', $variantId)
                ->orderBy('branch_id')
                ->orderBy('harga')
                ->get()
            : collect();

        $leasings = LeasingPartner::where('aktif', true)->orderBy('nama')->get();
        $branches = Branch::where('aktif', true)->orderBy('nama')->get();
        $colors = Color::where('aktif', true)->orderBy('nama')->get();
        $salesList = User::role('sales')->orderBy('name')->get();

        return view('spk.create', compact('units', 'variants', 'leasings', 'branches', 'colors', 'salesList') + [
            'unit_id' => $unitId,
            'variant_id' => $variantId,
            'branch_id' => $branchId,
            'color_id' => $colorId,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'unit_id' => ['required', 'exists:units,id'],
            'nama' => ['required', 'string', 'max:100'],
            'nik' => ['required', 'digits:16'],
            'telp' => ['required', 'regex:/^[0-9]{10,15}$/'],
            'alamat' => ['required', 'string'],
            'metode' => ['required', 'in:Cash,Kredit,TradeIn'],
            'leasing_id' => ['required_if:metode,Kredit', 'nullable', 'exists:leasing_partners,id'],
            'tenor' => ['required_if:metode,Kredit', 'nullable', 'integer', 'in:12,24,36,48'],
            'dp_rencana' => ['nullable', 'integer', 'min:0'],
            'ktp' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'kk' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'sales_id' => ['nullable', 'exists:users,id'],
        ]);

        $order = DB::transaction(function () use ($data, $request) {
            $unit = Unit::whereKey($data['unit_id'])->lockForUpdate()->firstOrFail();

            abort_if($unit->status !== 'Tersedia', 422, 'Unit sudah tidak tersedia.');
            abort_if(Order::where('unit_id', $unit->id)->aktif()->lockForUpdate()->exists(), 422, 'Unit sedang dalam proses SPK lain.');

            $customer = Customer::firstOrCreate(
                ['nik' => $data['nik']],
                [
                    'user_id' => $request->user()->id,
                    'nama' => $data['nama'],
                    'telp' => $data['telp'],
                    'alamat' => $data['alamat'],
                    'ktp_path' => $request->file('ktp')->store('ktp', 'local'),
                    'kk_path' => $request->hasFile('kk') ? $request->file('kk')->store('kk', 'local') : null,
                ]
            );

            if ($customer->user_id === null) {
                $customer->update(['user_id' => $request->user()->id]);
            }
            abort_if($customer->user_id !== $request->user()->id, 422, 'NIK ini terdaftar pada akun lain. Hubungi admin cabang.');

            $tahun = now()->format('Y');
            $seq = Order::where('no_spk', 'like', "SPK-{$tahun}-%")->lockForUpdate()->count() + 1;

            $order = Order::create([
                'no_spk' => sprintf('SPK-%s-%04d', $tahun, $seq),
                'customer_id' => $customer->id,
                'unit_id' => $unit->id,
                'branch_id' => $unit->branch_id,
                'metode' => $data['metode'],
                'leasing_id' => $data['leasing_id'] ?? null,
                'dp_rencana' => $data['dp_rencana'] ?? 0,
                'tenor' => $data['tenor'] ?? null,
                'booking_fee' => $unit->branch->booking_fee,
                'status' => 'MenungguBayar',
                'deadline_at' => now()->addDay(),
            ]);

            $unit->update(['status' => 'Dipesan']);

            Lead::create([
                'customer_id' => $customer->id,
                'sales_id' => $data['sales_id'] ?? null,
                'sumber' => 'Web',
                'status' => 'SPK',
                'kebutuhan_text' => "SPK {$order->no_spk} untuk {$unit->variant->carModel->brand->nama} {$unit->variant->carModel->nama} {$unit->variant->nama} ({$unit->vin})",
            ]);

            return $order;
        });

        $rek = $order->branch->bankAccounts()->where('aktif', true)->first();
        SendWaJob::dispatch(
            $order->customer->telp,
            "SPK {$order->no_spk} dibuat. Transfer Rp ".number_format($order->booking_fee, 0, ',', '.').($rek ? " ke {$rek->bank} {$rek->no_rek} a.n. {$rek->atas_nama}" : '')." sebelum {$order->deadline_at->format('d M Y H:i')}."
        );
        if ($request->user()->email) {
            SendMailJob::dispatch($request->user()->email, "SPK {$order->no_spk} dibuat",
                "Instruksi transfer Rp ".number_format($order->booking_fee, 0, ',', '.')." sebelum {$order->deadline_at->format('d M Y H:i')}. Lacak di halaman Lacak SPK.");
        }

        return redirect()->route('spk.show', $order->no_spk)->with('sukses', 'SPK berhasil dibuat. Segera transfer booking fee sebelum deadline.');
    }

    public function show(string $no_spk)
    {
        $order = Order::with(['customer', 'unit.variant.carModel.brand', 'unit.color', 'branch.bankAccounts', 'leasing', 'invoice'])
            ->where('no_spk', $no_spk)->firstOrFail();

        return view('spk.show', compact('order'));
    }

    public function upload(Request $request, string $no_spk)
    {
        $order = Order::where('no_spk', $no_spk)->firstOrFail();

        abort_if($order->status !== 'MenungguBayar', 422, 'Bukti hanya bisa diunggah saat status MenungguBayar.');
        if ($order->customer->user_id === null) {
            $order->customer->update(['user_id' => $request->user()->id]);
        }
        abort_if($order->customer->user_id !== $request->user()->id, 403, 'SPK ini milik akun lain. Masuk dengan akun yang membuat SPK.');

        $data = $request->validate([
            'bukti' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        $order->update([
            'bukti_path' => $request->file('bukti')->store('bukti', 'local'),
            'status' => 'MenungguVerifikasi',
        ]);

        SendWaJob::dispatch($order->customer->telp, "Bukti bayar SPK {$order->no_spk} diterima dan menunggu verifikasi admin.");

        return redirect()->route('spk.show', $order->no_spk)->with('sukses', 'Bukti diterima dan menunggu verifikasi admin.');
    }

    public function lacakForm()
    {
        return view('spk.lacak');
    }

    public function lacak(Request $request)
    {
        $data = $request->validate([
            'no_spk' => ['required', 'string', Rule::exists('orders', 'no_spk')],
        ]);

        return redirect()->route('spk.show', $data['no_spk']);
    }
}
