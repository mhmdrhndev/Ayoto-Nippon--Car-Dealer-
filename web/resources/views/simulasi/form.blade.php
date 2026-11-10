<x-site-layout judul="Simulasi Kredit" deskripsi="Hitung angsuran mobil baru per varian, cabang, dan leasing. Hasil simulasi diteruskan ke sales Ayoto Nippon.">
    <x-site-header />

    <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-8 sm:py-12">
        <div class="mb-8">
            <nav class="flex items-center gap-2 text-xs text-muted mb-2">
                <a href="{{ route('home') }}" class="hover:text-accent transition-colors">Beranda</a>
                <span>/</span>
                <span class="text-ink font-medium">Simulasi Kredit</span>
            </nav>
            <h1 class="text-2xl sm:text-4xl font-extrabold text-ink tracking-tight">Kalkulator Simulasi Kredit</h1>
            <p class="mt-2 text-sm sm:text-base text-muted max-w-3xl leading-relaxed">
                Rencanakan pembelian kendaraan baru Anda dengan estimasi uang muka (DP) dan angsuran bulanan yang transparan bersama leasing resmi terpercaya.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Form Column -->
            <div class="lg:col-span-7 xl:col-span-8 bg-surface border border-line rounded-3xl p-6 sm:p-10 shadow-xl shadow-black/5">
                <div class="pb-6 border-b border-line flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <p class="text-xs font-semibold tracking-wider text-accent uppercase">Formulir Pembiayaan</p>
                        <h2 class="mt-1 text-xl sm:text-2xl font-bold text-ink">Hitung Rencana Angsuran</h2>
                    </div>
                    <span class="inline-flex items-center gap-1.5 text-xs font-medium text-emerald-800 dark:text-emerald-300 bg-emerald-500/10 border border-emerald-500/20 px-3 py-1.5 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-700 animate-pulse"></span>
                        OTR Resmi Terupdate
                    </span>
                </div>

                <form action="{{ route('simulasi.hitung') }}" method="POST" class="mt-8 space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="variant_id" class="block text-xs font-semibold uppercase tracking-wider text-muted">Pilih Model & Varian Mobil</label>
                            <select id="variant_id" name="variant_id" required 
                                class="mt-1.5 w-full bg-surface border border-line rounded-xl text-ink text-sm focus:border-accent focus:ring-1 focus:ring-accent min-h-[48px] px-3.5">
                                <option value="" @selected(! old('variant_id', $variantId ?? null))>Pilih Varian Kendaraan</option>
                                @foreach ($variants as $variant)
                                    <option value="{{ $variant->id }}" @selected((string) old('variant_id', $variantId ?? '') === (string) $variant->id)>{{ $variant->carModel->brand->nama }} {{ $variant->carModel->nama }} {{ $variant->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="branch_id" class="block text-xs font-semibold uppercase tracking-wider text-muted">Cabang Pengiriman (Harga OTR Wilayah)</label>
                            <select id="branch_id" name="branch_id" required 
                                class="mt-1.5 w-full bg-surface border border-line rounded-xl text-ink text-sm focus:border-accent focus:ring-1 focus:ring-accent min-h-[48px] px-3.5">
                                <option value="" @selected(! old('branch_id'))>Pilih Cabang Dealer</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}" @selected((string) old('branch_id') === (string) $branch->id)>{{ $branch->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="leasing_id" class="block text-xs font-semibold uppercase tracking-wider text-muted">Lembaga Pembiayaan (Leasing Rekanan)</label>
                        <select id="leasing_id" name="leasing_id" required 
                            class="mt-1.5 w-full bg-surface border border-line rounded-xl text-ink text-sm focus:border-accent focus:ring-1 focus:ring-accent min-h-[48px] px-3.5">
                            @foreach ($leasings as $leasing)
                                <option value="{{ $leasing->id }}">{{ $leasing->nama }} (Bunga {{ $leasing->bunga_dasar }}%, DP min {{ $leasing->dp_min_persen }}%)</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="dp" class="block text-xs font-semibold uppercase tracking-wider text-muted">Rencana Uang Muka (DP, Nominal Rp)</label>
                            <input id="dp" type="number" name="dp" value="{{ old('dp') }}" min="0" required 
                                placeholder="Masukkan nominal DP..."
                                class="mt-1.5 w-full bg-surface border border-line rounded-xl text-ink text-sm focus:border-accent focus:ring-1 focus:ring-accent min-h-[48px] px-3.5 tabular-nums">
                            <p id="dp-hint" class="mt-2 text-xs text-accent font-medium leading-relaxed">Pilih varian dan cabang terlebih dahulu untuk melihat batas DP minimum.</p>
                        </div>

                        <div>
                            <label for="tenor" class="block text-xs font-semibold uppercase tracking-wider text-muted">Jangka Waktu Tenor</label>
                            <select id="tenor" name="tenor" required 
                                class="mt-1.5 w-full bg-surface border border-line rounded-xl text-ink text-sm focus:border-accent focus:ring-1 focus:ring-accent min-h-[48px] px-3.5">
                                @foreach ([12, 24, 36, 48] as $t)
                                    <option value="{{ $t }}">{{ $t }} Bulan ({{ $t / 12 }} Tahun)</option>
                                @endforeach
                            </select>
                            <p class="mt-2 text-xs text-muted">Mendukung tenor fleksibel hingga 4 tahun.</p>
                        </div>
                    </div>

                    <x-input-error :messages="$errors->all()" class="text-accent text-xs" />

                    <div class="pt-4 border-t border-line">
                        <button type="submit" 
                            class="w-full py-4 px-6 font-bold text-sm text-white bg-accent-strong hover:bg-[#9E0E19] rounded-xl min-h-[48px] shadow-lg shadow-accent/25 transition-all flex items-center justify-center gap-2 active:scale-[0.99]">
                            <span>Hitung Estimasi Angsuran</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                        <p class="mt-3 text-center text-xs text-muted">
                            Hasil perhitungan diteruskan secara otomatis ke tim sales consultant untuk konfirmasi promo dan ketersediaan unit.
                        </p>
                    </div>
                </form>
            </div>

            <!-- Sidebar Info Column -->
            <div class="lg:col-span-5 xl:col-span-4 space-y-6 lg:sticky lg:top-24">
                <div class="bg-surface border border-line rounded-3xl p-6 sm:p-8 shadow-xl shadow-black/5">
                    <div class="flex items-center gap-3 pb-5 border-b border-line">
                        <div class="w-10 h-10 rounded-xl bg-accent-strong/10 text-accent flex items-center justify-center shrink-0">
                            <x-nav-icon name="clipboard" class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="font-bold text-base text-ink">Ketentuan Kredit Resmi</h3>
                            <p class="text-xs text-muted">Standar Otoritas Jasa Keuangan (OJK)</p>
                        </div>
                    </div>

                    <ul class="mt-5 space-y-4 text-xs text-muted leading-relaxed">
                        <li class="flex items-start gap-3">
                            <span class="w-5 h-5 rounded-full bg-accent-strong/10 text-accent flex items-center justify-center shrink-0 mt-0.5 font-bold text-[10px]">1</span>
                            <div>
                                <strong class="text-ink block">DP Minimum Sesuai Regulasi</strong>
                                Besaran DP berkisar 15% - 20% tergantung pada paket pembiayaan dan lembaga keuangan rekanan yang dipilih.
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-5 h-5 rounded-full bg-accent-strong/10 text-accent flex items-center justify-center shrink-0 mt-0.5 font-bold text-[10px]">2</span>
                            <div>
                                <strong class="text-ink block">Perlindungan Asuransi</strong>
                                Sudah termasuk asuransi Comprehensive (All Risk) atau Total Loss Only (TLO) selama masa tenor kredit.
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-5 h-5 rounded-full bg-accent-strong/10 text-accent flex items-center justify-center shrink-0 mt-0.5 font-bold text-[10px]">3</span>
                            <div>
                                <strong class="text-ink block">Proses Persetujuan Cepat</strong>
                                Pengajuan berkas dibantu langsung oleh sales advisor dengan estimasi analisa 1x24 jam kerja.
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="bg-surface border border-line rounded-3xl p-6 shadow-xl shadow-black/5">
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-muted mb-3">Mitra Pembiayaan Terverifikasi</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($leasings as $l)
                            <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-surface-2 border border-line text-ink">
                                {{ $l->nama }}
                            </span>
                        @endforeach
                    </div>
                    <p class="mt-4 text-[11px] text-muted">
                        Seluruh lembaga pembiayaan terdaftar dan diawasi oleh OJK. Suku bunga dan ketentuan dapat berubah sewaktu-waktu sesuai kebijakan berlaku.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <x-site-footer />

    <script>
        const prices = @json($prices);
        const leasings = @json($leasings->mapWithKeys(fn ($l) => [$l->id => $l->dp_min_persen]));
        const rupiah = (n) => 'Rp ' + Number(n).toLocaleString('id-ID');
        function syncDp() {
            const v = document.getElementById('variant_id').value;
            const b = document.getElementById('branch_id').value;
            const l = document.getElementById('leasing_id').value;
            const dp = document.getElementById('dp');
            const hint = document.getElementById('dp-hint');
            if (!v || !b) {
                dp.min = 0;
                hint.textContent = 'Pilih varian dan cabang terlebih dahulu untuk melihat batas DP minimum.';
                return;
            }
            const row = prices.find((p) => String(p.variant_id) === String(v) && String(p.branch_id) === String(b));
            if (!row) {
                dp.min = 0;
                hint.textContent = 'Harga OTR belum tersedia untuk kombinasi cabang dan varian ini.';
                return;
            }
            const min = Math.ceil(row.otr * (leasings[l] ?? 0) / 100);
            dp.min = min;
            hint.textContent = 'Batas DP minimum: ' + rupiah(min) + ' (' + (leasings[l] ?? 0) + '% dari OTR ' + rupiah(row.otr) + ').';
        }
        ['variant_id', 'branch_id', 'leasing_id'].forEach((id) => document.getElementById(id).addEventListener('change', syncDp));
        syncDp();
    </script>
</x-site-layout>
