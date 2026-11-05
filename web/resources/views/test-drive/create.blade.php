<x-site-layout judul="Booking Test Drive" deskripsi="Jadwalkan test drive mobil baru di cabang Ayoto Nippon terdekat.">
    <x-site-header />

    <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-8 sm:py-12">
        <div class="mb-8">
            <nav class="flex items-center gap-2 text-xs text-[#4B5563] mb-2">
                <a href="{{ route('home') }}" class="hover:text-[#C1121F] transition-colors">Beranda</a>
                <span>/</span>
                <span class="text-[#16181D] font-medium">Test Drive</span>
            </nav>
            <h1 class="text-2xl sm:text-4xl font-extrabold text-[#16181D] tracking-tight">Booking Jadwal Test Drive</h1>
            <p class="mt-2 text-sm sm:text-base text-[#4B5563] max-w-3xl leading-relaxed">
                Rasakan performa mesin, kenyamanan suspensi, dan fitur keselamatan mobil impian Anda langsung di jalan sebelum mengambil keputusan pembelian.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Form Column -->
            <div class="lg:col-span-7 xl:col-span-8 bg-[#FFFFFF] border border-[#E5E7EB] rounded-3xl p-6 sm:p-10 shadow-xl shadow-black/5">
                <div class="pb-6 border-b border-[#E5E7EB] flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <p class="text-xs font-semibold tracking-wider text-[#C1121F] uppercase">Pengajuan Uji Kendara</p>
                        <h2 class="mt-1 text-xl sm:text-2xl font-bold text-[#16181D]">Isi Data Pengemudi & Unit</h2>
                    </div>
                    <span class="inline-flex items-center gap-1.5 text-xs font-medium text-emerald-800 bg-emerald-500/10 border border-emerald-500/20 px-3 py-1.5 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-700 animate-pulse"></span>
                        100% Gratis & Tanpa Komitmen
                    </span>
                </div>

                <form action="{{ route('test-drive.store') }}" method="POST" class="mt-8 space-y-6">
                    @csrf

                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-[#16181D] mb-4 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-[#C1121F]"></span>
                            Data Pribadi Pengemudi
                        </h3>
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
                                <label for="jadwal" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Rencana Waktu Uji Kendara</label>
                                <input id="jadwal" type="datetime-local" name="jadwal" value="{{ old('jadwal') }}" required 
                                    class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="alamat" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Alamat Domisili</label>
                        <textarea id="alamat" name="alamat" required rows="2" 
                            placeholder="Alamat lengkap tempat tinggal..."
                            class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] placeholder-gray-500 text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] p-3.5">{{ old('alamat') }}</textarea>
                    </div>

                    <div class="pt-4 border-t border-[#E5E7EB]">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-[#16181D] mb-4 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-[#C1121F]"></span>
                            Pilihan Cabang & Unit Kendaraan
                        </h3>
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
                    </div>

                    <x-input-error :messages="$errors->all()" class="text-[#C1121F] text-xs" />

                    <div class="pt-4 border-t border-[#E5E7EB]">
                        <button type="submit" 
                            class="w-full py-4 px-6 font-bold text-sm text-white bg-[#C1121F] hover:bg-[#9E0E19] rounded-xl min-h-[48px] shadow-lg shadow-[#C1121F]/25 transition-all flex items-center justify-center gap-2 active:scale-[0.99]">
                            <span>Ajukan Jadwal Test Drive</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                        <p class="mt-3 text-center text-xs text-[#4B5563]">
                            Wajib membawa kartu SIM A asli yang masih berlaku saat kehadiran di cabang dealer.
                        </p>
                    </div>
                </form>
            </div>

            <!-- Sidebar Info Column -->
            <div class="lg:col-span-5 xl:col-span-4 space-y-6 lg:sticky lg:top-24">
                <div class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-3xl p-6 sm:p-8 shadow-xl shadow-black/5">
                    <div class="flex items-center gap-3 pb-5 border-b border-[#E5E7EB]">
                        <div class="w-10 h-10 rounded-xl bg-[#C1121F]/10 text-[#C1121F] flex items-center justify-center shrink-0">
                            <x-nav-icon name="car" class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="font-bold text-base text-[#16181D]">Prosedur Uji Kendara</h3>
                            <p class="text-xs text-[#4B5563]">Standar Dealer Resmi Ayoto Nippon</p>
                        </div>
                    </div>

                    <ul class="mt-5 space-y-4 text-xs text-[#4B5563] leading-relaxed">
                        <li class="flex items-start gap-3">
                            <span class="w-5 h-5 rounded-full bg-[#C1121F]/10 text-[#C1121F] flex items-center justify-center shrink-0 mt-0.5 font-bold text-[10px]">1</span>
                            <div>
                                <strong class="text-[#16181D] block">Wajib SIM A Aktif</strong>
                                Pengemudi wajib menunjukkan kartu SIM A asli yang masih berlaku kepada sales consultant sebelum mengemudi.
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-5 h-5 rounded-full bg-[#C1121F]/10 text-[#C1121F] flex items-center justify-center shrink-0 mt-0.5 font-bold text-[10px]">2</span>
                            <div>
                                <strong class="text-[#16181D] block">Didampingi Product Genius</strong>
                                Sales consultant resmi akan menemani di kursi penumpang untuk menjelaskan fitur berkendara, ADAS, dan kenyamanan interior.
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-5 h-5 rounded-full bg-[#C1121F]/10 text-[#C1121F] flex items-center justify-center shrink-0 mt-0.5 font-bold text-[10px]">3</span>
                            <div>
                                <strong class="text-[#16181D] block">Rute Uji Fleksibel</strong>
                                Nikmati rute uji coba terencana yang mencakup jalan arteri perkotaan dan akselerasi jalan tol.
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-3xl p-6 shadow-xl shadow-black/5">
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-[#4B5563] mb-3">Jam Operasional Layanan</h4>
                    <div class="space-y-2 text-xs">
                        <div class="flex items-center justify-between py-1 border-b border-[#E5E7EB]">
                            <span class="text-[#4B5563]">Senin - Sabtu</span>
                            <span class="font-bold text-[#16181D]">08.30 - 17.00 WIB</span>
                        </div>
                        <div class="flex items-center justify-between py-1">
                            <span class="text-[#4B5563]">Minggu & Hari Libur</span>
                            <span class="font-bold text-[#16181D]">09.00 - 16.00 WIB</span>
                        </div>
                    </div>
                    <p class="mt-4 text-[11px] text-gray-400 leading-relaxed">
                        Unit test drive dipersiapkan dalam kondisi prima, tangki terisi, dan telah melalui inspeksi kebersihan menyeluruh.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <x-site-footer />
</x-site-layout>
