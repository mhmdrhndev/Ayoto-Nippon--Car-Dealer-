<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public const STATUS = ['MenungguBayar', 'MenungguVerifikasi', 'Deal', 'Lunas', 'Batal', 'Expired', 'Ditolak'];

    public function index(Request $request)
    {
        $status = $request->query('status');

        $orders = Order::with(['customer', 'unit.variant.carModel.brand', 'unit.color', 'branch', 'invoice'])
            ->when(in_array($status, self::STATUS, true), function ($q) use ($status) {
                if ($status === 'Lunas') {
                    return $q->whereHas('invoice', fn ($i) => $i->whereNotNull('lunas_at'));
                }
                if (in_array($status, ['Batal', 'Expired', 'Ditolak'], true)) {
                    return $q->whereIn('status', ['Batal', 'Expired', 'Ditolak']);
                }

                return $q->where('status', $status);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.pesanan.index', ['orders' => $orders, 'status' => $status, 'daftarStatus' => self::STATUS]);
    }

    public function update(Request $request, Order $order)
    {
        abort_if($order->status !== 'Deal', 422, 'Jadwal serah terima hanya untuk SPK berstatus Deal.');

        $data = $request->validate([
            'jadwal_serah_at' => ['nullable', 'date'],
            'stnk_selesai_at' => ['nullable', 'date'],
        ]);

        $order->update($data);
        ActivityLog::catat('jadwal serah terima', 'Order', $order->id, "Jadwal serah terima SPK {$order->no_spk} diperbarui.");

        return back()->with('sukses', 'Jadwal serah terima SPK '.$order->no_spk.' tersimpan.');
    }
}
