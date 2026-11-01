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

    public function faq()
    {
        return view('faq.index');
    }

    public function sitemap()
    {
        $statis = ['home', 'katalog.index', 'simulasi.form', 'test-drive.create', 'trade-in.create', 'servis.create', 'sparepart.index', 'promo.index', 'cabang.index', 'faq.index', 'lacak.form'];
        $urls = [];
        foreach ($statis as $nama) {
            $urls[] = ['loc' => route($nama), 'lastmod' => now()->toDateString()];
        }
        foreach (\App\Models\CarModel::with('brand')->whereHas('variants', fn ($q) => $q->where('aktif', true))->get(['id', 'slug', 'brand_id']) as $model) {
            $urls[] = ['loc' => route('katalog.model', [$model->brand->slug, $model->slug]), 'lastmod' => now()->toDateString()];
        }
        foreach (\App\Models\Variant::where('aktif', true)->get(['slug']) as $variant) {
            $urls[] = ['loc' => route('katalog.show', $variant->slug), 'lastmod' => now()->toDateString()];
        }
        foreach (\App\Models\Content::where('aktif', true)->get(['slug']) as $content) {
            $urls[] = ['loc' => route('info.show', $content->slug), 'lastmod' => now()->toDateString()];
        }

        return response()->view('sitemap', compact('urls'))->header('Content-Type', 'application/xml');
    }
}
