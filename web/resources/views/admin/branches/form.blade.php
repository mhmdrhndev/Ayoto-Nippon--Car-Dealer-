<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-ink leading-tight">{{ $branch->exists ? 'Ubah Cabang' : 'Tambah Cabang' }}</h2></x-slot>
    <div class="py-6 w-full sm:px-6 lg:px-8">
        <form action="{{ $branch->exists ? route('admin.branches.update', $branch) : route('admin.branches.store') }}" method="POST" class="bg-surface p-5 rounded-xl shadow-sm space-y-4">
            @csrf @if ($branch->exists) @method('PUT') @endif
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="kode" class="block text-sm font-medium">Kode</label>
                    <input id="kode" name="kode" value="{{ old('kode', $branch->kode) }}" required class="mt-1 w-full rounded-lg border-line font-mono min-h-[44px]">
                </div>
                <div>
                    <label for="nama" class="block text-sm font-medium">Nama cabang</label>
                    <input id="nama" name="nama" value="{{ old('nama', $branch->nama) }}" required class="mt-1 w-full rounded-lg border-line min-h-[44px]">
                </div>
                <div>
                    <label for="telp" class="block text-sm font-medium">Telepon</label>
                    <input id="telp" name="telp" value="{{ old('telp', $branch->telp) }}" class="mt-1 w-full rounded-lg border-line min-h-[44px]">
                </div>
                <div>
                    <label for="jam_operasional" class="block text-sm font-medium">Jam operasional</label>
                    <input id="jam_operasional" name="jam_operasional" value="{{ old('jam_operasional', $branch->jam_operasional) }}" placeholder="Senin–Sabtu 08.00–17.00" class="mt-1 w-full rounded-lg border-line min-h-[44px]">
                </div>
                <div>
                    <label for="booking_fee" class="block text-sm font-medium">Booking fee (Rp)</label>
                    <input id="booking_fee" type="number" name="booking_fee" value="{{ old('booking_fee', $branch->booking_fee ?? 5000000) }}" required min="0" class="mt-1 w-full rounded-lg border-line min-h-[44px]">
                </div>
            </div>
            <div>
                <label for="alamat" class="block text-sm font-medium">Alamat</label>
                <textarea id="alamat" name="alamat" rows="2" class="mt-1 w-full rounded-lg border-line">{{ old('alamat', $branch->alamat) }}</textarea>
            </div>
            <div>
                <label for="maps_url" class="block text-sm font-medium">Google Maps URL</label>
                <input id="maps_url" name="maps_url" value="{{ old('maps_url', $branch->maps_url) }}" class="mt-1 w-full rounded-lg border-line min-h-[44px]">
            </div>
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="aktif" value="1" @checked(old('aktif', $branch->aktif ?? true)) class="min-w-[20px] min-h-[20px]"> Aktif</label>
            <x-input-error :messages="$errors->all()" />
            <button class="w-full px-6 py-3 font-semibold text-white bg-accent-strong rounded-lg min-h-[44px]">Simpan</button>
        </form>
    </div>
</x-app-layout>
