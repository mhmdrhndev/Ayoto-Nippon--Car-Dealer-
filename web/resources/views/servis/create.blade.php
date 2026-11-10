<x-site-layout judul="Booking Servis" deskripsi="Jadwalkan servis mobil terjadwal per cabang Ayoto Nippon.">
    <x-site-header />

    <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-8 sm:py-12">
        <div class="mb-8">
            <nav class="flex items-center gap-2 text-xs text-muted mb-2">
                <a href="{{ route('home') }}" class="hover:text-accent transition-colors">Beranda</a>
                <span>/</span>
                <span class="text-ink font-medium">Servis Bengkel</span>
            </nav>
            <h1 class="text-2xl sm:text-4xl font-extrabold text-ink tracking-tight">Booking Jadwal Servis Berkala</h1>
            <p class="mt-2 text-sm sm:text-base text-muted max-w-3xl leading-relaxed">
                Percayakan perawatan mobil Anda pada teknisi bersertifikasi pabrikan dengan peralatan diagnostik komputer mutakhir dan suku cadang asli bergaransi.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Form Column -->
            <div class="lg:col-span-7 xl:col-span-8 bg-surface border border-line rounded-3xl p-6 sm:p-10 shadow-xl shadow-black/5">
                <div class="pb-6 border-b border-line flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <p class="text-xs font-semibold tracking-wider text-accent uppercase">Bengkel Resmi Dealer</p>
                        <h2 class="mt-1 text-xl sm:text-2xl font-bold text-ink">Formulir Reservasi Stall Servis</h2>
                    </div>
                    <span class="inline-flex items-center gap-1.5 text-xs font-medium text-emerald-800 dark:text-emerald-300 bg-emerald-500/10 border border-emerald-500/20 px-3 py-1.5 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-700 animate-pulse"></span>
                        Garansi Servis 1.000 KM
                    </span>
                </div>

                <form action="{{ route('servis.store') }}" method="POST" class="mt-8 space-y-6">
                    @csrf

                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-ink mb-4 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-accent-strong"></span>
                            Informasi Pemilik & Kendaraan
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="nama" class="block text-xs font-semibold uppercase tracking-wider text-muted">Nama Pemilik / Pembawa Mobil</label>
                                <input id="nama" name="nama" value="{{ old('nama') }}" required 
                                    placeholder="Sesuai STNK / KTP"
                                    class="mt-1.5 w-full bg-surface border border-line rounded-xl text-ink placeholder-gray-500 text-sm focus:border-accent focus:ring-1 focus:ring-accent min-h-[48px] px-3.5">
                            </div>

                            <div>
                                <label for="nik" class="block text-xs font-semibold uppercase tracking-wider text-muted">NIK KTP (16 Digit)</label>
                                <input id="nik" name="nik" value="{{ old('nik') }}" required inputmode="numeric" maxlength="16" 
                                    placeholder="3201..."
                                    class="mt-1.5 w-full bg-surface border border-line rounded-xl text-ink placeholder-gray-500 text-sm focus:border-accent focus:ring-1 focus:ring-accent min-h-[48px] px-3.5">
                            </div>

                            <div>
                                <label for="telp" class="block text-xs font-semibold uppercase tracking-wider text-muted">Nomor WhatsApp / Telepon</label>
                                <input id="telp" name="telp" value="{{ old('telp') }}" required inputmode="tel" 
                                    placeholder="0812..."
                                    class="mt-1.5 w-full bg-surface border border-line rounded-xl text-ink placeholder-gray-500 text-sm focus:border-accent focus:ring-1 focus:ring-accent min-h-[48px] px-3.5">
                            </div>

                            <div>
                                <label for="nopol" class="block text-xs font-semibold uppercase tracking-wider text-muted">Nomor Polisi (Plat Kendaraan)</label>
                                <input id="nopol" name="nopol" value="{{ old('nopol') }}" required 
                                    placeholder="Contoh: B 1234 NIP"
                                    class="mt-1.5 w-full bg-surface border border-line rounded-xl text-ink placeholder-gray-500 text-sm focus:border-accent focus:ring-1 focus:ring-accent min-h-[48px] px-3.5 uppercase font-mono">
                            </div>

                            <div>
                                <label for="vin" class="block text-xs font-semibold uppercase tracking-wider text-muted">Nomor Rangka VIN (Opsional)</label>
                                <input id="vin" name="vin" value="{{ old('vin') }}" 
                                    placeholder="17 Digit VIN tertera di STNK"
                                    class="mt-1.5 w-full bg-surface border border-line rounded-xl text-ink placeholder-gray-500 text-sm font-mono focus:border-accent focus:ring-1 focus:ring-accent min-h-[48px] px-3.5">
                            </div>

                            <div>
                                <label for="km" class="block text-xs font-semibold uppercase tracking-wider text-muted">Kilometer Kendaraan Saat Ini</label>
                                <input id="km" type="number" name="km" value="{{ old('km') }}" required min="0" 
                                    placeholder="Contoh: 10000"
                                    class="mt-1.5 w-full bg-surface border border-line rounded-xl text-ink placeholder-gray-500 text-sm focus:border-accent focus:ring-1 focus:ring-accent min-h-[48px] px-3.5 tabular-nums">
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-line">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-ink mb-4 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-accent-strong"></span>
                            Lokasi Bengkel & Waktu Kunjungan
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="branch_id" class="block text-xs font-semibold uppercase tracking-wider text-muted">Cabang Bengkel Resmi</label>
                                <select id="branch_id" name="branch_id" required 
                                    class="mt-1.5 w-full bg-surface border border-line rounded-xl text-ink text-sm focus:border-accent focus:ring-1 focus:ring-accent min-h-[48px] px-3.5">
                                    <option value="" @selected(! old('branch_id'))>Pilih Cabang</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="jadwal" class="block text-xs font-semibold uppercase tracking-wider text-muted">Rencana Waktu Kedatangan</label>
                                <input id="jadwal" type="datetime-local" name="jadwal" value="{{ old('jadwal') }}" required 
                                    class="mt-1.5 w-full bg-surface border border-line rounded-xl text-ink text-sm focus:border-accent focus:ring-1 focus:ring-accent min-h-[48px] px-3.5">
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-line space-y-5">
                        <div>
                            <label for="alamat" class="block text-xs font-semibold uppercase tracking-wider text-muted">Alamat Tempat Tinggal</label>
                            <textarea id="alamat" name="alamat" required rows="2" 
                                placeholder="Alamat domisili pemilik..."
                                class="mt-1.5 w-full bg-surface border border-line rounded-xl text-ink placeholder-gray-500 text-sm focus:border-accent focus:ring-1 focus:ring-accent p-3.5">{{ old('alamat') }}</textarea>
                        </div>

                        <div>
                            <label for="keluhan" class="block text-xs font-semibold uppercase tracking-wider text-muted">Keluhan atau Paket Servis yang Diminta</label>
                            <textarea id="keluhan" name="keluhan" required rows="3" 
                                placeholder="Misal: Servis berkala 10.000 KM, ganti oli mesin, rem bunyi berdecit saat macet..."
                                class="mt-1.5 w-full bg-surface border border-line rounded-xl text-ink placeholder-gray-500 text-sm focus:border-accent focus:ring-1 focus:ring-accent p-3.5">{{ old('keluhan') }}</textarea>
                        </div>
                    </div>

                    <x-input-error :messages="$errors->all()" class="text-accent text-xs" />

                    <div class="pt-4 border-t border-line">
                        <button type="submit" 
                            class="w-full py-4 px-6 font-bold text-sm text-white bg-accent-strong hover:bg-[#9E0E19] rounded-xl min-h-[48px] shadow-lg shadow-accent/25 transition-all flex items-center justify-center gap-2 active:scale-[0.99]">
                            <span>Konfirmasi Booking Servis</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                        <p class="mt-3 text-center text-xs text-muted">
                            Service advisor cabang kami akan menghubungi via WhatsApp untuk konfirmasi ketersediaan stall mekanik.
                        </p>
                    </div>
                </form>
            </div>

            <!-- Sidebar Info Column -->
            <div class="lg:col-span-5 xl:col-span-4 space-y-6 lg:sticky lg:top-24">
                <div class="bg-surface border border-line rounded-3xl p-6 sm:p-8 shadow-xl shadow-black/5">
                    <div class="flex items-center gap-3 pb-5 border-b border-line">
                        <div class="w-10 h-10 rounded-xl bg-accent-strong/10 text-accent flex items-center justify-center shrink-0">
                            <x-nav-icon name="wrench" class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="font-bold text-base text-ink">Standar Bengkel Resmi</h3>
                            <p class="text-xs text-muted">Jaminan Kualitas 3S Authorized</p>
                        </div>
                    </div>

                    <ul class="mt-5 space-y-4 text-xs text-muted leading-relaxed">
                        <li class="flex items-start gap-3">
                            <span class="w-5 h-5 rounded-full bg-accent-strong/10 text-accent flex items-center justify-center shrink-0 mt-0.5"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></span>
                            <div>
                                <strong class="text-ink block">Teknisi Tersertifikasi</strong>
                                Dikerjakan oleh mekanik berpengalaman dengan sertifikasi resmi manufaktur.
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-5 h-5 rounded-full bg-accent-strong/10 text-accent flex items-center justify-center shrink-0 mt-0.5"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></span>
                            <div>
                                <strong class="text-ink block">100% Suku Cadang Asli</strong>
                                Penggantian komponen hanya menggunakan sparepart orisinal dengan barcode terdaftar.
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-5 h-5 rounded-full bg-accent-strong/10 text-accent flex items-center justify-center shrink-0 mt-0.5"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></span>
                            <div>
                                <strong class="text-ink block">Gratis Inspeksi 21 Titik</strong>
                                Pengecekan menyeluruh sistem rem, kelistrikan, fluida mesin, dan kondisi ban.
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-5 h-5 rounded-full bg-accent-strong/10 text-accent flex items-center justify-center shrink-0 mt-0.5"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></span>
                            <div>
                                <strong class="text-ink block">Garansi Pekerjaan</strong>
                                Garansi servis selama 1.000 KM atau 14 hari kerja setelah kendaraan keluar bengkel.
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="bg-surface border border-line rounded-3xl p-6 shadow-xl shadow-black/5">
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-muted mb-3">Fasilitas Customer Lounge</h4>
                    <div class="grid grid-cols-2 gap-2 text-xs text-ink font-medium">
                        <div class="p-2.5 rounded-xl bg-surface-2 border border-line flex items-center gap-2">
                            <span class="text-accent"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 8h12v6a4 4 0 01-4 4H8a4 4 0 01-4-4V8z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 9h2a2 2 0 010 4h-2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 3v3M11 3v3"/></svg></span> Free Kopi & Teh
                        </div>
                        <div class="p-2.5 rounded-xl bg-surface-2 border border-line flex items-center gap-2">
                            <span class="text-accent"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 9a12 12 0 0116 0"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 13a7 7 0 0110 0"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.5 16.5a2.5 2.5 0 013 0"/><circle cx="12" cy="19.5" r="1"/></svg></span> High-Speed WiFi
                        </div>
                        <div class="p-2.5 rounded-xl bg-surface-2 border border-line flex items-center gap-2">
                            <span class="text-accent"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3v18M4.2 7.5l15.6 9M19.8 7.5l-15.6 9"/></svg></span> Ruang AC Nyaman
                        </div>
                        <div class="p-2.5 rounded-xl bg-surface-2 border border-line flex items-center gap-2">
                            <span class="text-accent"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="4" width="18" height="12" rx="2" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 20h8M12 16v4"/></svg></span> Live CCTV Bengkel
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-site-footer />
</x-site-layout>
