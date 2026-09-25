<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Content;
use App\Models\Promo;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    public function promo(Request $request)
    {
        $promos = Promo::with('branch')->berjalan()
            ->when($request->cabang, fn ($q, $kode) => $q->where(fn ($qq) => $qq->whereHas('branch', fn ($qqq) => $qqq->where('kode', $kode))->orWhereNull('branch_id')))
            ->orderBy('selesai')->paginate(9)->withQueryString();

        $branches = Branch::where('aktif', true)->orderBy('nama')->get();

        return view('promo.index', compact('promos', 'branches'));
    }

    public function cabang()
    {
        $branches = Branch::with('bankAccounts')->where('aktif', true)->orderBy('nama')->get();

        return view('cabang.index', compact('branches'));
    }

    public function info(string $slug)
    {
        $content = Content::where('slug', $slug)->where('aktif', true)->firstOrFail();

        return view('info.show', compact('content'));
    }
}
