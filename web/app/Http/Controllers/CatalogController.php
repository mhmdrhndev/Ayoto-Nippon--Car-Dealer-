<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\LeasingPartner;
use App\Models\Promo;
use App\Models\Unit;
use App\Models\Variant;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function home()
    {
        $brands = Brand::where('aktif', true)->whereHas('carModels.variants', fn ($q) => $q->where('aktif', true))->orderBy('id')->get();
        $branches = Branch::where('aktif', true)->orderBy('nama')->get();
        $totalUnit = Unit::tersedia()->count();
        $promos = Promo::berjalan()->orderBy('selesai')->limit(3)->get();

        return view('home', compact('brands', 'branches', 'totalUnit', 'promos'));
    }

    public function index(Request $request)
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'brand' => ['nullable', 'string', 'max:50'],
            'transmisi' => ['nullable', 'in:MT,AT,CVT'],
            'bbm' => ['nullable', 'string', 'max:30'],
            'cabang' => ['nullable', 'string', 'max:20'],
            'harga_min' => ['nullable', 'integer', 'min:0'],
            'harga_maks' => ['nullable', 'integer', 'min:0'],
        ]);

        $vFilter = function ($q) use ($validated) {
            $q->where('aktif', true)
                ->when($validated['transmisi'] ?? null, fn ($qq, $t) => $qq->where('transmisi', $t))
                ->when($validated['bbm'] ?? null, fn ($qq, $b) => $qq->where('bbm', $b))
                ->when($validated['q'] ?? null, fn ($qq, $s) => $qq->where('nama', 'like', "%{$s}%"))
                ->when($validated['cabang'] ?? null, fn ($qq, $kode) => $qq->whereHas('priceLists.branch', fn ($qqq) => $qqq->where('kode', $kode)))
                ->when($validated['harga_min'] ?? null, fn ($qq, $min) => $qq->whereHas('priceLists', fn ($qqq) => $qqq->where('otr', '>=', $min)))
                ->when($validated['harga_maks'] ?? null, fn ($qq, $maks) => $qq->whereHas('priceLists', fn ($qqq) => $qqq->where('otr', '<=', $maks)));
        };

        $models = CarModel::with(['brand', 'variants' => $vFilter, 'variants.priceLists.branch', 'variants.units'])
            ->where('aktif', true)
            ->when($validated['brand'] ?? null, fn ($q, $slug) => $q->whereHas('brand', fn ($qq) => $qq->where('slug', $slug)))
            ->when($validated['q'] ?? null, fn ($q, $s) => $q->where('nama', 'like', "%{$s}%")
                ->orWhereHas('brand', fn ($qq) => $qq->where('nama', 'like', "%{$s}%"))
                ->orWhereHas('variants', fn ($qq) => $qq->where('nama', 'like', "%{$s}%")))
            ->whereHas('variants', $vFilter)
            ->orderBy('nama')
            ->paginate(12)
            ->withQueryString();

        $brands = Brand::where('aktif', true)->whereHas('carModels.variants', fn ($q) => $q->where('aktif', true))->orderBy('nama')->get();
        $branches = Branch::where('aktif', true)->orderBy('nama')->get();
        $bbms = Variant::where('aktif', true)->distinct()->orderBy('bbm')->pluck('bbm');
        $totalUnit = Unit::tersedia()->count();
        $kodeCabang = $validated['cabang'] ?? null;

        return view('katalog.index', compact('models', 'brands', 'branches', 'bbms', 'totalUnit', 'kodeCabang'));
    }

    public function model(string $brand, string $model)
    {
        $m = CarModel::with(['brand', 'variants' => fn ($q) => $q->where('aktif', true)->orderBy('nama'), 'variants.priceLists.branch', 'variants.units'])
            ->where('slug', $model)
            ->where('aktif', true)
            ->whereHas('brand', fn ($q) => $q->where('slug', $brand))
            ->firstOrFail();

        $ringkasan = $this->ringkasanModel($m);
        $kategori = $this->kategoriModel($m);
        $mulai = $m->variants->flatMap->priceLists->pluck('otr')->filter()->min();

        return view('katalog.model', compact('m', 'ringkasan', 'kategori', 'mulai'));
    }

    public function show(string $slug)
    {
        $variant = Variant::with(['carModel.brand', 'priceLists.branch', 'units.color', 'units.branch'])
            ->where('slug', $slug)
            ->where('aktif', true)
            ->firstOrFail();

        $stok = Unit::tersedia()
            ->selectRaw('branch_id, count(*) as jumlah')
            ->where('variant_id', $variant->id)
            ->groupBy('branch_id')
            ->pluck('jumlah', 'branch_id');

        $warnaPerCabang = $variant->units->where('status', 'Tersedia')->groupBy('branch_id')
            ->map(fn ($units) => $units->map(fn ($u) => $u->color?->nama)->filter()->unique()->values());

        $leasings = LeasingPartner::where('aktif', true)->orderBy('nama')->get();

        return view('katalog.show', compact('variant', 'stok', 'warnaPerCabang', 'leasings'));
    }

    // Pecah deskripsi "Sedan 5 penumpang" jadi bodi dan kapasitas.
    private function kategoriModel(CarModel $m): ?array
    {
        if (! $m->deskripsi || ! preg_match('/^(.*)\s+(\d+)\s+penumpang$/', $m->deskripsi, $cocok)) {
            return null;
        }

        return ['body' => $cocok[1], 'kursi' => $cocok[2]];
    }

    // Ringkasan header halaman model dari data relasi yang sudah dimuat.
    private function ringkasanModel(CarModel $m): string
    {
        $jumlah = $m->variants->count();
        $transmisi = $m->variants->pluck('transmisi')->unique()->values()->join(', ');
        $bbm = $m->variants->pluck('bbm')->unique()->values()->join(', ');
        $otr = $m->variants->flatMap->priceLists->pluck('otr')->filter();
        $cabang = $m->variants->flatMap->units->where('status', 'Tersedia')->pluck('branch_id')->unique()->count();

        $kalimat = "{$jumlah} varian ({$transmisi}; {$bbm}).";
        if ($otr->isNotEmpty()) {
            $min = 'Rp '.number_format($otr->min(), 0, ',', '.');
            $kalimat .= $otr->min() === $otr->max()
                ? " Harga OTR {$min}."
                : ' Harga OTR '.$min.' sampai Rp '.number_format($otr->max(), 0, ',', '.').'.';
        } else {
            $kalimat .= ' Harga mengikuti cabang.';
        }
        $kalimat .= $cabang > 0 ? " Terpantau di {$cabang} cabang." : ' Belum terpantau stok tersedia.';

        return $kalimat;
    }
}
