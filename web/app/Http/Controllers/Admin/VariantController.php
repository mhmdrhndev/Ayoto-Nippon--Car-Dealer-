<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarModel;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VariantController extends Controller
{
    public function index()
    {
        $variants = Variant::with('carModel.brand')->orderBy('nama')->paginate(15);

        return view('admin.variants.index', compact('variants'));
    }

    public function create()
    {
        return view('admin.variants.form', [
            'variant' => new Variant(),
            'models' => CarModel::with('brand')->orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug(($data['nama'] ?? '').'-'.now()->format('YmdHis'));
        Variant::create($data);

        return redirect()->route('admin.variants.index')->with('sukses', 'Varian berhasil ditambah.');
    }

    public function edit(Variant $variant)
    {
        return view('admin.variants.form', [
            'variant' => $variant,
            'models' => CarModel::with('brand')->orderBy('nama')->get(),
        ]);
    }

    public function update(Request $request, Variant $variant)
    {
        $variant->update($this->validated($request));

        return redirect()->route('admin.variants.index')->with('sukses', 'Varian berhasil diperbarui.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'car_model_id' => ['required', 'exists:car_models,id'],
            'nama' => ['required', 'string', 'max:100'],
            'transmisi' => ['required', 'in:MT,AT,CVT'],
            'bbm' => ['required', 'string', 'max:30'],
            'aktif' => ['nullable', 'boolean'],
        ]) + ['aktif' => $request->boolean('aktif')];
    }
}
