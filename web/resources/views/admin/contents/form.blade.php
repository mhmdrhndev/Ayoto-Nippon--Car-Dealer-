<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $content->exists ? 'Ubah Konten' : 'Tambah Konten' }}</h2></x-slot>
    <div class="py-6 w-full sm:px-6 lg:px-8">
        <form action="{{ $content->exists ? route('admin.contents.update', $content) : route('admin.contents.store') }}" method="POST" class="bg-white p-5 rounded-xl shadow-sm space-y-4">
            @csrf @if ($content->exists) @method('PUT') @endif
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="tipe" class="block text-sm font-medium">Tipe</label>
                    <select id="tipe" name="tipe" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                        @foreach (['halaman', 'berita'] as $t)
                            <option value="{{ $t }}" @selected(old('tipe', $content->tipe) === $t)>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="slug" class="block text-sm font-medium">Slug (huruf kecil, angka, strip)</label>
                    <input id="slug" name="slug" value="{{ old('slug', $content->slug) }}" required class="mt-1 w-full rounded-lg border-gray-300 font-mono min-h-[44px]">
                </div>
            </div>
            <div>
                <label for="judul" class="block text-sm font-medium">Judul</label>
                <input id="judul" name="judul" value="{{ old('judul', $content->judul) }}" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
            </div>
            <div>
                <label for="isi" class="block text-sm font-medium">Isi</label>
                <textarea id="isi" name="isi" rows="6" class="mt-1 w-full rounded-lg border-gray-300">{{ old('isi', $content->isi) }}</textarea>
            </div>
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="aktif" value="1" @checked(old('aktif', $content->aktif ?? true)) class="min-w-[20px] min-h-[20px]"> Aktif</label>
            <x-input-error :messages="$errors->all()" />
            <button class="w-full px-6 py-3 font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Simpan</button>
        </form>
    </div>
</x-app-layout>
