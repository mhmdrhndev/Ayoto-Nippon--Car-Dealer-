<?php

namespace App\Http\Controllers;

use App\Jobs\SendMailJob;
use App\Jobs\SendWaJob;
use App\Models\ActivityLog;
use App\Models\Invoice;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VerifyController extends Controller
{
    public function index()
    {
        $orders = Order::with(['customer', 'unit.variant.carModel.brand', 'branch'])
            ->where('status', 'MenungguVerifikasi')
            ->orderBy('updated_at')
            ->paginate(15);

        return view('admin.verify.index', compact('orders'));
    }

    public function update(Request $request, Order $order)
    {
        abort_if($order->status !== 'MenungguVerifikasi', 422, 'Hanya SPK MenungguVerifikasi yang bisa diverifikasi.');

        $data = $request->validate([
            'keputusan' => ['required', 'in:terima,tolak'],
            'tolak_aksi' => ['required_if:keputusan,tolak', 'nullable', 'in:perpanjang,batal'],
            'tolak_alasan' => ['required_if:keputusan,tolak', 'nullable', 'string'],
        ]);

        DB::transaction(function () use ($data, $order, $request) {
            if ($data['keputusan'] === 'terima') {
                $order->update([
                    'status' => 'Deal',
                    'verified_by' => $request->user()->id,
                    'verified_at' => now(),
                    'tolak_alasan' => null,
                ]);
                $order->unit()->update(['status' => 'Terjual']);
                $order->customer->leads()->latest()->first()?->update(['status' => 'Deal']);

                $tahun = now()->format('Y');
                $iseq = Invoice::where('no_inv', 'like', "INV-{$tahun}-%")->lockForUpdate()->count() + 1;
                $invoice = Invoice::create([
                    'no_inv' => sprintf('INV-%s-%04d', $tahun, $iseq),
                    'order_id' => $order->id,
                    'total' => $order->unit->harga,
                ]);
                $pdf = Pdf::loadView('invoice.pdf', ['invoice' => $invoice->load('order.customer', 'order.unit.variant.carModel.brand', 'order.branch', 'order.verifier')]);
                $pdfPath = "invoices/{$invoice->no_inv}.pdf";
                Storage::disk('local')->put($pdfPath, $pdf->output());
                $invoice->update(['pdf_path' => $pdfPath]);

                ActivityLog::catat('verifikasi terima', 'Order', $order->id, "SPK {$order->no_spk} Deal, invoice {$invoice->no_inv}");
            } else {
                $order->update([
                    'verified_by' => $request->user()->id,
                    'verified_at' => now(),
                    'tolak_alasan' => $data['tolak_alasan'],
                    'status' => $data['tolak_aksi'] === 'batal' ? 'Batal' : 'MenungguBayar',
                    'deadline_at' => $data['tolak_aksi'] === 'batal' ? $order->deadline_at : now()->addDay(),
                    'bukti_path' => $data['tolak_aksi'] === 'batal' ? $order->bukti_path : null,
                ]);
                if ($data['tolak_aksi'] === 'batal') {
                    $order->unit()->update(['status' => 'Tersedia']);
                }
            }
        });

        $fresh = $order->fresh();
        SendWaJob::dispatch($fresh->customer->telp, $fresh->status === 'Deal'
            ? "SPK {$fresh->no_spk} Deal. Unit sudah terkunci untuk Anda. Pelunasan sisa dilakukan di dealer."
            : "SPK {$fresh->no_spk} belum bisa diterima: {$fresh->tolak_alasan}");

        $email = $fresh->customer->user?->email;
        if ($email) {
            $lampiran = $fresh->status === 'Deal' && $fresh->invoice?->pdf_path ? [$fresh->invoice->pdf_path] : [];
            SendMailJob::dispatch($email, "Status SPK {$fresh->no_spk}: {$fresh->status}",
                $fresh->status === 'Deal' ? "SPK Anda Deal. Invoice {$fresh->invoice->no_inv} terlampir." : "SPK belum bisa diterima: {$fresh->tolak_alasan}",
                $lampiran);
        }

        if ($data['keputusan'] === 'tolak') {
            ActivityLog::catat('verifikasi tolak', 'Order', $order->id, "SPK {$order->no_spk}: {$data['tolak_alasan']}");
        }

        return redirect()->route('admin.verify.index')->with('sukses', 'Verifikasi SPK '.$order->no_spk.' tersimpan.');
    }

    public function bast(Request $request, Order $order)
    {
        abort_if($order->status !== 'Deal', 422, 'BAST hanya untuk SPK Deal.');

        $data = $request->validate([
            'bast' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        $order->update(['bast_path' => $request->file('bast')->store('bast', 'local')]);
        ActivityLog::catat('upload BAST', 'Order', $order->id, "BAST SPK {$order->no_spk} diunggah.");

        return back()->with('sukses', 'BAST serah terima tersimpan.');
    }

    public function invoice(Request $request, Invoice $invoice)
    {
        abort_if(!$invoice->pdf_path || !Storage::disk('local')->exists($invoice->pdf_path), 404);
        $milik = $invoice->order->customer->user_id !== null && $invoice->order->customer->user_id === $request->user()->id;
        $staf = $request->user()->hasAnyRole(['sales', 'admin-cabang', 'pimpinan', 'superadmin']);
        abort_if(!$milik && !$staf, 403, 'Invoice ini bukan milik Anda.');

        return Storage::disk('local')->download($invoice->pdf_path, $invoice->no_inv.'.pdf');
    }

    public function file(Order $order, string $jenis)
    {
        abort_unless(in_array($jenis, ['ktp', 'kk', 'bukti']), 404);

        $path = $jenis === 'ktp' ? $order->customer->ktp_path
            : ($jenis === 'kk' ? $order->customer->kk_path : $order->bukti_path);
        abort_if(!$path || !Storage::disk('local')->exists($path), 404, 'File tidak ditemukan.');

        return Storage::disk('local')->response($path);
    }
}
