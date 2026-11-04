<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $leasing->exists ? 'Ubah Leasing' : 'Tambah Leasing' }}</h2></x-slot>
    <div class="py-6 w-full sm:px-6 lg:px-8">
        <form action="{{ $leasing->exists ? route('admin.leasings.update', $leasing) : route('admin.leasings.store') }}" method="POST" class="bg-white p-5 rounded-xl shadow-sm space-y-4">
            @csrf @if ($leasing->exists) @method('PUT') @endif
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="nama" class="block text-sm font-medium">Nama leasing</label>
                    <input id="nama" name="nama" value="{{ old('nama', $leasing->nama) }}" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                </div>
                <div>
                    <label for="telp" class="block text-sm font-medium">Telepon</label>
                    <input id="telp" name="telp" value="{{ old('telp', $leasing->telp) }}" class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                </div>
                <div>
                    <label for="dp_min_persen" class="block text-sm font-medium">DP minimum (%)</label>
                    <input id="dp_min_persen" type="number" name="dp_min_persen" value="{{ old('dp_min_persen', $leasing->dp_min_persen ?? 20) }}" required min="0" max="100" class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                </div>
                <div>
                    <label for="tenor_list" class="block text-sm font-medium">Daftar tenor (koma)</label>
                    <input id="tenor_list" name="tenor_list" value="{{ old('tenor_list', $leasing->tenor_list ?? '12,24,36,48') }}" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                </div>
                <div>
                    <label for="bunga_dasar" class="block text-sm font-medium">Bunga dasar (%/thn)</label>
                    <input id="bunga_dasar" type="number" step="0.01" name="bunga_dasar" value="{{ old('bunga_dasar', $leasing->bunga_dasar ?? 0) }}" required min="0" class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                </div>
            </div>
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="aktif" value="1" @checked(old('aktif', $leasing->aktif ?? true)) class="min-w-[20px] min-h-[20px]"> Aktif</label>
            <x-input-error :messages="$errors->all()" />
            <button class="w-full px-6 py-3 font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Simpan</button>
        </form>
    </div>
</x-app-layout>
