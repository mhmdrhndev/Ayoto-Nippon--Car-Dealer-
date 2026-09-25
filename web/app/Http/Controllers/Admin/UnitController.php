<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Color;
use App\Models\Unit;
use App\Models\Variant;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        $units = Unit::with(['variant.carModel.brand', 'color', 'branch'])
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->latest()->paginate(15)->withQueryString();

        return view('admin.units.index', compact('units'));
    }

    public function create()
    {
        return view('admin.units.form', [
            'unit' => new Unit(),
            'variants' => Variant::with('carModel.brand')->orderBy('nama')->get(),
            'colors' => Color::where('aktif', true)->orderBy('nama')->get(),
            'branches' => Branch::where('aktif', true)->orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        Unit::create($data);

        return redirect()->route('admin.units.index')->with('sukses', 'Unit berhasil ditambah.');
    }

    public function edit(Unit $unit)
    {
        return view('admin.units.form', [
            'unit' => $unit,
            'variants' => Variant::with('carModel.brand')->orderBy('nama')->get(),
            'colors' => Color::where('aktif', true)->orderBy('nama')->get(),
            'branches' => Branch::where('aktif', true)->orderBy('nama')->get(),
        ]);
    }

    public function update(Request $request, Unit $unit)
    {
        $unit->update($this->validated($request, $unit->id));

        return redirect()->route('admin.units.index')->with('sukses', 'Unit berhasil diperbarui.');
    }

    private function validated(Request $request, ?int $ignore = null): array
    {
        return $request->validate([
            'vin' => ['required', 'string', 'max:30', 'unique:units,vin'.($ignore ? ",{$ignore}" : '')],
            'variant_id' => ['required', 'exists:variants,id'],
            'color_id' => ['required', 'exists:colors,id'],
            'branch_id' => ['required', 'exists:branches,id'],
            'status' => ['required', 'in:Tersedia,Dipesan,Terjual'],
            'tahun_rakit' => ['required', 'integer', 'min:2000', 'max:2100'],
            'harga' => ['required', 'integer', 'min:0'],
            'foto_utama' => ['nullable', 'string', 'max:255'],
        ]);
    }
}
