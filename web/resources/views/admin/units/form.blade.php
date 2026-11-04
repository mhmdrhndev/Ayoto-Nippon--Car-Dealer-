<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $unit->exists ? 'Ubah Unit' : 'Tambah Unit' }}</h2></x-slot>
    <div class="py-6 w-full sm:px-6 lg:px-8">
        <form action="{{ $unit->exists ? route('admin.units.update', $unit) : route('admin.units.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-5 rounded-xl shadow-sm space-y-4">
            @csrf @if ($unit->exists) @method('PUT') @endif
            <div>
                <label for="vin" class="block text-sm font-medium">VIN (unik)</label>
                <input id="vin" name="vin" value="{{ old('vin', $unit->vin) }}" required class="mt-1 w-full rounded-lg border-gray-300 font-mono min-h-[44px]">
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="variant_id" class="block text-sm font-medium">Varian</label>
                    <select id="variant_id" name="variant_id" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                        @foreach ($variants as $variant)
                            <option value="{{ $variant->id }}" @selected(old('variant_id', $unit->variant_id) == $variant->id)>{{ $variant->carModel->brand->nama }} {{ $variant->carModel->nama }} {{ $variant->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="color_id" class="block text-sm font-medium">Warna</label>
                    <select id="color_id" name="color_id" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                        @foreach ($colors as $color)
                            <option value="{{ $color->id }}" @selected(old('color_id', $unit->color_id) == $color->id)>{{ $color->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="branch_id" class="block text-sm font-medium">Cabang</label>
                    <select id="branch_id" name="branch_id" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}" @selected(old('branch_id', $unit->branch_id) == $branch->id)>{{ $branch->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium">Status</label>
                    <select id="status" name="status" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                        @foreach (['Tersedia', 'Dipesan', 'Terjual'] as $s)
                            <option value="{{ $s }}" @selected(old('status', $unit->status ?? 'Tersedia') === $s)>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="tahun_rakit" class="block text-sm font-medium">Tahun rakit</label>
                    <input id="tahun_rakit" type="number" name="tahun_rakit" value="{{ old('tahun_rakit', $unit->tahun_rakit ?? 2026) }}" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                </div>
                <div>
                    <label for="harga" class="block text-sm font-medium">Harga (Rp)</label>
                    <input id="harga" type="number" name="harga" value="{{ old('harga', $unit->harga) }}" required min="0" class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                </div>
            </div>
            <div>
                <label for="foto_utama" class="block text-sm font-medium">Foto unit (JPG/PNG, maks 2 MB, landscape)</label>
                @if ($unit->foto_utama)
                    <img src="{{ asset($unit->foto_utama) }}" alt="" class="mt-2 h-24 w-auto object-cover rounded-lg">
                @endif
                <input id="foto_utama" type="file" name="foto_utama" accept=".jpg,.jpeg,.png" class="mt-1 w-full min-h-[44px]">
            </div>
            <x-input-error :messages="$errors->all()" />
            <button class="w-full px-6 py-3 font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Simpan</button>
        </form>
    </div>
</x-app-layout>
