<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Branch;
use App\Models\PriceList;
use App\Models\Variant;
use Illuminate\Http\Request;

class PriceListController extends Controller
{
    public function index()
    {
        $prices = PriceList::with(['variant.carModel.brand', 'branch'])->latest()->paginate(15);

        return view('admin.price-lists.index', compact('prices'));
    }

    public function create()
    {
        return view('admin.price-lists.form', [
            'price' => new PriceList(),
            'variants' => Variant::with('carModel.brand')->orderBy('nama')->get(),
            'branches' => Branch::where('aktif', true)->orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $price = PriceList::create($this->validated($request));
        ActivityLog::catat('tambah harga', 'PriceList', $price->id, "OTR Rp ".number_format($price->otr, 0, ',', '.'));

        return redirect()->route('admin.price-lists.index')->with('sukses', 'Harga berhasil ditambah.');
    }

    public function edit(PriceList $priceList)
    {
        return view('admin.price-lists.form', [
            'price' => $priceList,
            'variants' => Variant::with('carModel.brand')->orderBy('nama')->get(),
            'branches' => Branch::where('aktif', true)->orderBy('nama')->get(),
        ]);
    }

    public function update(Request $request, PriceList $priceList)
    {
        $lama = $priceList->otr;
        $priceList->update($this->validated($request, $priceList->id));
        ActivityLog::catat('ubah harga', 'PriceList', $priceList->id, "OTR Rp ".number_format($lama, 0, ',', '.')." menjadi Rp ".number_format($priceList->otr, 0, ',', '.'));

        return redirect()->route('admin.price-lists.index')->with('sukses', 'Harga berhasil diperbarui.');
    }

    private function validated(Request $request, ?int $ignore = null): array
    {
        return $request->validate([
            'variant_id' => ['required', 'exists:variants,id', 'unique:price_lists,variant_id'.($ignore ? ",{$ignore}" : '').',id,branch_id,'.$request->branch_id],
            'branch_id' => ['required', 'exists:branches,id'],
            'otr' => ['required', 'integer', 'min:0'],
            'bbn' => ['nullable', 'integer', 'min:0'],
            'diskon' => ['nullable', 'integer', 'min:0'],
            'berlaku_dari' => ['nullable', 'date'],
            'berlaku_sampai' => ['nullable', 'date', 'after_or_equal:berlaku_dari'],
        ]);
    }
}
