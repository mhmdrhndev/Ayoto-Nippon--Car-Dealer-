<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $slide->exists ? 'Ubah Foto Hero' : 'Tambah Foto Hero' }}</h2></x-slot>
    <div class="py-6 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <form action="{{ $slide->exists ? route('admin.hero-slides.update', $slide) : route('admin.hero-slides.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-5 rounded-xl shadow-sm space-y-4">
            @csrf @if ($slide->exists) @method('PUT') @endif
            <div>
                <label for="nama" class="block text-sm font-medium">Nama (label admin)</label>
                <input id="nama" name="nama" value="{{ old('nama', $slide->nama) }}" required placeholder="Contoh: Foto Avanza" class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
            </div>
            <div>
                <label for="foto" class="block text-sm font-medium">Foto (JPG/PNG, maks 2 MB, landscape)</label>
                @if ($slide->foto)
                    <img src="{{ asset($slide->foto) }}" alt="" class="mt-2 h-24 w-auto object-cover rounded-lg">
                @endif
                <input id="foto" type="file" name="foto" accept=".jpg,.jpeg,.png" @required(! $slide->exists) class="mt-1 w-full min-h-[44px]">
            </div>
            <div>
                <label for="urutan" class="block text-sm font-medium">Urutan tampil</label>
                <input id="urutan" type="number" name="urutan" value="{{ old('urutan', $slide->urutan ?? 0) }}" min="0" class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
            </div>
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="aktif" value="1" @checked(old('aktif', $slide->aktif ?? true)) class="min-w-[20px] min-h-[20px]"> Aktif</label>
            <x-input-error :messages="$errors->all()" />
            <button class="w-full px-6 py-3 font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Simpan</button>
        </form>
    </div>
</x-app-layout>
