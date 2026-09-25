<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::orderBy('nama')->paginate(15);

        return view('admin.branches.index', compact('branches'));
    }

    public function create()
    {
        return view('admin.branches.form', ['branch' => new Branch()]);
    }

    public function store(Request $request)
    {
        Branch::create($this->validated($request));

        return redirect()->route('admin.branches.index')->with('sukses', 'Cabang berhasil ditambah.');
    }

    public function edit(Branch $branch)
    {
        return view('admin.branches.form', compact('branch'));
    }

    public function update(Request $request, Branch $branch)
    {
        $branch->update($this->validated($request));

        return redirect()->route('admin.branches.index')->with('sukses', 'Cabang berhasil diperbarui.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'kode' => ['required', 'string', 'max:20'],
            'nama' => ['required', 'string', 'max:100'],
            'alamat' => ['nullable', 'string'],
            'telp' => ['nullable', 'string', 'max:20'],
            'maps_url' => ['nullable', 'string'],
            'booking_fee' => ['required', 'integer', 'min:0'],
            'aktif' => ['nullable', 'boolean'],
        ]);
        $data['aktif'] = $request->boolean('aktif');

        return $data;
    }
}
