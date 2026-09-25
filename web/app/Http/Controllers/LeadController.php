<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->validate([
            'status' => ['nullable', 'in:Baru,Dihubungi,TestDrive,SPK,Deal,Batal'],
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
            'status' => ['nullable', 'in:Baru,Dihubungi,TestDrive,SPK,Deal,Batal'],
            'next_reminder' => ['nullable', 'date', 'after:now'],
        ]);

        $lead->followups()->create([
            'sales_id' => $request->user()->id,
            'catatan' => $data['catatan'],
            'next_reminder' => $data['next_reminder'] ?? null,
        ]);

        $lead->update([
            'status' => $data['status'] ?? $lead->status,
            'followup_at' => $data['next_reminder'] ?? $lead->followup_at,
        ]);

        return back()->with('sukses', 'Follow-up tersimpan.');
    }
}
