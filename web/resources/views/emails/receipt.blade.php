<div style="max-width:600px;margin:auto;font-family:Arial,sans-serif;background:#f6f9fc;padding:20px">
    <div style="text-align:center;background:#fff;padding:14px;border-radius:8px;border-top:4px solid #C1121F">
        <img src="cid:logo_ayoto" alt="Ayoto Nippon" style="height:58px"><br><b style="font-size:18px">AYOTO NIPPON</b><br><small style="color:#666">DEALER MOBIL</small>
    </div>
    <div style="background:#fff;border-radius:8px;padding:28px;margin-top:12px">
        <p style="color:#888;margin:0">Tanda terima dari Ayoto Nippon</p>
        <h1 style="margin:6px 0">Rp {{ number_format($order->invoice->total, 0, ',', '.') }}</h1>
        <p style="color:#888;margin:0">Lunas {{ $order->verified_at?->format('d M Y') }} - Transfer Bank</p>
        <hr style="border:none;border-top:1px solid #eee">
        <div style="font-size:14px;color:#333;background:#f8f9fa;padding:16px;border-radius:6px">
            <b>Receipt #{{ $order->invoice->no_inv }}</b> | {{ $order->no_spk }}<br><br>
            Unit: <b>{{ $order->unit->variant->carModel->brand->nama }} {{ $order->unit->variant->carModel->nama }} {{ $order->unit->variant->nama }}</b><br>
            Warna: {{ $order->unit->color->nama }}<br>
            Metode: {{ $order->metode }}{{ $order->tenor ? ' | Tenor: '.$order->tenor.' bulan' : '' }}<br>
            Sales: {{ $salesNama }}<br>
            Customer: {{ $order->customer->nama }}<br><br>
            Total: Rp {{ number_format($order->invoice->total, 0, ',', '.') }}<br><b>Status: Lunas (Deal)</b>
        </div>
        <p style="font-size:12px;color:#888">Ada pertanyaan? Hubungi {{ $order->branch->nama }}{{ $order->branch->telp ? ' ('.$order->branch->telp.')' : '' }}.</p>
    </div>
</div>
