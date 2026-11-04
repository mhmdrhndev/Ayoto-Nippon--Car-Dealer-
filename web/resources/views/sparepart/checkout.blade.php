<x-site-layout judul="Checkout Sparepart: {{ $sparepart->nama }}">
    <x-site-header />

    <div class="w-full px-4 sm:px-6 lg:px-8 py-10 space-y-6">
        <a href="{{ route('sparepart.index') }}" class="text-sm font-medium text-[#4B5563] hover:text-[#16181D] min-h-[44px] inline-flex items-center gap-2 transition-colors">
            <span>Kembali ke Katalog Sparepart</span>
        </a>

        <div class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-3xl p-6 sm:p-10 shadow-2xl shadow-black/5">
            <div class="pb-6 border-b border-[#E5E7EB]">
                <p class="text-xs font-semibold tracking-wider text-[#C1121F] uppercase">Formulir Pemesanan Suku Cadang</p>
                <h1 class="mt-1 text-2xl sm:text-3xl font-extrabold text-[#16181D] tracking-tight">Pemesanan {{ $sparepart->nama }}</h1>
                <div class="mt-3 flex flex-wrap gap-3 text-xs text-[#4B5563]">
                    <span class="px-3 py-1 bg-[#FFFFFF] border border-[#E5E7EB] rounded-lg text-[#16181D]">Gudang Cabang: {{ $sparepart->branch->nama }}</span>
                    <span class="px-3 py-1 bg-[#FFFFFF] border border-[#E5E7EB] rounded-lg text-[#16181D]">Harga: Rp {{ number_format($sparepart->harga, 0, ',', '.') }}</span>
                    <span class="px-3 py-1 bg-emerald-500/10 border border-emerald-500/20 rounded-lg text-emerald-700 font-bold">Stok: {{ $sparepart->stok }} unit</span>
                </div>
            </div>

            <form action="{{ route('sparepart.order.store', $sparepart) }}" method="POST" class="mt-8 space-y-5">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="nama" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Nama Lengkap Pemesan</label>
                        <input id="nama" name="nama" value="{{ old('nama') }}" required 
                            placeholder="Sesuai identitas pengambil"
                            class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] placeholder-gray-500 text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                    </div>

                    <div>
                        <label for="nik" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">NIK KTP (16 Digit)</label>
                        <input id="nik" name="nik" value="{{ old('nik') }}" required inputmode="numeric" maxlength="16" 
                            placeholder="3201..."
                            class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] placeholder-gray-500 text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                    </div>

                    <div>
                        <label for="telp" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Nomor Telepon / WhatsApp</label>
                        <input id="telp" name="telp" value="{{ old('telp') }}" required 
                            placeholder="0812..."
                            class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] placeholder-gray-500 text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                    </div>

                    <div>
                        <label for="qty" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Jumlah Pembelian (Maks {{ $sparepart->stok }})</label>
                        <input id="qty" type="number" name="qty" value="{{ old('qty', 1) }}" required min="1" max="{{ $sparepart->stok }}" 
                            class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5 tabular-nums">
                    </div>
                </div>

                <div>
                    <label for="alamat" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Alamat Tempat Tinggal</label>
                    <textarea id="alamat" name="alamat" required rows="2" 
                        placeholder="Alamat penagihan atau domisili..."
                        class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] placeholder-gray-500 text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] p-3.5">{{ old('alamat') }}</textarea>
                </div>

                <x-input-error :messages="$errors->all()" class="text-[#C1121F] text-xs" />

                <div class="pt-2">
                    <button type="submit" 
                        class="w-full py-3.5 px-6 font-bold text-sm text-white bg-[#C1121F] hover:bg-[#9E0E19] rounded-xl min-h-[48px] shadow-lg shadow-[#C1121F]/25 transition-all flex items-center justify-center active:scale-[0.99]">
                        Buat Pesanan Sparepart
                    </button>
                    <p class="mt-3 text-center text-xs text-gray-500">
                        Pengambilan suku cadang dilakukan langsung di cabang {{ $sparepart->branch->nama }} setelah pembayaran diverifikasi.
                    </p>
                </div>
            </form>
        </div>
    </div>

    <x-site-footer />
</x-site-layout>
