<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\CarModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CarModelController extends Controller
{
    public function index()
    {
        $models = CarModel::with(['brand', 'variants'])->orderBy('nama')->paginate(15);

        return view('admin.models.index', compact('models'));
    }

    public function create()
    {
        return view('admin.models.form', [
            'model' => new CarModel(),
            'brands' => Brand::orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['nama']);
        CarModel::create($data);

        return redirect()->route('admin.models.index')->with('sukses', 'Model berhasil ditambah.');
    }

    public function edit(CarModel $model)
    {
        return view('admin.models.form', [
            'model' => $model,
            'brands' => Brand::orderBy('nama')->get(),
        ]);
    }

    public function update(Request $request, CarModel $model)
    {
        $model->update($this->validated($request));

        return redirect()->route('admin.models.index')->with('sukses', 'Model berhasil diperbarui.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'brand_id' => ['required', 'exists:brands,id'],
            'nama' => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string'],
            'aktif' => ['nullable', 'boolean'],
        ]);
        $data['aktif'] = $request->boolean('aktif');

        return $data;
    }
}
