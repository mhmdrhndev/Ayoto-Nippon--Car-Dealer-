<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index()
    {
        $contents = Content::latest()->paginate(15);

        return view('admin.contents.index', compact('contents'));
    }

    public function create()
    {
        return view('admin.contents.form', ['content' => new Content()]);
    }

    public function store(Request $request)
    {
        Content::create($this->validated($request));

        return redirect()->route('admin.contents.index')->with('sukses', 'Konten berhasil ditambah.');
    }

    public function edit(Content $content)
    {
        return view('admin.contents.form', compact('content'));
    }

    public function update(Request $request, Content $content)
    {
        $content->update($this->validated($request));

        return redirect()->route('admin.contents.index')->with('sukses', 'Konten berhasil diperbarui.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'tipe' => ['required', 'in:halaman,berita'],
            'slug' => ['required', 'string', 'max:100', 'regex:/^[a-z0-9-]+$/'],
            'judul' => ['required', 'string', 'max:150'],
            'isi' => ['nullable', 'string'],
            'aktif' => ['nullable', 'boolean'],
        ]);
        $data['aktif'] = $request->boolean('aktif');

        return $data;
    }
}
