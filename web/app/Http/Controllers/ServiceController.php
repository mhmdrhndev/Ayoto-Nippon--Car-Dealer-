<?php

namespace App\Http\Controllers;

use App\Jobs\SendWaJob;
use App\Support\Notifikasi;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\ServiceBooking;
use App\Models\Sparepart;
use App\Models\User;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public const SLOT_LIMIT = 5;

    public function index(Request $request)
    {
        $bookings = ServiceBooking::with(['customer', 'branch', 'mekanik'])
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->latest()->paginate(15)->withQueryString();

        return view('admin.services.index', compact('bookings'));
    }

    public function show(ServiceBooking $service)
    {
        $service->load(['customer', 'branch', 'mekanik', 'details.sparepart']);
        $mekaniks = User::role('mekanik')->orderBy('name')->get();
        $parts = Sparepart::with('branch')->where('aktif', true)->orderBy('nama')->get();

        return view('admin.services.show', compact('service', 'mekaniks', 'parts'));
    }

    public function create()
    {
        $branches = Branch::where('aktif', true)->orderBy('nama')->get();

        return view('servis.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'nik' => ['required', 'digits:16'],
            'telp' => ['required', 'regex:/^[0-9]{10,15}$/'],
            'alamat' => ['required', 'string'],
            'branch_id' => ['required', 'exists:branches,id'],
            'nopol' => ['required', 'string', 'max:15'],
            'vin' => ['nullable', 'string', 'max:30'],
            'km' => ['required', 'integer', 'min:0'],
            'keluhan' => ['required', 'string'],
            'jadwal' => ['required', 'date', 'after:now'],
        ]);

        $jadwal = new \DateTime($data['jadwal']);
        $penuh = ServiceBooking::where('branch_id', $data['branch_id'])
            ->where('status', '!=', 'Batal')
            ->whereBetween('jadwal', [$jadwal->format('Y-m-d H:00:00'), $jadwal->format('Y-m-d H:59:59')])
            ->count() >= self::SLOT_LIMIT;

        abort_if($penuh, 422, 'Slot jam tersebut di cabang ini sudah penuh. Pilih jam lain.');

        $booking = DB::transaction(function () use ($data, $request) {
            $customer = Customer::firstOrCreate(
                ['nik' => $data['nik']],
                ['user_id' => $request->user()?->id, 'nama' => $data['nama'], 'telp' => $data['telp'], 'alamat' => $data['alamat']]
            );

            $tahun = now()->format('Y');
            $seq = ServiceBooking::where('no_svc', 'like', "SVC-{$tahun}-%")->lockForUpdate()->count() + 1;

            return ServiceBooking::create([
                'no_svc' => sprintf('SVC-%s-%04d', $tahun, $seq),
                'customer_id' => $customer->id,
                'branch_id' => $data['branch_id'],
                'nopol' => strtoupper($data['nopol']),
                'vin' => $data['vin'] ?? null,
                'km' => $data['km'],
                'keluhan' => $data['keluhan'],
                'jadwal' => $data['jadwal'],
                'status' => 'Menunggu',
            ]);
        });

        return redirect()->route('home')->with('sukses', "Booking servis {$booking->no_svc} diterima. Datang sesuai jadwal {$booking->jadwal->format('d M Y H:i')}.");
    }

    public function update(Request $request, ServiceBooking $service)
    {
        $data = $request->validate([
            'status' => ['required', 'in:Dikonfirmasi,Dikerjakan,Selesai,Batal'],
            'estimasi_biaya' => ['nullable', 'integer', 'min:0'],
            'mekanik_id' => ['nullable', 'exists:users,id'],
        ]);

        DB::transaction(function () use ($data, $service) {
            if ($data['status'] === 'Selesai') {
                foreach ($service->details()->where('jenis', 'Sparepart')->get() as $detail) {
                    $sp = $detail->sparepart;
                    abort_if(!$sp || $sp->stok < $detail->qty, 422, "Stok {$detail->deskripsi} tidak cukup.");
                    $sp->decrement('stok', $detail->qty);
                }
            }
            $service->update([
                'status' => $data['status'],
                'estimasi_biaya' => $data['estimasi_biaya'] ?? $service->estimasi_biaya,
                'mekanik_id' => $data['mekanik_id'] ?? $service->mekanik_id,
            ]);
        });

        $fresh = $service->fresh();
        if (in_array($fresh->status, ['Dikonfirmasi', 'Selesai'])) {
            $pesan = $fresh->status === 'Selesai'
                ? Notifikasi::servisSelesai($fresh, $fresh->total())
                : Notifikasi::servisDikonfirmasi($fresh);
            SendWaJob::dispatch($fresh->customer->telp, $pesan);
        }

        return back()->with('sukses', 'Status servis diperbarui.');
    }

    public function addDetail(Request $request, ServiceBooking $service)
    {
        abort_if(in_array($service->status, ['Selesai', 'Batal']), 422, 'Servis yang sudah selesai atau batal tidak bisa ditambah.');

        $data = $request->validate([
            'jenis' => ['required', 'in:Pekerjaan,Sparepart'],
            'sparepart_id' => ['required_if:jenis,Sparepart', 'nullable', 'exists:spareparts,id'],
            'deskripsi' => ['required_unless:jenis,Sparepart', 'nullable', 'string', 'max:255'],
            'qty' => ['required', 'integer', 'min:1'],
            'harga_satuan' => ['required_unless:jenis,Sparepart', 'nullable', 'integer', 'min:0'],
        ]);

        if ($data['jenis'] === 'Sparepart') {
            $sp = Sparepart::findOrFail($data['sparepart_id']);
            $deskripsi = $sp->nama;
            $harga = $sp->harga;
        } else {
            $deskripsi = $data['deskripsi'];
            $harga = $data['harga_satuan'];
        }

        $service->details()->create([
            'jenis' => $data['jenis'],
            'deskripsi' => $deskripsi,
            'qty' => $data['qty'],
            'harga_satuan' => $harga,
            'subtotal' => $harga * $data['qty'],
            'sparepart_id' => $data['sparepart_id'] ?? null,
        ]);

        return back()->with('sukses', 'Detail servis ditambah.');
    }
}
