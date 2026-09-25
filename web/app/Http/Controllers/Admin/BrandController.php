<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::withCount('carModels')->orderBy('nama')->paginate(15);

        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.form', ['brand' => new Brand()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['nama']);
        Brand::create($data);

        return redirect()->route('admin.brands.index')->with('sukses', 'Brand berhasil ditambah.');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.form', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $brand->update($this->validated($request));

        return redirect()->route('admin.brands.index')->with('sukses', 'Brand berhasil diperbarui.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'logo' => ['nullable', 'string', 'max:255'],
            'aktif' => ['nullable', 'boolean'],
        ]);
        $data['aktif'] = $request->boolean('aktif');

        return $data;
    }
}
