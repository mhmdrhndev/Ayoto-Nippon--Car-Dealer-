<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Lead;
use App\Models\LeasingPartner;
use App\Models\PriceList;
use App\Models\Variant;
use Illuminate\Http\Request;

class SimulasiController extends Controller
{
    public function form(Request $request)
    {
        $variants = Variant::with('carModel.brand')->where('aktif', true)->orderBy('nama')->get();
        $leasings = LeasingPartner::where('aktif', true)->orderBy('nama')->get();
        $branches = Branch::where('aktif', true)->orderBy('nama')->get();
        $prices = PriceList::all(['variant_id', 'branch_id', 'otr']);
        $variantId = $request->query('variant_id');
        if ($variantId && ! $variants->contains('id', (int) $variantId)) {
            $variantId = null;
        }

        return view('simulasi.form', compact('variants', 'leasings', 'branches', 'prices', 'variantId'));
    }

    public function hitung(Request $request)
    {
        $data = $request->validate([
            'variant_id' => ['required', 'exists:variants,id'],
            'branch_id' => ['required', 'exists:branches,id'],
            'dp' => ['required', 'integer', 'min:0'],
            'tenor' => ['required', 'integer', 'in:12,24,36,48'],
            'leasing_id' => ['required', 'exists:leasing_partners,id'],
        ]);

        $variant = Variant::with('carModel.brand')->findOrFail($data['variant_id']);
        $leasing = LeasingPartner::findOrFail($data['leasing_id']);
        $otr = (int) $variant->priceLists()->where('branch_id', $data['branch_id'])->value('otr');

        abort_if($otr <= 0, 422, 'Harga OTR belum tersedia untuk varian dan cabang ini.');
        abort_if($data['dp'] < $otr * $leasing->dp_min_persen / 100, 422, 'DP kurang dari minimum leasing.');

        $pokok = $otr - $data['dp'];
        $angsuran = (int) round(($pokok + $pokok * $leasing->bunga_dasar / 100 * $data['tenor'] / 12) / $data['tenor']);

        Lead::create([
            'sumber' => 'Web',
            'status' => 'Baru',
            'kebutuhan_text' => "Simulasi: {$variant->carModel->brand->nama} {$variant->carModel->nama} {$variant->nama}, OTR Rp ".number_format($otr, 0, ',', '.').", DP Rp ".number_format($data['dp'], 0, ',', '.').", tenor {$data['tenor']} bln, {$leasing->nama}, estimasi Rp ".number_format($angsuran, 0, ',', '.').'/bln',
        ]);

        $hasil = compact('variant', 'leasing', 'otr', 'angsuran') + $data;
        if ($request->expectsJson()) {
            return response()->json(['html' => view('simulasi.hasil-inline', $hasil)->render()]);
        }

        return view('simulasi.hasil', $hasil);
    }
}
