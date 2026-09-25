<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeasingPartner;
use Illuminate\Http\Request;

class LeasingController extends Controller
{
    public function index()
    {
        $leasings = LeasingPartner::orderBy('nama')->paginate(15);

        return view('admin.leasings.index', compact('leasings'));
    }

    public function create()
    {
        return view('admin.leasings.form', ['leasing' => new LeasingPartner()]);
    }

    public function store(Request $request)
    {
        LeasingPartner::create($this->validated($request));

        return redirect()->route('admin.leasings.index')->with('sukses', 'Leasing berhasil ditambah.');
    }

    public function edit(LeasingPartner $leasing)
    {
        return view('admin.leasings.form', compact('leasing'));
    }

    public function update(Request $request, LeasingPartner $leasing)
    {
        $leasing->update($this->validated($request));

        return redirect()->route('admin.leasings.index')->with('sukses', 'Leasing berhasil diperbarui.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'telp' => ['nullable', 'string', 'max:20'],
            'dp_min_persen' => ['required', 'integer', 'min:0', 'max:100'],
            'tenor_list' => ['required', 'string', 'max:50'],
            'bunga_dasar' => ['required', 'numeric', 'min:0'],
            'aktif' => ['nullable', 'boolean'],
        ]);
        $data['aktif'] = $request->boolean('aktif');

        return $data;
    }
}
