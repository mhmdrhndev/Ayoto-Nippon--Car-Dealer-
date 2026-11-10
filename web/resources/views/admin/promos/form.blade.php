<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-ink leading-tight">{{ $promo->exists ? 'Ubah Promo' : 'Tambah Promo' }}</h2></x-slot>
    <div class="py-6 w-full sm:px-6 lg:px-8">
        <form action="{{ $promo->exists ? route('admin.promos.update', $promo) : route('admin.promos.store') }}" method="POST" enctype="multipart/form-data" class="bg-surface p-5 rounded-xl shadow-sm space-y-4">
            @csrf @if ($promo->exists) @method('PUT') @endif
            <div>
                <label for="judul" class="block text-sm font-medium">Judul</label>
                <input id="judul" name="judul" value="{{ old('judul', $promo->judul) }}" required class="mt-1 w-full rounded-lg border-line min-h-[44px]">
            </div>
            <div>
                <label for="branch_id" class="block text-sm font-medium">Cabang (kosongkan untuk semua cabang)</label>
                <select id="branch_id" name="branch_id" class="mt-1 w-full rounded-lg border-line min-h-[44px]">
                    <option value="">Semua cabang</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}" @selected(old('branch_id', $promo->branch_id) == $branch->id)>{{ $branch->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="deskripsi" class="block text-sm font-medium">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="3" class="mt-1 w-full rounded-lg border-line">{{ old('deskripsi', $promo->deskripsi) }}</textarea>
            </div>
            <div>
                <label for="banner" class="block text-sm font-medium">Banner (JPG/PNG, maks 2 MB{{ $promo->banner ? ', saat ini: '.$promo->banner : '' }})</label>
                <input id="banner" type="file" name="banner" accept=".jpg,.jpeg,.png" class="mt-1 w-full min-h-[44px]">
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="mulai" class="block text-sm font-medium">Mulai</label>
                    <input id="mulai" type="date" name="mulai" value="{{ old('mulai', $promo->mulai?->format('Y-m-d')) }}" required class="mt-1 w-full rounded-lg border-line min-h-[44px]">
                </div>
                <div>
                    <label for="selesai" class="block text-sm font-medium">Selesai</label>
                    <input id="selesai" type="date" name="selesai" value="{{ old('selesai', $promo->selesai?->format('Y-m-d')) }}" required class="mt-1 w-full rounded-lg border-line min-h-[44px]">
                </div>
            </div>
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="aktif" value="1" @checked(old('aktif', $promo->aktif ?? true)) class="min-w-[20px] min-h-[20px]"> Aktif</label>
            <x-input-error :messages="$errors->all()" />
            <button class="w-full px-6 py-3 font-semibold text-white bg-accent-strong rounded-lg min-h-[44px]">Simpan</button>
        </form>
    </div>
</x-app-layout>
