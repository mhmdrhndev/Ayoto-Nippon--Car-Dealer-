<x-site-layout judul="Pengajuan Trade-In" deskripsi="Tukar tambah mobil lama Anda dengan unit baru di Ayoto Nippon.">
    <x-site-header />

    <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-8 sm:py-12">
        <div class="mb-8">
            <nav class="flex items-center gap-2 text-xs text-muted mb-2">
                <a href="{{ route('home') }}" class="hover:text-accent transition-colors">Beranda</a>
                <span>/</span>
                <span class="text-ink font-medium">Tukar Tambah (Trade-In)</span>
            </nav>
            <h1 class="text-2xl sm:text-4xl font-extrabold text-ink tracking-tight">Pengajuan Trade-In Kendaraan</h1>
            <p class="mt-2 text-sm sm:text-base text-muted max-w-3xl leading-relaxed">
                Tukarkan mobil lama merek apapun menjadi uang muka unit baru dengan proses appraisal profesional dan penawaran harga pasar yang kompetitif.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Form Column -->
            <div class="lg:col-span-7 xl:col-span-8 bg-surface border border-line rounded-3xl p-6 sm:p-10 shadow-xl shadow-black/5">
                <div class="pb-6 border-b border-line flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <p class="text-xs font-semibold tracking-wider text-accent uppercase">Appraisal Resmi Dealer</p>
                        <h2 class="mt-1 text-xl sm:text-2xl font-bold text-ink">Formulir Penilaian Mobil Lama</h2>
                    </div>
                    <span class="inline-flex items-center gap-1.5 text-xs font-medium text-emerald-800 dark:text-emerald-300 bg-emerald-500/10 border border-emerald-500/20 px-3 py-1.5 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-700 animate-pulse"></span>
                        Inspeksi Gratis di Rumah / Dealer
                    </span>
                </div>

                <form action="{{ route('trade-in.store') }}" method="POST" enctype="multipart/form-data" class="mt-8 space-y-6">
                    @csrf

                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-ink mb-4 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-accent-strong"></span>
                            Informasi Pemilik & Kontak
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                            <div>
                                <label for="nama" class="block text-xs font-semibold uppercase tracking-wider text-muted">Nama Lengkap</label>
                                <input id="nama" name="nama" value="{{ old('nama') }}" required 
                                    placeholder="Sesuai KTP"
                                    class="mt-1.5 w-full bg-surface border border-line rounded-xl text-ink placeholder-gray-500 text-sm focus:border-accent focus:ring-1 focus:ring-accent min-h-[48px] px-3.5">
                            </div>

                            <div>
                                <label for="nik" class="block text-xs font-semibold uppercase tracking-wider text-muted">NIK KTP (16 Digit)</label>
                                <input id="nik" name="nik" value="{{ old('nik') }}" required inputmode="numeric" maxlength="16" 
                                    placeholder="3201..."
                                    class="mt-1.5 w-full bg-surface border border-line rounded-xl text-ink placeholder-gray-500 text-sm focus:border-accent focus:ring-1 focus:ring-accent min-h-[48px] px-3.5">
                            </div>

                            <div>
                                <label for="telp" class="block text-xs font-semibold uppercase tracking-wider text-muted">Nomor WhatsApp</label>
                                <input id="telp" name="telp" value="{{ old('telp') }}" required 
                                    placeholder="0812..."
                                    class="mt-1.5 w-full bg-surface border border-line rounded-xl text-ink placeholder-gray-500 text-sm focus:border-accent focus:ring-1 focus:ring-accent min-h-[48px] px-3.5">
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-line">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-ink mb-4 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-accent-strong"></span>
                            Spesifikasi Mobil yang Ditukarkan
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                            <div>
                                <label for="merk_tipe" class="block text-xs font-semibold uppercase tracking-wider text-muted">Merek & Model Mobil Lama</label>
                                <input id="merk_tipe" name="merk_tipe" value="{{ old('merk_tipe') }}" required 
                                    placeholder="Contoh: Honda Jazz RS AT"
                                    class="mt-1.5 w-full bg-surface border border-line rounded-xl text-ink placeholder-gray-500 text-sm focus:border-accent focus:ring-1 focus:ring-accent min-h-[48px] px-3.5">
                            </div>

                            <div>
                                <label for="tahun" class="block text-xs font-semibold uppercase tracking-wider text-muted">Tahun Pembuatan</label>
                                <input id="tahun" type="number" name="tahun" value="{{ old('tahun') }}" required 
                                    placeholder="Contoh: 2019"
                                    class="mt-1.5 w-full bg-surface border border-line rounded-xl text-ink placeholder-gray-500 text-sm focus:border-accent focus:ring-1 focus:ring-accent min-h-[48px] px-3.5 tabular-nums">
                            </div>

                            <div>
                                <label for="km" class="block text-xs font-semibold uppercase tracking-wider text-muted">Jarak Tempuh (KM Odometer)</label>
                                <input id="km" type="number" name="km" value="{{ old('km') }}" required min="0" 
                                    placeholder="Contoh: 45000"
                                    class="mt-1.5 w-full bg-surface border border-line rounded-xl text-ink placeholder-gray-500 text-sm focus:border-accent focus:ring-1 focus:ring-accent min-h-[48px] px-3.5 tabular-nums">
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-line space-y-5">
                        <div>
                            <label for="alamat" class="block text-xs font-semibold uppercase tracking-wider text-muted">Alamat Domisili Inspeksi</label>
                            <textarea id="alamat" name="alamat" required rows="2" 
                                placeholder="Alamat lokasi unit mobil lama saat ini..."
                                class="mt-1.5 w-full bg-surface border border-line rounded-xl text-ink placeholder-gray-500 text-sm focus:border-accent focus:ring-1 focus:ring-accent p-3.5">{{ old('alamat') }}</textarea>
                        </div>

                        @if ($orders->isNotEmpty())
                            <div>
                                <label for="order_id" class="block text-xs font-semibold uppercase tracking-wider text-muted">Tautkan ke SPK Unit Baru (Opsional)</label>
                                <select id="order_id" name="order_id" 
                                    class="mt-1.5 w-full bg-surface border border-line rounded-xl text-ink text-sm focus:border-accent focus:ring-1 focus:ring-accent min-h-[48px] px-3.5">
                                    <option value="">Tanpa Tautan SPK</option>
                                    @foreach ($orders as $order)
                                        <option value="{{ $order->id }}">{{ $order->no_spk }} ({{ $order->unit->variant->nama ?? 'Unit Baru' }})</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div>
                            <label for="foto" class="block text-xs font-semibold uppercase tracking-wider text-muted">Unggah Foto Kendaraan (Maksimal 3 File, JPG/PNG, 2MB per file)</label>
                            <div class="mt-1.5 p-4 bg-surface border border-line rounded-xl flex flex-col items-center justify-center text-center">
                                <input id="foto" type="file" name="foto[]" multiple accept=".jpg,.jpeg,.png" 
                                    class="w-full text-xs text-muted file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-accent-strong file:text-white hover:file:bg-[#9E0E19] cursor-pointer">
                            </div>
                        </div>
                    </div>

                    <x-input-error :messages="$errors->all()" class="text-accent text-xs" />

                    <div class="pt-4 border-t border-line">
                        <button type="submit" 
                            class="w-full py-4 px-6 font-bold text-sm text-white bg-accent-strong hover:bg-[#9E0E19] rounded-xl min-h-[48px] shadow-lg shadow-accent/25 transition-all flex items-center justify-center gap-2 active:scale-[0.99]">
                            <span>Kirim Formulir Trade-In</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                        <p class="mt-3 text-center text-xs text-muted">
                            Tim appraisal dealer resmi kami akan menghubungi Anda untuk konfirmasi jadwal inspeksi fisik mobil.
                        </p>
                    </div>
                </form>
            </div>

            <!-- Sidebar Info Column -->
            <div class="lg:col-span-5 xl:col-span-4 space-y-6 lg:sticky lg:top-24">
                <div class="bg-surface border border-line rounded-3xl p-6 sm:p-8 shadow-xl shadow-black/5">
                    <div class="flex items-center gap-3 pb-5 border-b border-line">
                        <div class="w-10 h-10 rounded-xl bg-accent-strong/10 text-accent flex items-center justify-center shrink-0">
                            <x-nav-icon name="swap" class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="font-bold text-base text-ink">Keuntungan Trade-In Dealer</h3>
                            <p class="text-xs text-muted">Solusi Mudah Ganti Mobil Baru</p>
                        </div>
                    </div>

                    <ul class="mt-5 space-y-4 text-xs text-muted leading-relaxed">
                        <li class="flex items-start gap-3">
                            <span class="w-5 h-5 rounded-full bg-accent-strong/10 text-accent flex items-center justify-center shrink-0 mt-0.5 font-bold text-[10px]">1</span>
                            <div>
                                <strong class="text-ink block">Terima Semua Merek</strong>
                                Kami menerima mobil lama dari seluruh pabrikan tanpa membatasi merek tertentu.
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-5 h-5 rounded-full bg-accent-strong/10 text-accent flex items-center justify-center shrink-0 mt-0.5 font-bold text-[10px]">2</span>
                            <div>
                                <strong class="text-ink block">Langsung Potong DP</strong>
                                Nilai taksiran mobil lama dapat dialokasikan langsung sebagai uang muka (DP) pesanan mobil baru.
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-5 h-5 rounded-full bg-accent-strong/10 text-accent flex items-center justify-center shrink-0 mt-0.5 font-bold text-[10px]">3</span>
                            <div>
                                <strong class="text-ink block">Inspeksi Objektif & Transparan</strong>
                                Pengecekan 100+ titik rangka mesin bebas tabrakan parah dan bebas banjir oleh appraiser bersertifikasi.
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="bg-surface border border-line rounded-3xl p-6 shadow-xl shadow-black/5">
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-muted mb-3">Dokumen yang Perlu Disiapkan</h4>
                    <ul class="space-y-2 text-xs text-ink">
                        <li class="flex items-center gap-2">
                            <span class="text-accent"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 3H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V8l-5-5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 3v5h5"/></svg></span> STNK & BPKB Asli
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-accent"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><circle cx="8" cy="8" r="3" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.5 10.5L20 20M17 17l2-2M14 14l2-2"/></svg></span> Kunci Cadangan & Buku Servis
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-accent"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"/><circle cx="9" cy="11" r="2" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 16c.8-1.3 1.8-2 3-2s2.2.7 3 2M15 10h3M15 14h3"/></svg></span> KTP Pemilik Sesuai BPKB
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <x-site-footer />
</x-site-layout>
