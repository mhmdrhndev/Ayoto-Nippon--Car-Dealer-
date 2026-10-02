<?php

namespace App\Http\Controllers;

use App\Jobs\SendWaJob;
use App\Support\Notifikasi;
use App\Models\Customer;
use App\Models\Sparepart;
use App\Models\SparepartOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SparepartOrderController extends Controller
{
    public function index()
    {
        $orders = SparepartOrder::with(['customer', 'branch', 'items.sparepart'])
            ->latest()->paginate(15);

        return view('admin.sparepart-orders.index', compact('orders'));
    }

    public function checkout(Sparepart $sparepart)
    {
        abort_if(!$sparepart->aktif, 404);

        return view('sparepart.checkout', compact('sparepart'));
    }

    public function store(Request $request, Sparepart $sparepart)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'nik' => ['required', 'digits:16'],
            'telp' => ['required', 'regex:/^[0-9]{10,15}$/'],
            'alamat' => ['required', 'string'],
            'qty' => ['required', 'integer', 'min:1'],
        ]);

        abort_if($data['qty'] > $sparepart->stok, 422, 'Stok tidak cukup.');

        $order = DB::transaction(function () use ($data, $request, $sparepart) {
            $customer = Customer::firstOrCreate(
                ['nik' => $data['nik']],
                ['user_id' => $request->user()->id, 'nama' => $data['nama'], 'telp' => $data['telp'], 'alamat' => $data['alamat']]
            );
            if ($customer->user_id === null) {
                $customer->update(['user_id' => $request->user()->id]);
            }
            if ($customer->user_id !== $request->user()->id) {
                throw ValidationException::withMessages(['nik' => 'NIK ini terdaftar pada akun lain. Hubungi admin cabang.']);
            }

            $sparepart->decrement('stok', $data['qty']);

            $tahun = now()->format('Y');
            $seq = SparepartOrder::where('no_spo', 'like', "SPO-{$tahun}-%")->lockForUpdate()->count() + 1;

            $order = SparepartOrder::create([
                'no_spo' => sprintf('SPO-%s-%04d', $tahun, $seq),
                'customer_id' => $customer->id,
                'branch_id' => $sparepart->branch_id,
                'total' => $sparepart->harga * $data['qty'],
                'status' => 'MenungguBayar',
                'deadline_at' => now()->addDay(),
            ]);
            $order->items()->create([
                'sparepart_id' => $sparepart->id,
                'qty' => $data['qty'],
                'harga_satuan' => $sparepart->harga,
                'subtotal' => $sparepart->harga * $data['qty'],
            ]);

            return $order;
        });

        SendWaJob::dispatch($order->customer->telp, Notifikasi::spoDibuat($order));

        return redirect()->route('sparepart.order.show', $order->no_spo)->with('sukses', 'Order sparepart dibuat. Segera transfer sebelum deadline.');
    }

    public function show(string $no_spo)
    {
        $order = SparepartOrder::with(['customer', 'branch.bankAccounts', 'items.sparepart'])
            ->where('no_spo', $no_spo)->firstOrFail();

        return view('sparepart.order', compact('order'));
    }

    public function upload(Request $request, string $no_spo)
    {
        $order = SparepartOrder::where('no_spo', $no_spo)->firstOrFail();

        abort_if($order->status !== 'MenungguBayar', 422, 'Bukti hanya bisa diunggah saat status MenungguBayar.');
        abort_if($order->customer->user_id !== $request->user()->id, 403, 'Order ini milik akun lain.');

        $request->validate(['bukti' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048']]);
        $order->update([
            'bukti_path' => $request->file('bukti')->store('bukti-sparepart', 'local'),
        ]);

        SendWaJob::dispatch($order->customer->telp, Notifikasi::spoBukti($order));

        return redirect()->route('sparepart.order.show', $order->no_spo)->with('sukses', 'Bukti diterima dan menunggu konfirmasi admin.');
    }

    public function confirm(Request $request, SparepartOrder $order)
    {
        $data = $request->validate(['aksi' => ['required', 'in:lunas,batal']]);

        DB::transaction(function () use ($data, $order) {
            if ($data['aksi'] === 'batal' && $order->status === 'MenungguBayar') {
                foreach ($order->items as $item) {
                    $item->sparepart->increment('stok', $item->qty);
                }
                $order->update(['status' => 'Batal']);
            } elseif ($data['aksi'] === 'lunas' && $order->status === 'MenungguBayar') {
                $order->update(['status' => 'Lunas']);
            }
        });

        SendWaJob::dispatch($order->customer->telp, $data['aksi'] === 'lunas'
            ? Notifikasi::spoLunas($order)
            : Notifikasi::spoBatal($order));

        return back()->with('sukses', 'Status order diperbarui.');
    }
}
