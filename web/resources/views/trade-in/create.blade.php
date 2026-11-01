<x-site-layout judul="Pengajuan Trade-In" deskripsi="Tukar tambah mobil lama Anda dengan unit baru di Ayoto Nippon.">
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
        <h1 class="text-2xl font-bold text-[#16181D]">Pengajuan Trade-In</h1>
        <p class="mt-1 text-sm text-[#4B5563]">Tukar tambah mobil lama Anda. Tim kami akan inspeksi dan memberi penawaran.</p>
        <form action="{{ route('trade-in.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4">
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
                    <label for="merk_tipe" class="block text-sm font-medium text-[#16181D]">Merk dan tipe mobil lama</label>
                    <input id="merk_tipe" name="merk_tipe" value="{{ old('merk_tipe') }}" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                </div>
                <div>
                    <label for="tahun" class="block text-sm font-medium text-[#16181D]">Tahun</label>
                    <input id="tahun" type="number" name="tahun" value="{{ old('tahun') }}" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                </div>
                <div>
                    <label for="km" class="block text-sm font-medium text-[#16181D]">Kilometer</label>
                    <input id="km" type="number" name="km" value="{{ old('km') }}" required min="0" class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                </div>
            </div>
            <div>
                <label for="alamat" class="block text-sm font-medium text-[#16181D]">Alamat</label>
                <textarea id="alamat" name="alamat" required rows="2" class="mt-1 w-full rounded-lg border-gray-300">{{ old('alamat') }}</textarea>
            </div>
            @if ($orders->isNotEmpty())
                <div>
                    <label for="order_id" class="block text-sm font-medium text-[#16181D]">Tautkan ke SPK aktif (opsional)</label>
                    <select id="order_id" name="order_id" class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                        <option value="">Tanpa tautan</option>
                        @foreach ($orders as $order)
                            <option value="{{ $order->id }}">{{ $order->no_spk }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            <div>
                <label for="foto" class="block text-sm font-medium text-[#16181D]">Foto mobil (maks 3, JPG/PNG, 2 MB per file)</label>
                <input id="foto" type="file" name="foto[]" multiple accept=".jpg,.jpeg,.png" class="mt-1 w-full min-h-[44px]">
            </div>
            <x-input-error :messages="$errors->all()" />
            <button type="submit" class="w-full px-6 py-3 font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Ajukan Trade-In</button>
        </form>
    </div>
</x-site-layout>
