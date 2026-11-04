<?php

namespace App\Http\Controllers;

use App\Jobs\SendMailJob;
use App\Models\Lead;
use App\Models\Order;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->validate([
            'status' => ['nullable', 'in:Baru,Dihubungi,TestDrive,SPK,Deal,Lunas,Batal'],
            'sales' => ['nullable', 'exists:users,id'],
        ]);

        $leads = Lead::with(['customer', 'sales'])
            ->when($data['status'] ?? null, fn ($q, $s) => $q->where('status', $s))
            ->when($data['sales'] ?? null, fn ($q, $id) => $q->where('sales_id', $id))
            ->latest()->paginate(15)->withQueryString();

        $salesList = User::role('sales')->orderBy('name')->get();

        return view('admin.leads.index', compact('leads', 'salesList'));
    }

    public function show(Lead $lead)
    {
        $lead->load(['customer', 'sales', 'followups']);
        $salesList = User::role('sales')->orderBy('name')->get();

        return view('admin.leads.show', compact('lead', 'salesList'));
    }

    public function assign(Request $request, Lead $lead)
    {
        $data = $request->validate(['sales_id' => ['nullable', 'exists:users,id']]);
        $lead->update(['sales_id' => $data['sales_id']]);

        return back()->with('sukses', 'Sales berhasil ditetapkan.');
    }

    public function followup(Request $request, Lead $lead)
    {
        $data = $request->validate([
            'catatan' => ['required', 'string'],
            'status' => ['nullable', 'in:Baru,Dihubungi,TestDrive,SPK,Deal,Lunas,Batal'],
            'next_reminder' => ['nullable', 'date', 'after:now'],
        ]);

        $mintaUbah = ($data['status'] ?? null) !== null && $data['status'] !== $lead->status;
        abort_if($lead->status === 'Lunas' && $mintaUbah, 422, 'Status lead yang sudah Lunas tidak bisa diubah.');

        $lead->followups()->create([
            'sales_id' => $request->user()->id,
            'catatan' => $data['catatan'],
            'next_reminder' => $data['next_reminder'] ?? null,
        ]);

        $statusLama = $lead->status;
        $statusBaru = $data['status'] ?? $lead->status;
        $lead->update([
            'status' => $statusBaru,
            'followup_at' => $data['next_reminder'] ?? $lead->followup_at,
        ]);

        if ($statusLama !== 'Lunas' && $statusBaru === 'Lunas') {
            $this->kirimEmailLunas($lead, $request->user()->name);
        }

        return back()->with('sukses', 'Follow-up tersimpan.');
    }

    // Kuitansi pelunasan + email ke customer saat lead pertama kali ditandai Lunas.
    private function kirimEmailLunas(Lead $lead, string $pencatat): void
    {
        $email = $lead->customer?->user?->email;
        $order = Order::with(['customer', 'unit.variant.carModel.brand', 'unit.color', 'branch', 'invoice', 'verifier'])
            ->where('customer_id', $lead->customer_id)
            ->where('status', 'Deal')
            ->latest()
            ->first();
        if (! $email || ! $order || ! $order->invoice) {
            return;
        }
        $invoice = $order->invoice;
        if (! $invoice->lunas_pdf_path) {
            $invoice->update(['lunas_at' => now()]);
            $pdf = Pdf::loadView('invoice.lunas', ['invoice' => $invoice->fresh(), 'pencatat' => $pencatat]);
            $pdfPath = "invoices/{$invoice->no_inv}-lunas.pdf";
            Storage::disk('local')->put($pdfPath, $pdf->output());
            $invoice->update(['lunas_pdf_path' => $pdfPath]);
        }
        $salesNama = $lead->sales?->name ?? $order->customer->leads()->latest()->first()?->sales?->name ?? '-';
        $isi = view('emails.receipt', ['order' => $order->fresh(), 'salesNama' => $salesNama, 'tanggal' => $invoice->lunas_at])->render();
        SendMailJob::dispatch($email, "Pelunasan SPK {$order->no_spk} Lunas", $isi, [$invoice->lunas_pdf_path], true);
    }
}
