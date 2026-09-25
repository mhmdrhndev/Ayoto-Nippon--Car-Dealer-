<x-site-layout>
    <x-site-header />
    <div class="max-w-2xl mx-auto px-4 sm:px-6 py-8">
        <a href="{{ route('sparepart.index') }}" class="text-sm font-medium text-[#4B5563] hover:underline min-h-[44px] inline-flex items-center">Kembali ke katalog sparepart</a>
        <h1 class="mt-2 text-2xl font-bold text-[#16181D]">Beli {{ $sparepart->nama }}</h1>
        <p class="mt-1 text-sm text-[#4B5563]">{{ $sparepart->branch->nama }}. Harga Rp {{ number_format($sparepart->harga, 0, ',', '.') }}, stok {{ $sparepart->stok }}.</p>
        <form action="{{ route('sparepart.order.store', $sparepart) }}" method="POST" class="mt-6 space-y-4">
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
                    <label for="qty" class="block text-sm font-medium text-[#16181D]">Jumlah (maks {{ $sparepart->stok }})</label>
                    <input id="qty" type="number" name="qty" value="{{ old('qty', 1) }}" required min="1" max="{{ $sparepart->stok }}" class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                </div>
            </div>
            <div>
                <label for="alamat" class="block text-sm font-medium text-[#16181D]">Alamat</label>
                <textarea id="alamat" name="alamat" required rows="2" class="mt-1 w-full rounded-lg border-gray-300">{{ old('alamat') }}</textarea>
            </div>
            <x-input-error :messages="$errors->all()" />
            <button type="submit" class="w-full px-6 py-3 font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Buat Order</button>
        </form>
    </div>
    <x-site-footer />
</x-site-layout>
