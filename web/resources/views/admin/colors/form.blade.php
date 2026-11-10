<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-ink leading-tight">{{ $color->exists ? 'Ubah Warna' : 'Tambah Warna' }}</h2></x-slot>
    <div class="py-6 w-full sm:px-6 lg:px-8">
        <form action="{{ $color->exists ? route('admin.colors.update', $color) : route('admin.colors.store') }}" method="POST" class="bg-surface p-5 rounded-xl shadow-sm space-y-4">
            @csrf @if ($color->exists) @method('PUT') @endif
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="nama" class="block text-sm font-medium">Nama warna</label>
                    <input id="nama" name="nama" value="{{ old('nama', $color->nama) }}" required class="mt-1 w-full rounded-lg border-line min-h-[44px]">
                </div>
                <div>
                    <label for="kode_hex" class="block text-sm font-medium">Kode hex (opsional)</label>
                    <input id="kode_hex" name="kode_hex" value="{{ old('kode_hex', $color->kode_hex) }}" placeholder="#FFFFFF" class="mt-1 w-full rounded-lg border-line font-mono min-h-[44px]">
                </div>
            </div>
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="aktif" value="1" @checked(old('aktif', $color->aktif ?? true)) class="min-w-[20px] min-h-[20px]"> Aktif</label>
            <x-input-error :messages="$errors->all()" />
            <button class="w-full px-6 py-3 font-semibold text-white bg-accent-strong rounded-lg min-h-[44px]">Simpan</button>
        </form>
    </div>
</x-app-layout>
