<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Kuitansi {{ $invoice->no_inv }}</title>
<style>
  body { font-family: sans-serif; font-size: 12pt; color: #000; }
  h1 { font-size: 18pt; border-bottom: 2px solid #000; padding-bottom: 6px; }
  table { width: 100%; border-collapse: collapse; margin-top: 12px; }
  td, th { border: 1px solid #000; padding: 6px 8px; text-align: left; }
</style>
</head>
<body>
<h1>Kuitansi Booking Fee - PT Ayoto Nippon</h1>
<p>No. Invoice: {{ $invoice->no_inv }}<br>Tanggal: {{ $invoice->created_at->format('d M Y') }}</p>
<table>
  <tr><th>Uraian</th><th>Keterangan</th></tr>
  <tr><td>Nomor SPK</td><td>{{ $invoice->order->no_spk }} (status Deal)</td></tr>
  <tr><td>Customer</td><td>{{ $invoice->order->customer->nama }}</td></tr>
  <tr><td>Unit</td><td>{{ $invoice->order->unit->variant->carModel->brand->nama }} {{ $invoice->order->unit->variant->carModel->nama }} {{ $invoice->order->unit->variant->nama }}, VIN {{ $invoice->order->unit->vin }}</td></tr>
  <tr><td>Cabang</td><td>{{ $invoice->order->branch->nama }}</td></tr>
  <tr><td>Booking fee diterima</td><td>Rp {{ number_format($invoice->order->booking_fee, 0, ',', '.') }}</td></tr>
  <tr><td>Harga unit</td><td>Rp {{ number_format($invoice->total, 0, ',', '.') }}</td></tr>
</table>
<p>Diverifikasi oleh {{ $invoice->order->verifier->name ?? '-' }} pada {{ $invoice->order->verified_at?->format('d M Y H:i') }}.</p>
</body>
</html>
