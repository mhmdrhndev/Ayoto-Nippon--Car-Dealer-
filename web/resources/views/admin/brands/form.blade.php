<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-ink leading-tight">{{ $brand->exists ? 'Ubah Brand' : 'Tambah Brand' }}</h2></x-slot>
    <div class="py-6 w-full sm:px-6 lg:px-8">
        <form action="{{ $brand->exists ? route('admin.brands.update', $brand) : route('admin.brands.store') }}" method="POST" class="bg-surface p-5 rounded-xl shadow-sm space-y-4">
            @csrf @if ($brand->exists) @method('PUT') @endif
            <div>
                <label for="nama" class="block text-sm font-medium">Nama brand</label>
                <input id="nama" name="nama" value="{{ old('nama', $brand->nama) }}" required class="mt-1 w-full rounded-lg border-line min-h-[44px]">
            </div>
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="aktif" value="1" @checked(old('aktif', $brand->aktif ?? true)) class="min-w-[20px] min-h-[20px]"> Aktif</label>
            <x-input-error :messages="$errors->all()" />
            <button class="w-full px-6 py-3 font-semibold text-white bg-accent-strong rounded-lg min-h-[44px]">Simpan</button>
        </form>
    </div>
</x-app-layout>
