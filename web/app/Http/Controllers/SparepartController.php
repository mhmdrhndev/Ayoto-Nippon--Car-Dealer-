<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Lead;
use App\Models\Sparepart;
use Illuminate\Http\Request;

class SparepartController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'cabang' => ['nullable', 'string', 'max:20'],
        ]);

        $parts = Sparepart::with('branch')
            ->where('aktif', true)
            ->when($data['q'] ?? null, fn ($q, $s) => $q->where('nama', 'like', "%{$s}%")->orWhere('kode', 'like', "%{$s}%"))
            ->when($data['cabang'] ?? null, fn ($q, $kode) => $q->whereHas('branch', fn ($qq) => $qq->where('kode', $kode)))
            ->orderBy('nama')->paginate(12)->withQueryString();

        $branches = Branch::where('aktif', true)->orderBy('nama')->get();

        return view('sparepart.index', compact('parts', 'branches'));
    }

    public function pesan(Request $request, Sparepart $sparepart)
    {
        Lead::create([
            'sumber' => 'Web',
            'status' => 'Baru',
            'kebutuhan_text' => "Pesan sparepart {$sparepart->nama} di {$sparepart->branch->nama}, harga Rp ".number_format($sparepart->harga, 0, ',', '.'),
        ]);

        return back()->with('sukses', 'Pesanan diteruskan. Sales sparepart akan menghubungi Anda.');
    }
}
