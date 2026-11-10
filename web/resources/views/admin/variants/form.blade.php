<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-ink leading-tight">{{ $variant->exists ? 'Ubah Varian' : 'Tambah Varian' }}</h2></x-slot>
    <div class="py-6 w-full sm:px-6 lg:px-8">
        <form action="{{ $variant->exists ? route('admin.variants.update', $variant) : route('admin.variants.store') }}" method="POST" class="bg-surface p-5 rounded-xl shadow-sm space-y-4">
            @csrf @if ($variant->exists) @method('PUT') @endif
            <div>
                <label for="car_model_id" class="block text-sm font-medium">Model</label>
                <select id="car_model_id" name="car_model_id" required class="mt-1 w-full rounded-lg border-line min-h-[44px]">
                    @foreach ($models as $model)
                        <option value="{{ $model->id }}" @selected(old('car_model_id', $variant->car_model_id) == $model->id)>{{ $model->brand->nama }} {{ $model->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="nama" class="block text-sm font-medium">Nama varian</label>
                    <input id="nama" name="nama" value="{{ old('nama', $variant->nama) }}" required class="mt-1 w-full rounded-lg border-line min-h-[44px]">
                </div>
                <div>
                    <label for="transmisi" class="block text-sm font-medium">Transmisi</label>
                    <select id="transmisi" name="transmisi" required class="mt-1 w-full rounded-lg border-line min-h-[44px]">
                        @foreach (['MT', 'AT', 'CVT'] as $t)
                            <option value="{{ $t }}" @selected(old('transmisi', $variant->transmisi) === $t)>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="bbm" class="block text-sm font-medium">BBM</label>
                    <input id="bbm" name="bbm" value="{{ old('bbm', $variant->bbm ?? 'Bensin') }}" required class="mt-1 w-full rounded-lg border-line min-h-[44px]">
                </div>
            </div>
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="aktif" value="1" @checked(old('aktif', $variant->aktif ?? true)) class="min-w-[20px] min-h-[20px]"> Aktif (nonaktif menyembunyikan dari katalog)</label>
            <x-input-error :messages="$errors->all()" />
            <button class="w-full px-6 py-3 font-semibold text-white bg-accent-strong rounded-lg min-h-[44px]">Simpan</button>
        </form>
    </div>
</x-app-layout>
