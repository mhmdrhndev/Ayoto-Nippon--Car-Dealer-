<?php

namespace App\Http\Controllers;

use App\Jobs\SendMailJob;
use App\Jobs\SendWaJob;
use App\Models\Customer;
use App\Models\Lead;
use App\Models\Order;
use App\Models\TradeIn;
use App\Models\User;
use App\Support\Notifikasi;
use Illuminate\Http\Request;

class TradeInController extends Controller
{
    public function index()
    {
        $trades = TradeIn::with(['customer', 'order'])->latest()->paginate(15);

        return view('admin.trade-ins.index', compact('trades'));
    }

    public function create(Request $request)
    {
        $orders = collect();
        if ($request->user()) {
            $niks = Customer::where('user_id', $request->user()->id)->pluck('id');
            $orders = Order::whereIn('customer_id', $niks)->aktif()->get(['id', 'no_spk']);
        }

        return view('trade-in.create', compact('orders'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'nik' => ['required', 'digits:16'],
            'telp' => ['required', 'regex:/^[0-9]{10,15}$/'],
            'alamat' => ['required', 'string'],
            'merk_tipe' => ['required', 'string', 'max:100'],
            'tahun' => ['required', 'integer', 'min:1990', 'max:2100'],
            'km' => ['required', 'integer', 'min:0'],
            'foto' => ['nullable', 'array', 'max:3'],
            'foto.*' => ['file', 'mimes:jpg,jpeg,png', 'max:2048'],
            'order_id' => ['nullable', 'exists:orders,id'],
        ]);

        $customer = Customer::firstOrCreate(
            ['nik' => $data['nik']],
            ['user_id' => $request->user()?->id, 'nama' => $data['nama'], 'telp' => $data['telp'], 'alamat' => $data['alamat']]
        );

        $paths = [];
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $paths[] = $file->store('trade-in', 'local');
            }
        }

        $tradeIn = TradeIn::create([
            'customer_id' => $customer->id,
            'order_id' => $data['order_id'] ?? null,
            'merk_tipe' => $data['merk_tipe'],
            'tahun' => $data['tahun'],
            'km' => $data['km'],
            'foto_paths' => $paths,
            'status' => 'Diajukan',
        ]);

        Lead::create([
            'customer_id' => $customer->id,
            'sumber' => 'Web',
            'status' => 'Baru',
            'kebutuhan_text' => "Trade-in {$tradeIn->merk_tipe} tahun {$tradeIn->tahun}, KM {$tradeIn->km}",
        ]);

        $tradeIn->load('customer');
        foreach (User::role('admin-cabang')->whereNotNull('email')->get() as $admin) {
            if (! ($ke = Notifikasi::emailStaf($admin->email))) {
                continue;
            }
            SendMailJob::dispatch($ke, 'Pengajuan trade-in baru',
                view('emails.notifikasi', [
                    'judul' => 'Pengajuan trade-in baru',
                    'baris' => explode("\n", Notifikasi::tradeInBaruUntukAdmin($tradeIn)),
                    'tombol' => null,
                    'kontak' => null,
                ])->render(), [], true);
        }

        return redirect()->route('home')->with('sukses', 'Pengajuan trade-in diterima. Tim kami akan menghubungi untuk inspeksi.');
    }

    public function update(Request $request, TradeIn $tradeIn)
    {
        $data = $request->validate([
            'status' => ['required', 'in:Inspeksi,Ditawar,Deal,Ditolak'],
            'harga_penawaran' => ['required_if:status,Ditawar,Deal', 'nullable', 'integer', 'min:0'],
        ]);

        $tradeIn->update($data);

        $fresh = $tradeIn->fresh();
        SendWaJob::dispatch($fresh->customer->telp, Notifikasi::tradeInStatusUntukCustomer($fresh));
        if ($email = $fresh->customer->user?->email) {
            SendMailJob::dispatch($email, "Status trade-in: {$fresh->status}",
                view('emails.notifikasi', [
                    'judul' => "Status trade-in: {$fresh->status}",
                    'baris' => explode("\n", Notifikasi::tradeInStatusUntukCustomer($fresh)),
                    'tombol' => null,
                    'kontak' => null,
                ])->render(), [], true);
        }

        return back()->with('sukses', 'Status trade-in diperbarui.');
    }
}
