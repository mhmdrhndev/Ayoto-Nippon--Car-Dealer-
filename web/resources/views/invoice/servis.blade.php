<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Invoice Servis {{ $service->no_svc }}</title>
@php
    $logo = base64_encode(file_get_contents(public_path('images/logo-an.png')));
@endphp
<style>
    body { font-family: Helvetica, Arial, sans-serif; font-size: 10.5pt; color: #1F2937; margin: 0; }
    .page { padding: 28px 34px; }
    .head { background: #C1121F; color: #fff; padding: 18px 22px; }
    .head table { width: 100%; }
    .brand { font-size: 15pt; font-weight: bold; letter-spacing: .5px; }
    .sub { font-size: 8.5pt; color: rgba(255,255,255,.85); letter-spacing: 2px; text-transform: uppercase; }
    .doctitle { color: #fff; text-align: right; }
    .doctitle .judul { font-size: 13pt; font-weight: bold; letter-spacing: 1px; }
    .doctitle .meta { font-size: 8.5pt; color: rgba(255,255,255,.9); }
    .logo-wrap { background: #fff; display: inline-block; padding: 4px 6px; border-radius: 4px; }
    .info { width: 100%; margin-top: 18px; border-collapse: collapse; }
    .info td { padding: 3px 0; vertical-align: top; }
    .info .lbl { color: #6B7280; width: 130px; font-size: 9pt; }
    .info .val { font-weight: bold; color: #111827; }
    table.rincian { width: 100%; border-collapse: collapse; margin-top: 20px; }
    table.rincian th { background: #F3F4F6; color: #374151; font-size: 9pt; text-transform: uppercase; letter-spacing: 1px; text-align: left; padding: 8px 10px; border-bottom: 2px solid #C1121F; }
    table.rincian td { padding: 9px 10px; border-bottom: 1px solid #E5E7EB; font-size: 10pt; vertical-align: top; }
    table.rincian .kanan { text-align: right; white-space: nowrap; }
    table.total { width: 100%; border-collapse: collapse; margin-top: 6px; }
    table.total td { padding: 6px 10px; font-size: 10pt; }
    table.total .kanan { text-align: right; white-space: nowrap; }
    table.total .baris { border-top: 2px solid #111827; font-weight: bold; font-size: 12pt; color: #111827; }
    table.total .angka { color: #C1121F; }
    .ttd { margin-top: 34px; width: 100%; }
    .ttd td { width: 50%; vertical-align: top; text-align: center; font-size: 9.5pt; }
    .ttd .nama { border-top: 1px solid #9CA3AF; margin: 54px auto 2px; width: 200px; padding-top: 4px; font-weight: bold; }
    .footer { margin-top: 26px; border-top: 3px solid #C1121F; padding-top: 8px; font-size: 8.5pt; color: #6B7280; }
</style>
</head>
<body>
<div class="page">
    <div class="head">
        <table>
            <tr>
                <td>
                    <span class="logo-wrap"><img src="data:image/png;base64,{{ $logo }}" style="height:40px"></span>
                    <div class="brand">PT AYOTO NIPPON</div>
                    <div class="sub">Bengkel Resmi</div>
                </td>
                <td class="doctitle">
                    <div class="judul">INVOICE SERVIS</div>
                    <div class="meta">No. {{ $service->no_svc }} &middot; {{ $service->updated_at->format('d M Y') }}</div>
                    <div class="meta">Status: Selesai</div>
                </td>
            </tr>
        </table>
    </div>

    <table class="info">
        <tr><td class="lbl">Diterima dari</td><td class="val">{{ $service->customer->nama }}</td></tr>
        <tr><td class="lbl">No. polisi / VIN</td><td class="val">{{ $service->nopol }}{{ $service->vin ? ' / '.$service->vin : '' }}</td></tr>
        <tr><td class="lbl">Kilometer</td><td>{{ number_format($service->km, 0, ',', '.') }} km</td></tr>
        <tr><td class="lbl">Keluhan</td><td>{{ $service->keluhan }}</td></tr>
        <tr><td class="lbl">Cabang</td><td>{{ $service->branch->nama }}</td></tr>
        <tr><td class="lbl">Mekanik</td><td>{{ $service->mekanik->name ?? '-' }}</td></tr>
        <tr><td class="lbl">Metode bayar</td><td class="val">{{ $service->metode_bayar ?? '-' }}</td></tr>
    </table>

    <table class="rincian">
        <tr><th>Uraian</th><th class="kanan">Qty</th><th class="kanan">Subtotal</th></tr>
        @forelse ($service->details as $detail)
            <tr>
                <td>[{{ $detail->jenis }}] {{ $detail->deskripsi }} @ Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                <td class="kanan">{{ $detail->qty }}</td>
                <td class="kanan">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr><td colspan="3">Jasa servis berkala tanpa penggantian sparepart.</td></tr>
        @endforelse
    </table>
    <table class="total">
        <tr class="baris">
            <td>Total servis</td>
            <td class="kanan angka">Rp {{ number_format($service->total(), 0, ',', '.') }}</td>
        </tr>
    </table>

    <table class="ttd">
        <tr>
            <td>
                <div class="nama">{{ $service->customer->nama }}</div>
                <div>Pelanggan</div>
            </td>
            <td>
                <div class="nama">{{ $service->branch->nama }}</div>
                <div>Bengkel, {{ $service->updated_at->format('d M Y H:i') }}</div>
            </td>
        </tr>
    </table>

    <div class="footer">
        PT Ayoto Nippon &middot; {{ $service->branch->nama }} &middot; {{ $service->branch->alamat }} &middot; {{ $service->branch->telp ? 'Telp '.$service->branch->telp : '' }}<br>
        Dokumen ini diterbitkan otomatis oleh sistem bengkel Ayoto Nippon saat servis dinyatakan selesai.
    </div>
</div>
</body>
</html>
