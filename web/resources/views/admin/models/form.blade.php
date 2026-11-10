<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-ink leading-tight">{{ $model->exists ? 'Ubah Model' : 'Tambah Model' }}</h2></x-slot>
    <div class="py-6 w-full sm:px-6 lg:px-8">
        <form action="{{ $model->exists ? route('admin.models.update', $model) : route('admin.models.store') }}" method="POST" class="bg-surface p-5 rounded-xl shadow-sm space-y-4">
            @csrf @if ($model->exists) @method('PUT') @endif
            <div>
                <label for="brand_id" class="block text-sm font-medium">Brand</label>
                <select id="brand_id" name="brand_id" required class="mt-1 w-full rounded-lg border-line min-h-[44px]">
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" @selected(old('brand_id', $model->brand_id) == $brand->id)>{{ $brand->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="nama" class="block text-sm font-medium">Nama model</label>
                <input id="nama" name="nama" value="{{ old('nama', $model->nama) }}" required class="mt-1 w-full rounded-lg border-line min-h-[44px]">
            </div>
            <div>
                <label for="deskripsi" class="block text-sm font-medium">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="2" class="mt-1 w-full rounded-lg border-line">{{ old('deskripsi', $model->deskripsi) }}</textarea>
            </div>
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="aktif" value="1" @checked(old('aktif', $model->aktif ?? true)) class="min-w-[20px] min-h-[20px]"> Aktif</label>
            <x-input-error :messages="$errors->all()" />
            <button class="w-full px-6 py-3 font-semibold text-white bg-accent-strong rounded-lg min-h-[44px]">Simpan</button>
        </form>
    </div>
</x-app-layout>
