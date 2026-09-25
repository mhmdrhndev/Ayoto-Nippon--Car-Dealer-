<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Lead;
use App\Models\Order;
use App\Models\TradeIn;
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

        return redirect()->route('home')->with('sukses', 'Pengajuan trade-in diterima. Tim kami akan menghubungi untuk inspeksi.');
    }

    public function update(Request $request, TradeIn $tradeIn)
    {
        $data = $request->validate([
            'status' => ['required', 'in:Inspeksi,Ditawar,Deal,Ditolak'],
            'harga_penawaran' => ['required_if:status,Ditawar,Deal', 'nullable', 'integer', 'min:0'],
        ]);

        $tradeIn->update($data);

        return back()->with('sukses', 'Status trade-in diperbarui.');
    }
}
