<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::orderBy('nama')->paginate(15);

        return view('admin.colors.index', compact('colors'));
    }

    public function create()
    {
        return view('admin.colors.form', ['color' => new Color()]);
    }

    public function store(Request $request)
    {
        Color::create($this->validated($request));

        return redirect()->route('admin.colors.index')->with('sukses', 'Warna berhasil ditambah.');
    }

    public function edit(Color $color)
    {
        return view('admin.colors.form', compact('color'));
    }

    public function update(Request $request, Color $color)
    {
        $color->update($this->validated($request));

        return redirect()->route('admin.colors.index')->with('sukses', 'Warna berhasil diperbarui.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:50'],
            'kode_hex' => ['nullable', 'string', 'max:10'],
            'aktif' => ['nullable', 'boolean'],
        ]);
        $data['aktif'] = $request->boolean('aktif');

        return $data;
    }
}
