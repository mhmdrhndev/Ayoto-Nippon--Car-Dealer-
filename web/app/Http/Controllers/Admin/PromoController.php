<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::with('branch')->latest()->paginate(15);

        return view('admin.promos.index', compact('promos'));
    }

    public function create()
    {
        return view('admin.promos.form', [
            'promo' => new Promo(),
            'branches' => Branch::where('aktif', true)->orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request)
    {
        Promo::create($this->validated($request));

        return redirect()->route('admin.promos.index')->with('sukses', 'Promo berhasil ditambah.');
    }

    public function edit(Promo $promo)
    {
        return view('admin.promos.form', [
            'promo' => $promo,
            'branches' => Branch::where('aktif', true)->orderBy('nama')->get(),
        ]);
    }

    public function update(Request $request, Promo $promo)
    {
        $promo->update($this->validated($request));

        return redirect()->route('admin.promos.index')->with('sukses', 'Promo berhasil diperbarui.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'branch_id' => ['nullable', 'exists:branches,id'],
            'judul' => ['required', 'string', 'max:150'],
            'deskripsi' => ['nullable', 'string'],
            'banner' => ['nullable', 'image', 'max:2048'],
            'mulai' => ['required', 'date'],
            'selesai' => ['required', 'date', 'after_or_equal:mulai'],
            'aktif' => ['nullable', 'boolean'],
        ]);
        if ($request->hasFile('banner')) {
            $data['banner'] = 'storage/'.$request->file('banner')->store('promo', 'public');
        } else {
            unset($data['banner']);
        }
        $data['slug'] = Str::slug($data['judul']).'-'.now()->format('Ymd');
        $data['aktif'] = $request->boolean('aktif');

        return $data;
    }
}
