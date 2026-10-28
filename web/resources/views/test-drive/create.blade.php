<x-site-layout>
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2 min-h-[44px]">
                <img src="{{ asset('images/logo-an.png') }}" alt="Logo Ayoto Nippon" class="h-10 w-10 object-contain">
                <span class="text-xl font-bold text-[#16181D]">Ayoto Nippon</span>
            </a>
            <a href="{{ route('katalog.index') }}" class="px-3 py-2 text-sm font-medium text-[#16181D] hover:underline min-h-[44px] inline-flex items-center">Katalog</a>
        </div>
    </div>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 py-8">
        <h1 class="text-2xl font-bold text-[#16181D]">Booking Test Drive</h1>
        <form action="{{ route('test-drive.store') }}" method="POST" class="mt-6 space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="nama" class="block text-sm font-medium text-[#16181D]">Nama lengkap</label>
                    <input id="nama" name="nama" value="{{ old('nama') }}" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                </div>
                <div>
                    <label for="nik" class="block text-sm font-medium text-[#16181D]">NIK (16 digit)</label>
                    <input id="nik" name="nik" value="{{ old('nik') }}" required inputmode="numeric" class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                </div>
                <div>
                    <label for="telp" class="block text-sm font-medium text-[#16181D]">No. telepon</label>
                    <input id="telp" name="telp" value="{{ old('telp') }}" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                </div>
                <div>
                    <label for="jadwal" class="block text-sm font-medium text-[#16181D]">Jadwal diinginkan</label>
                    <input id="jadwal" type="datetime-local" name="jadwal" value="{{ old('jadwal') }}" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                </div>
            </div>
            <div>
                <label for="alamat" class="block text-sm font-medium text-[#16181D]">Alamat</label>
                <textarea id="alamat" name="alamat" required rows="2" class="mt-1 w-full rounded-lg border-gray-300">{{ old('alamat') }}</textarea>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="branch_id" class="block text-sm font-medium text-[#16181D]">Cabang</label>
                    <select id="branch_id" name="branch_id" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                        <option value="" @selected(! old('branch_id'))>Pilih cabang</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}" @selected((string) old('branch_id') === (string) $branch->id)>{{ $branch->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="variant_id" class="block text-sm font-medium text-[#16181D]">Varian</label>
                    <select id="variant_id" name="variant_id" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                        <option value="" @selected(!old('variant_id', $variantId ?? null))>Pilih mobil</option>
                        @foreach ($variants as $variant)
                            <option value="{{ $variant->id }}" @selected((string) old('variant_id', $variantId ?? '') === (string) $variant->id)>{{ $variant->carModel->brand->nama }} {{ $variant->carModel->nama }} {{ $variant->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="color_id" class="block text-sm font-medium text-[#16181D]">Warna diinginkan (opsional)</label>
                    <select id="color_id" name="color_id" class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                        <option value="">Pilih warna</option>
                        @foreach ($colors as $color)
                            <option value="{{ $color->id }}" @selected((string) old('color_id', $colorId ?? '') === (string) $color->id)>{{ $color->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <x-input-error :messages="$errors->all()" class="mt-2" />
            <button type="submit" class="w-full px-6 py-3 font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Ajukan Test Drive</button>
        </form>
    </div>
</x-site-layout>
