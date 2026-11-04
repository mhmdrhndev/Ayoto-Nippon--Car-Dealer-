<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Kuitansi Pelunasan {{ $invoice->no_inv }}</title>
@php
    $logo = base64_encode(file_get_contents(public_path('images/logo-an.png')));
    $u = $invoice->order;
    $unit = $u->unit->variant->carModel->brand->nama.' '.$u->unit->variant->carModel->nama.' '.$u->unit->variant->nama;
    $pelunasan = $invoice->total - $u->booking_fee;
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
    table.rincian th { background: #16181D; color: #374151; font-size: 9pt; text-transform: uppercase; letter-spacing: 1px; text-align: left; padding: 8px 10px; border-bottom: 2px solid #C1121F; }
    table.rincian td { padding: 9px 10px; border-bottom: 1px solid #E5E7EB; font-size: 10pt; vertical-align: top; }
    table.rincian .kanan { text-align: right; white-space: nowrap; }
    table.total { width: 100%; border-collapse: collapse; margin-top: 6px; }
    table.total td { padding: 6px 10px; font-size: 10pt; }
    table.total .kanan { text-align: right; white-space: nowrap; }
    table.total .baris { border-top: 2px solid #111827; font-weight: bold; font-size: 12pt; color: #111827; }
    table.total .angka { color: #C1121F; }
    .ket { font-size: 8pt; color: #6B7280; margin-top: 4px; }
    .lunas-ok { display: inline-block; margin-top: 12px; padding: 6px 14px; background: #16181D; border: 1px solid #E5E7EB; border-left: 4px solid #111827; font-size: 9pt; font-weight: bold; letter-spacing: 1px; color: #111827; text-transform: uppercase; }
    .ttd { margin-top: 30px; width: 100%; }
    .ttd td { width: 50%; vertical-align: top; text-align: center; font-size: 9.5pt; }
    .ttd .nama { border-top: 1px solid #4B5563; margin: 54px auto 2px; width: 200px; padding-top: 4px; font-weight: bold; }
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
                    <div class="sub">Dealer Mobil</div>
                </td>
                <td class="doctitle">
                    <div class="judul">KUITANSI PELUNASAN</div>
                    <div class="meta">No. {{ $invoice->no_inv }} &middot; {{ $invoice->lunas_at?->format('d M Y') }}</div>
                    <div class="meta">Status SPK: Lunas</div>
                </td>
            </tr>
        </table>
    </div>

    <table class="info">
        <tr><td class="lbl">Diterima dari</td><td class="val">{{ $u->customer->nama }}</td></tr>
        <tr><td class="lbl">No. SPK</td><td class="val">{{ $u->no_spk }}</td></tr>
        <tr><td class="lbl">Unit</td><td class="val">{{ $unit }}</td></tr>
        <tr><td class="lbl">VIN</td><td>{{ $u->unit->vin }}</td></tr>
        <tr><td class="lbl">Cabang</td><td>{{ $u->branch->nama }}</td></tr>
    </table>

    <span class="lunas-ok">Lunas</span>

    <table class="rincian">
        <tr><th>Uraian</th><th class="kanan">Jumlah</th></tr>
        <tr>
            <td>Booking fee (diterima lebih awal)</td>
            <td class="kanan">Rp {{ number_format($u->booking_fee, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Pelunasan unit {{ $unit }} (VIN {{ $u->unit->vin }})</td>
            <td class="kanan">Rp {{ number_format($pelunasan, 0, ',', '.') }}</td>
        </tr>
    </table>
    <table class="total">
        <tr class="baris">
            <td>Total harga unit</td>
            <td class="kanan angka">Rp {{ number_format($invoice->total, 0, ',', '.') }}</td>
        </tr>
    </table>

    <table class="ttd">
        <tr>
            <td>
                <div class="nama">{{ $u->customer->nama }}</div>
                <div>Pemberi pembayaran</div>
            </td>
            <td>
                <div class="nama">{{ $pencatat }}</div>
                <div>Dicatat lunas, {{ $invoice->lunas_at?->format('d M Y H:i') }}</div>
            </td>
        </tr>
    </table>

    <div class="footer">
        PT Ayoto Nippon &middot; {{ $u->branch->nama }} &middot; {{ $u->branch->alamat }} &middot; {{ $u->branch->telp ? 'Telp '.$u->branch->telp : '' }}<br>
        Dokumen ini diterbitkan otomatis oleh sistem dealer Ayoto Nippon saat pencatatan pelunasan.
    </div>
</div>
</body>
</html>
