<x-site-layout judul="Booking Test Drive" deskripsi="Jadwalkan test drive mobil baru di cabang Ayoto Nippon terdekat.">
    <x-site-header />

    <div class="w-full px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-3xl p-6 sm:p-10 shadow-2xl shadow-black/5 w-full">
            <div class="pb-6 border-b border-[#E5E7EB]">
                <p class="text-xs font-semibold tracking-wider text-[#C1121F] uppercase">Uji Coba Kendaraan</p>
                <h1 class="mt-1 text-2xl sm:text-3xl font-extrabold text-[#16181D] tracking-tight">Booking Jadwal Test Drive</h1>
                <p class="mt-2 text-xs sm:text-sm text-[#4B5563] leading-relaxed">
                    Rasakan kenyamanan dan performa langsung di jalan. Sales consultant kami akan menyiapkan unit dan rute uji kemudi terbaik.
                </p>
            </div>

            <form action="{{ route('test-drive.store') }}" method="POST" class="mt-8 space-y-6">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="nama" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Nama Lengkap</label>
                        <input id="nama" name="nama" value="{{ old('nama') }}" required 
                            placeholder="Sesuai KTP / SIM"
                            class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] placeholder-gray-500 text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                    </div>

                    <div>
                        <label for="nik" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">NIK KTP (16 Digit)</label>
                        <input id="nik" name="nik" value="{{ old('nik') }}" required inputmode="numeric" maxlength="16" 
                            placeholder="3201..."
                            class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] placeholder-gray-500 text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                    </div>

                    <div>
                        <label for="telp" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Nomor WhatsApp / Telepon</label>
                        <input id="telp" name="telp" value="{{ old('telp') }}" required inputmode="tel" 
                            placeholder="0812..."
                            class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] placeholder-gray-500 text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                    </div>

                    <div>
                        <label for="jadwal" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Waktu yang Diinginkan</label>
                        <input id="jadwal" type="datetime-local" name="jadwal" value="{{ old('jadwal') }}" required 
                            class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                    </div>
                </div>

                <div>
                    <label for="alamat" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Alamat Tinggal Domisili</label>
                    <textarea id="alamat" name="alamat" required rows="2" 
                        placeholder="Alamat lengkap kota domisili..."
                        class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] placeholder-gray-500 text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] p-3.5">{{ old('alamat') }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div>
                        <label for="branch_id" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Cabang Dealer</label>
                        <select id="branch_id" name="branch_id" required 
                            class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                            <option value="" @selected(! old('branch_id'))>Pilih Cabang</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}" @selected((string) old('branch_id') === (string) $branch->id)>{{ $branch->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="variant_id" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Varian Mobil</label>
                        <select id="variant_id" name="variant_id" required 
                            class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                            <option value="" @selected(!old('variant_id', $variantId ?? null))>Pilih Model Unit</option>
                            @foreach ($variants as $variant)
                                <option value="{{ $variant->id }}" @selected((string) old('variant_id', $variantId ?? '') === (string) $variant->id)>{{ $variant->carModel->brand->nama }} {{ $variant->carModel->nama }} {{ $variant->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="color_id" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Warna Diinginkan (Opsional)</label>
                        <select id="color_id" name="color_id" 
                            class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                            <option value="">Semua Warna</option>
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}" @selected((string) old('color_id', $colorId ?? '') === (string) $color->id)>{{ $color->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <x-input-error :messages="$errors->all()" class="text-[#C1121F] text-xs" />

                <div class="pt-2">
                    <button type="submit" 
                        class="w-full py-3.5 px-6 font-bold text-sm text-white bg-[#C1121F] hover:bg-[#9E0E19] rounded-xl min-h-[48px] shadow-lg shadow-[#C1121F]/25 transition-all flex items-center justify-center active:scale-[0.99]">
                        Ajukan Jadwal Test Drive
                    </button>
                    <p class="mt-3 text-center text-xs text-gray-500">
                        Wajib membawa SIM A yang masih berlaku saat kehadiran di cabang.
                    </p>
                </div>
            </form>
        </div>
    </div>

    <x-site-footer />
</x-site-layout>
