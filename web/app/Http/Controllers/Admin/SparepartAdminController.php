<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Sparepart;
use Illuminate\Http\Request;

class SparepartAdminController extends Controller
{
    public function index()
    {
        $parts = Sparepart::with('branch')->latest()->paginate(15);

        return view('admin.spareparts.index', compact('parts'));
    }

    public function create()
    {
        return view('admin.spareparts.form', [
            'part' => new Sparepart(),
            'branches' => Branch::where('aktif', true)->orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request)
    {
        Sparepart::create($this->validated($request));

        return redirect()->route('admin.spareparts.index')->with('sukses', 'Sparepart berhasil ditambah.');
    }

    public function edit(Sparepart $sparepart)
    {
        return view('admin.spareparts.form', [
            'part' => $sparepart,
            'branches' => Branch::where('aktif', true)->orderBy('nama')->get(),
        ]);
    }

    public function update(Request $request, Sparepart $sparepart)
    {
        $sparepart->update($this->validated($request));

        return redirect()->route('admin.spareparts.index')->with('sukses', 'Sparepart berhasil diperbarui.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'branch_id' => ['required', 'exists:branches,id'],
            'kode' => ['nullable', 'string', 'max:50'],
            'nama' => ['required', 'string', 'max:150'],
            'harga' => ['required', 'integer', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
            'aktif' => ['nullable', 'boolean'],
        ]);
        $data['aktif'] = $request->boolean('aktif');

        return $data;
    }
}
