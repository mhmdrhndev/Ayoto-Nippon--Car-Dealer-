<x-site-layout judul="Hasil Simulasi Kredit" deskripsi="Rincian angsuran simulasi kredit mobil baru Ayoto Nippon.">
    <x-site-header />

    <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-8 sm:py-12">
        <div class="mb-8">
            <nav class="flex items-center gap-2 text-xs text-muted mb-2">
                <a href="{{ route('home') }}" class="hover:text-accent transition-colors">Beranda</a>
                <span>/</span>
                <a href="{{ route('simulasi.form') }}" class="hover:text-accent transition-colors">Simulasi Kredit</a>
                <span>/</span>
                <span class="text-ink font-medium">Hasil Estimasi</span>
            </nav>
            <h1 class="text-2xl sm:text-4xl font-extrabold text-ink tracking-tight">Hasil Estimasi Pembiayaan</h1>
            <p class="mt-2 text-sm sm:text-base text-muted max-w-3xl leading-relaxed">
                Berikut adalah simulasi rincian angsuran untuk {{ $variant->carModel->brand->nama }} {{ $variant->carModel->nama }} {{ $variant->nama }} melalui {{ $leasing->nama }}.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Main Result Column -->
            <div class="lg:col-span-7 xl:col-span-8 space-y-6">
                <div class="bg-surface border border-line rounded-3xl p-6 sm:p-10 shadow-xl shadow-black/5">
                    <div class="pb-6 border-b border-line flex items-center justify-between flex-wrap gap-4">
                        <div>
                            <p class="text-xs font-semibold tracking-wider text-accent uppercase">Rincian Angsuran</p>
                            <h2 class="mt-1 text-xl sm:text-2xl font-bold text-ink">
                                {{ $variant->carModel->brand->nama }} {{ $variant->carModel->nama }} {{ $variant->nama }}
                            </h2>
                        </div>
                        <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-semibold bg-surface-2 border border-line text-ink">
                            Mitra: {{ $leasing->nama }}
                        </span>
                    </div>

                    <!-- Highlighted Angsuran Box -->
                    <div class="mt-8 p-6 sm:p-8 bg-gradient-to-br from-surface via-[#FFF8F8] to-[#FFF1F2] dark:via-surface-2 dark:to-surface-2 border-2 border-accent/20 rounded-2xl text-center relative overflow-hidden shadow-lg shadow-accent/5">
                        <div class="absolute -top-12 -right-12 w-36 h-36 bg-accent-strong/10 rounded-full blur-2xl pointer-events-none"></div>
                        <p class="text-xs font-bold text-accent uppercase tracking-wider">Estimasi Angsuran Bulanan</p>
                        <p class="mt-3 text-3xl sm:text-5xl font-black text-accent tabular-nums tracking-tight">
                            Rp {{ number_format($angsuran, 0, ',', '.') }}
                            <span class="text-sm sm:text-base font-semibold text-muted">/bulan</span>
                        </p>
                        <div class="mt-4 flex items-center justify-center gap-3 text-xs text-muted flex-wrap">
                            <span class="px-2.5 py-1 rounded-md bg-surface border border-line font-medium">Tenor: {{ $tenor }} Bulan ({{ $tenor / 12 }} Tahun)</span>
                            <span class="px-2.5 py-1 rounded-md bg-surface border border-line font-medium">Bunga: Flat {{ $leasing->bunga_dasar }}% p.a.</span>
                        </div>
                    </div>

                    <!-- Detail Grid -->
                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-5 bg-surface-2 border border-line rounded-2xl">
                            <p class="text-xs text-muted uppercase tracking-wider font-semibold">Harga OTR Kendaraan</p>
                            <p class="mt-1 text-xl font-bold text-ink tabular-nums">Rp {{ number_format($otr, 0, ',', '.') }}</p>
                            <p class="mt-1 text-[11px] text-muted">Harga on-the-road cabang pengiriman terpilih.</p>
                        </div>

                        <div class="p-5 bg-surface-2 border border-line rounded-2xl">
                            <p class="text-xs text-muted uppercase tracking-wider font-semibold">Lembaga Pembiayaan</p>
                            <p class="mt-1 text-xl font-bold text-ink">{{ $leasing->nama }}</p>
                            <p class="mt-1 text-[11px] text-muted">DP minimum rekanan {{ $leasing->dp_min_persen }}%.</p>
                        </div>
                    </div>

                    <p class="mt-6 text-xs text-muted leading-relaxed">
                        *Perhitungan ini merupakan estimasi awal. Besaran uang muka total (TDP) final dapat mencakup asuransi kendaraan, biaya administrasi, dan angsuran pertama (ADDB/ADDM) sesuai persetujuan leasing.
                    </p>

                    <!-- Action Buttons -->
                    <div class="mt-8 pt-6 border-t border-line grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a href="{{ route('spk.create', ['variant_id' => $variant->id]) }}" 
                            class="py-4 px-6 text-center font-bold text-sm text-white bg-accent-strong hover:bg-[#9E0E19] rounded-xl shadow-lg shadow-accent/25 transition-all min-h-[48px] flex items-center justify-center gap-2 active:scale-[0.99]">
                            <span>Lanjut Pemesanan SPK</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                        <a href="{{ route('simulasi.form', ['variant_id' => $variant->id]) }}" 
                            class="py-4 px-6 text-center font-semibold text-sm text-muted hover:text-ink bg-surface border border-line hover:border-accent rounded-xl transition-all min-h-[48px] flex items-center justify-center">
                            Hitung Ulang Simulasi
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sidebar Guidance Column -->
            <div class="lg:col-span-5 xl:col-span-4 space-y-6 lg:sticky lg:top-24">
                <div class="bg-surface border border-line rounded-3xl p-6 sm:p-8 shadow-xl shadow-black/5">
                    <h3 class="font-bold text-base text-ink pb-4 border-b border-line">Langkah Pasca Simulasi</h3>
                    <ol class="mt-5 space-y-4 text-xs text-muted leading-relaxed">
                        <li class="flex items-start gap-3">
                            <span class="w-6 h-6 rounded-full bg-accent-strong text-white flex items-center justify-center shrink-0 font-bold text-xs">1</span>
                            <div>
                                <strong class="text-ink block text-sm">Pesan Unit via SPK</strong>
                                Kunci nomor alokasi unit fisik dan warna yang Anda inginkan dengan booking fee resmi.
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-6 h-6 rounded-full bg-ink text-surface flex items-center justify-center shrink-0 font-bold text-xs">2</span>
                            <div>
                                <strong class="text-ink block text-sm">Siapkan Berkas Kredit</strong>
                                Siapkan e-KTP, Kartu Keluarga, NPWP, dan slip gaji / bukti rekening koran 3 bulan terakhir.
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-6 h-6 rounded-full bg-ink text-surface flex items-center justify-center shrink-0 font-bold text-xs">3</span>
                            <div>
                                <strong class="text-ink block text-sm">Survey & Persetujuan Leasing</strong>
                                Petugas leasing menghubungi Anda untuk validasi data pembiayaan (1-2 hari kerja).
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-6 h-6 rounded-full bg-ink text-surface flex items-center justify-center shrink-0 font-bold text-xs">4</span>
                            <div>
                                <strong class="text-ink block text-sm">Pengiriman Mobil ke Rumah</strong>
                                Mobil diantar menggunakan towing resmi atau serah terima di dealer lengkap dengan STNK.
                            </div>
                        </li>
                    </ol>
                </div>

                <div class="bg-gradient-to-br from-[#16181D] to-[#252830] text-white rounded-3xl p-6 shadow-xl">
                    <p class="text-xs font-semibold text-[#FF6B6B] uppercase tracking-wider">Konsultasi Gratis</p>
                    <h4 class="mt-1 font-bold text-lg text-white">Butuh Negosiasi DP atau Promo Khusus?</h4>
                    <p class="mt-2 text-xs text-gray-300 leading-relaxed">
                        Tim sales kami siap membantu menghitungkan paket DP minim, bunga 0%, atau program khusus PNS, BUMN, dan korporat.
                    </p>
                    <a href="{{ route('cabang.index') }}" class="mt-4 inline-flex items-center justify-center w-full py-2.5 px-4 rounded-xl bg-surface text-ink font-bold text-xs hover:bg-surface-2 transition-colors">
                        Hubungi Cabang Terdekat
                    </a>
                </div>
            </div>
        </div>
    </div>

    <x-site-footer />
</x-site-layout>
