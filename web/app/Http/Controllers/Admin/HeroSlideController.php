<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\Request;

class HeroSlideController extends Controller
{
    public function index()
    {
        $slides = HeroSlide::terurut()->paginate(15);

        return view('admin.hero-slides.index', compact('slides'));
    }

    public function create()
    {
        return view('admin.hero-slides.form', ['slide' => new HeroSlide()]);
    }

    public function store(Request $request)
    {
        HeroSlide::create($this->validated($request));

        return redirect()->route('admin.hero-slides.index')->with('sukses', 'Foto hero berhasil ditambah.');
    }

    public function edit(HeroSlide $heroSlide)
    {
        return view('admin.hero-slides.form', ['slide' => $heroSlide]);
    }

    public function update(Request $request, HeroSlide $heroSlide)
    {
        $heroSlide->update($this->validated($request, $heroSlide));

        return redirect()->route('admin.hero-slides.index')->with('sukses', 'Foto hero berhasil diperbarui.');
    }

    private function validated(Request $request, ?HeroSlide $slide = null): array
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'foto' => [$slide?->exists ? 'nullable' : 'required', 'image', 'max:2048'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'aktif' => ['nullable', 'boolean'],
        ]);
        if ($request->hasFile('foto')) {
            $data['foto'] = 'storage/'.$request->file('foto')->store('hero', 'public');
        } else {
            unset($data['foto']);
        }
        $data['urutan'] = $data['urutan'] ?? 0;
        $data['aktif'] = $request->boolean('aktif');

        return $data;
    }
}
