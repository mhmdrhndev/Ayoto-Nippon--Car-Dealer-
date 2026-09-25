<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\Branch;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    public function index()
    {
        $accounts = BankAccount::with('branch')->latest()->paginate(15);

        return view('admin.bank-accounts.index', compact('accounts'));
    }

    public function create()
    {
        return view('admin.bank-accounts.form', [
            'account' => new BankAccount(),
            'branches' => Branch::where('aktif', true)->orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request)
    {
        BankAccount::create($this->validated($request));

        return redirect()->route('admin.bank-accounts.index')->with('sukses', 'Rekening berhasil ditambah.');
    }

    public function edit(BankAccount $bankAccount)
    {
        return view('admin.bank-accounts.form', [
            'account' => $bankAccount,
            'branches' => Branch::where('aktif', true)->orderBy('nama')->get(),
        ]);
    }

    public function update(Request $request, BankAccount $bankAccount)
    {
        $bankAccount->update($this->validated($request));

        return redirect()->route('admin.bank-accounts.index')->with('sukses', 'Rekening berhasil diperbarui.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'branch_id' => ['required', 'exists:branches,id'],
            'bank' => ['required', 'string', 'max:50'],
            'no_rek' => ['required', 'string', 'max:30'],
            'atas_nama' => ['required', 'string', 'max:100'],
            'aktif' => ['nullable', 'boolean'],
        ]);
        $data['aktif'] = $request->boolean('aktif');

        return $data;
    }
}
