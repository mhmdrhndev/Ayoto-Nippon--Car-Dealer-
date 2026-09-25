<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $part->exists ? 'Ubah Sparepart' : 'Tambah Sparepart' }}</h2></x-slot>
    <div class="py-6 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <form action="{{ $part->exists ? route('admin.spareparts.update', $part) : route('admin.spareparts.store') }}" method="POST" class="bg-white p-5 rounded-xl shadow-sm space-y-4">
            @csrf @if ($part->exists) @method('PUT') @endif
            <div>
                <label for="branch_id" class="block text-sm font-medium">Cabang</label>
                <select id="branch_id" name="branch_id" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}" @selected(old('branch_id', $part->branch_id) == $branch->id)>{{ $branch->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="nama" class="block text-sm font-medium">Nama</label>
                    <input id="nama" name="nama" value="{{ old('nama', $part->nama) }}" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                </div>
                <div>
                    <label for="kode" class="block text-sm font-medium">Kode (opsional)</label>
                    <input id="kode" name="kode" value="{{ old('kode', $part->kode) }}" class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                </div>
                <div>
                    <label for="harga" class="block text-sm font-medium">Harga (Rp)</label>
                    <input id="harga" type="number" name="harga" value="{{ old('harga', $part->harga ?? 0) }}" required min="0" class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                </div>
                <div>
                    <label for="stok" class="block text-sm font-medium">Stok</label>
                    <input id="stok" type="number" name="stok" value="{{ old('stok', $part->stok ?? 0) }}" required min="0" class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                </div>
            </div>
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="aktif" value="1" @checked(old('aktif', $part->aktif ?? true)) class="min-w-[20px] min-h-[20px]"> Aktif</label>
            <x-input-error :messages="$errors->all()" />
            <button class="w-full px-6 py-3 font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Simpan</button>
        </form>
    </div>
</x-app-layout>
