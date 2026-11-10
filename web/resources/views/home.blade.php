<x-site-layout judul="Mobil Baru Harga OTR Jelas" deskripsi="Ayoto Nippon: katalog mobil baru dengan harga OTR jelas per cabang, simulasi kredit, test drive, servis, dan trade-in di Jakarta dan Bandung.">
    <x-site-header />

    <!-- Hero Section -->
    <section class="relative bg-surface overflow-hidden flex flex-col lg:flex-row lg:min-h-[calc(100svh-73px)]" aria-label="Sorotan Utama"
        x-data="{
            active: 0,
            total: {{ $slides->count() }},
            timer: null,
            jalan: true,
            init() {
                if (this.total < 2 || window.matchMedia('(prefers-reduced-motion: reduce)').matches) { this.jalan = false; return; }
                this.mulai();
                document.addEventListener('visibilitychange', () => {
                    if (document.hidden) { clearInterval(this.timer); this.timer = null; }
                    else if (this.jalan && !this.timer) { this.mulai(); }
                });
            },
            mulai() {
                clearInterval(this.timer);
                this.timer = setInterval(() => { this.active = (this.active + 1) % this.total; }, 7000);
            },
            jeda() {
                clearInterval(this.timer);
                this.timer = null;
                this.jalan = false;
            },
            putar() {
                this.jalan = true;
                this.mulai();
            },
            mulaiUlang() {
                clearInterval(this.timer);
                this.mulai();
            }
        }">

        <!-- Konten -->
        <div class="relative z-10 order-2 lg:order-1 w-full lg:w-[54%] xl:w-[52%] flex flex-col justify-center px-4 sm:px-8 lg:px-10 xl:px-16 py-10 sm:py-14 lg:py-16">
            <p class="flex items-center gap-3 text-[11px] font-bold tracking-[0.18em] uppercase text-accent">
                <span class="w-8 h-px bg-accent-strong" aria-hidden="true"></span>
                Dealer Resmi Jakarta &amp; Bandung
            </p>

            <h1 class="mt-5 text-[2.6rem] leading-[0.98] sm:text-6xl xl:text-7xl font-extrabold tracking-tight text-ink">
                Mobil Baru.<br>
                Harga <span class="text-accent">OTR</span> Transparan.
            </h1>
            <p class="mt-5 max-w-xl text-sm sm:text-base text-muted leading-relaxed">
                Pilih unit siap kirim per cabang, hitung simulasi pembiayaan secara mandiri, dan pantau proses penerbitan SPK secara real-time.
            </p>

            <!-- Form Pencarian -->
            <form action="{{ route('katalog.index') }}" method="GET" class="mt-7 w-full max-w-2xl bg-surface border border-line rounded-2xl p-3 sm:p-4 shadow-[0_24px_60px_-36px_rgba(22,24,29,0.55)]">
                <div class="grid grid-cols-1 sm:grid-cols-[1.5fr_1fr_auto] gap-3 sm:items-end">
                    <div>
                        <label for="hero-q" class="block text-[10px] font-semibold tracking-wider uppercase text-muted mb-1.5">Model / Varian</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-muted" aria-hidden="true">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </span>
                            <input id="hero-q" type="text" name="q" value="{{ request('q') }}" placeholder="Cari Avanza, CR-V"
                                class="w-full pl-10 pr-4 py-3 bg-surface-2 border border-line rounded-xl text-sm text-ink placeholder-[#6B7280] min-h-[48px] focus:outline-none focus:bg-surface focus:border-accent focus:ring-2 focus:ring-accent/20 transition-colors">
                        </div>
                    </div>

                    <div>
                        <label for="hero-cabang" class="block text-[10px] font-semibold tracking-wider uppercase text-muted mb-1.5">Cabang</label>
                        <select id="hero-cabang" name="cabang"
                            class="w-full px-3.5 py-3 bg-surface-2 border border-line rounded-xl text-sm text-ink min-h-[48px] focus:outline-none focus:bg-surface focus:border-accent focus:ring-2 focus:ring-accent/20 transition-colors">
                            <option value="">Semua Cabang</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->kode }}">{{ $branch->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit"
                        class="px-7 py-3 font-semibold text-sm text-white bg-accent-strong hover:bg-[#9E0E19] rounded-xl min-h-[48px] shadow-lg shadow-accent/25 transition-all active:scale-[0.98]">
                        Cari Unit
                    </button>
                </div>
            </form>

            <!-- Akses Cepat -->
            <div class="mt-5 flex flex-wrap items-center gap-2 sm:gap-2.5">
                <span class="text-[11px] font-semibold tracking-wider uppercase text-muted mr-1">Akses cepat</span>
                @foreach ([['test-drive.create', 'Booking Test Drive'], ['simulasi.form', 'Simulasi Kredit'], ['lacak.form', 'Lacak Status SPK']] as [$rute, $label])
                    <a href="{{ route($rute) }}" class="px-3.5 py-2 text-xs font-medium text-ink bg-surface border border-line rounded-lg min-h-[44px] inline-flex items-center hover:text-accent hover:border-accent transition-colors">{{ $label }}</a>
                @endforeach
            </div>

            <!-- Statistik -->
            <dl class="mt-8 grid grid-cols-3 gap-4 max-w-2xl pt-6 border-t border-line">
                <div>
                    <dt class="text-[10px] uppercase tracking-wider text-muted font-medium">Unit Siap Kirim</dt>
                    <dd class="mt-1 text-2xl font-extrabold text-ink tabular-nums">{{ number_format($totalUnit, 0, ',', '.') }}</dd>
                </div>
                <div>
                    <dt class="text-[10px] uppercase tracking-wider text-muted font-medium">Merek Resmi</dt>
                    <dd class="mt-1 text-2xl font-extrabold text-ink tabular-nums">{{ $brands->count() }}</dd>
                </div>
                <div>
                    <dt class="text-[10px] uppercase tracking-wider text-muted font-medium">Cabang Aktif</dt>
                    <dd class="mt-1 text-2xl font-extrabold text-ink tabular-nums">{{ $branches->count() }}</dd>
                </div>
            </dl>
        </div>

        <!-- Foto -->
        <div class="relative order-1 lg:order-2 w-full lg:w-[46%] xl:w-[48%] h-[42svh] min-h-[280px] max-h-[420px] sm:h-[50svh] lg:h-auto lg:max-h-none bg-[#0B0C0E] overflow-hidden rounded-b-3xl lg:rounded-none lg:[clip-path:polygon(10%_0,100%_0,100%_100%,0_100%)]">
            @foreach ($slides as $i => $slide)
                <img src="{{ asset($slide->foto) }}" alt=""
                    @if ($i === 0) fetchpriority="high" @endif
                    class="absolute inset-0 h-full w-full object-cover"
                    style="transition: opacity 1.6s cubic-bezier(0.4, 0, 0.2, 1), transform 8s ease-out;"
                    :class="active === {{ $i }} ? 'opacity-100 scale-105' : 'opacity-0 scale-100'">
            @endforeach
            <div class="absolute inset-0 bg-gradient-to-t from-[#0B0C0E]/55 via-transparent to-transparent pointer-events-none"></div>

            <!-- Kontrol Slider -->
            <div class="absolute bottom-4 right-4 sm:bottom-6 sm:right-6 flex items-center gap-1.5 bg-surface/95 backdrop-blur-md px-3 py-1.5 rounded-full border border-line shadow-lg" x-show="total > 1">
                @foreach ($slides as $i => $slide)
                    <button type="button" @click="active = {{ $i }}; mulaiUlang()"
                        class="min-h-[32px] min-w-[32px] inline-flex items-center justify-center group" aria-label="Slide {{ $i + 1 }}: {{ $slide->nama }}">
                        <span class="h-1.5 rounded-full transition-all duration-300" :class="active === {{ $i }} ? 'bg-accent-strong w-6' : 'bg-ink/25 group-hover:bg-ink/45 w-2'"></span>
                    </button>
                @endforeach
                <span class="w-px h-3 bg-line"></span>
                <button type="button" @click="jalan ? jeda() : putar()" :aria-pressed="jalan"
                    class="px-2 py-1 text-[11px] font-semibold text-muted hover:text-ink transition-colors" aria-label="Jeda atau putar slider">
                    <span x-text="jalan ? 'Jeda' : 'Putar'"></span>
                </button>
            </div>
        </div>
    </section>

    <!-- Main Content Container -->
    <div class="w-full px-4 sm:px-6 lg:px-8 py-12 space-y-20">

        <!-- Brands Section -->
        <section id="allbrands" class="reveal scroll-mt-24" x-data="{ showAll: window.location.hash === '#allbrands' }" x-init="window.addEventListener('hashchange', () => { if (window.location.hash === '#allbrands') showAll = true; })">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 pb-4 border-b border-line">
                <div>
                    <p class="text-xs font-semibold tracking-wider text-accent uppercase">Pilihan Manufaktur</p>
                    <h2 class="mt-1 text-2xl sm:text-3xl font-bold text-ink tracking-tight">Merek Mobil Resmi</h2>
                    <p class="mt-1 text-sm text-muted">Pilih merek untuk melihat model, spesifikasi teknis, dan alokasi unit cabang.</p>
                </div>
                <button type="button" @click="showAll = !showAll" class="text-xs sm:text-sm font-semibold text-accent hover:text-accent inline-flex items-center gap-1.5 flex-shrink-0 min-h-[44px] transition-colors">
                    <span x-text="showAll ? 'Tampilkan Lebih Sedikit' : 'Lihat Semua ({{ $brands->count() }})'"></span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': showAll }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
            </div>

            <div class="mt-6 grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-3 sm:gap-4" data-reveal-stagger>
                @foreach ($brands as $index => $brand)
                    @php
                        // Logo monokrom hitam: dibalik jadi putih di mode gelap, tanpa alas.
                        $logoGelap = in_array($brand->slug, ['aion', 'audi', 'dfsk', 'isuzu', 'jaecoo', 'jetour', 'kia', 'mitsubishi', 'neta', 'nissan', 'toyota', 'volkswagen'], true);
                    @endphp
                    <a href="{{ route('katalog.index', ['brand' => $brand->slug]) }}"
                        x-show="showAll || {{ $index }} < 16"
                        class="reveal bg-surface border border-line rounded-2xl p-4 flex flex-col justify-center items-center shadow-sm hover:border-accent/60 hover:shadow-lg hover:shadow-accent/10 hover:-translate-y-1 transition-all duration-200 group min-h-[110px]">
                        <span class="h-10 w-full flex items-center justify-center">
                            <img src="{{ $brand->logo_url }}" alt="" aria-hidden="true" class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-200 {{ $logoGelap ? 'dark:brightness-0 dark:invert' : '' }}" loading="lazy">
                        </span>
                        <span class="mt-2 w-full text-center text-xs font-semibold text-muted group-hover:text-ink transition-colors truncate">{{ $brand->nama }}</span>
                    </a>
                @endforeach
            </div>
        </section>

        <!-- Katalog Unit Siap Kirim -->
        @if ($unggulan->isNotEmpty())
            <section class="reveal">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 pb-4 border-b border-line">
                    <div>
                        <p class="text-xs font-semibold tracking-wider text-accent uppercase">Alokasi Dealer</p>
                        <h2 class="mt-1 text-2xl sm:text-3xl font-bold text-ink tracking-tight">Katalog Unit Siap Kirim</h2>
                        <p class="mt-1 text-sm text-muted">Harga OTR resmi dengan ketersediaan fisik nomor rangka (VIN) di cabang.</p>
                    </div>
                    <a href="{{ route('katalog.index') }}" class="text-xs sm:text-sm font-semibold text-accent hover:text-accent flex-shrink-0 min-h-[44px] inline-flex items-center gap-1 transition-colors">
                        <span>Lihat Semua Katalog</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5" data-reveal-stagger>
                    @foreach ($unggulan as $top)
                        @php
                            $fotoTop = $top->units->where('status', 'Tersedia')->first()?->foto_utama ?? $top->units->first()?->foto_utama;
                            $mulaiTop = $top->priceLists->min('otr');
                            $stokTop = $top->units->where('status', 'Tersedia')->count();
                        @endphp
                        <a href="{{ route('katalog.show', $top->slug) }}" class="reveal bg-surface border border-line rounded-2xl overflow-hidden flex flex-col transition-all duration-300 hover:border-accent hover:shadow-xl hover:shadow-black/5 hover:-translate-y-1 focus-visible:-translate-y-1 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-accent group">
                            <div class="relative overflow-hidden bg-surface">
                                @if ($fotoTop)
                                    <img src="{{ asset($fotoTop) }}" alt="{{ $top->carModel->brand->nama }} {{ $top->carModel->nama }} {{ $top->nama }}" class="h-48 w-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                                @else
                                    <div class="h-48 w-full bg-surface flex items-center justify-center text-sm text-muted">Foto menyusul</div>
                                @endif
                                <div class="absolute top-3 left-3">
                                    <x-status-badge status="{{ $stokTop > 0 ? 'Tersedia' : 'Dipesan' }}" />
                                </div>
                            </div>

                            <div class="p-5 flex flex-col flex-1">
                                <p class="text-xs font-semibold text-muted uppercase tracking-wider">{{ $top->carModel->brand->nama }} {{ $top->carModel->nama }}</p>
                                <h3 class="mt-1 font-bold text-lg text-ink group-hover:text-accent transition-colors line-clamp-1">{{ $top->nama }}</h3>
                                
                                <div class="mt-4 pt-3 border-t border-line">
                                    <p class="text-[11px] text-muted font-medium">Harga OTR Mulai</p>
                                    <p class="mt-0.5 text-lg font-extrabold text-ink tabular-nums tracking-tight">{{ $mulaiTop ? 'Rp '.number_format($mulaiTop, 0, ',', '.') : 'Hubungi Cabang' }}</p>
                                    <p class="mt-1 text-xs text-emerald-700 dark:text-emerald-300 font-medium tabular-nums">{{ $stokTop }} unit ready stock</p>
                                </div>

                                <div class="mt-5">
                                    <span class="w-full py-2.5 inline-flex items-center justify-center text-sm font-semibold text-ink bg-surface border border-line group-hover:text-white group-hover:bg-accent-strong group-hover:border-accent rounded-xl transition-all duration-200 min-h-[44px]">
                                        Rincian Unit
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Promos Section -->
        @if ($promos->isNotEmpty())
            <section class="reveal scroll-mt-24" aria-labelledby="promo-judul">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 pb-4 border-b border-line">
                    <div>
                        <p class="text-xs font-semibold tracking-wider text-accent uppercase">Program Resmi</p>
                        <h2 id="promo-judul" class="mt-1 text-2xl sm:text-3xl font-bold text-ink tracking-tight">Promo Berjalan</h2>
                        <p class="mt-1 text-sm text-muted">Penawaran resmi dan paket pembiayaan terbatas untuk cabang tertentu.</p>
                    </div>
                    <a href="{{ route('promo.index') }}" class="text-xs sm:text-sm font-semibold text-accent hover:text-accent flex-shrink-0 min-h-[44px] inline-flex items-center gap-1 transition-colors">
                        <span>Semua Promo</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-5" data-reveal-stagger>
                    @foreach ($promos as $promo)
                        <a href="{{ route('promo.index') }}#promo-{{ $promo->id }}" class="reveal relative block rounded-2xl overflow-hidden min-h-[200px] flex items-end border border-line hover:border-accent/60 transition-all duration-300 group shadow-lg">
                            @if ($promo->banner)
                                <img src="{{ asset($promo->banner) }}" alt="{{ $promo->judul }}" loading="lazy" class="absolute inset-0 h-full w-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @endif
                            <span class="absolute inset-0 bg-gradient-to-t from-black via-black/70 to-black/30"></span>
                            <span class="relative p-6 w-full">
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-accent-strong text-white mb-2">Penawaran Spesial</span>
                                <span class="block font-bold text-white text-lg group-hover:text-rose-200 transition-colors">{{ $promo->judul }}</span>
                                <span class="block text-xs text-white/80 mt-1">{{ $promo->branch->nama ?? 'Semua Cabang' }}, berlaku s/d {{ $promo->selesai->format('d M Y') }}</span>
                            </span>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Standard Operational Procedure (4 Steps) -->
        <section class="reveal">
            <div class="pb-4 border-b border-line">
                <p class="text-xs font-semibold tracking-wider text-accent uppercase">Standar Transaksi</p>
                <h2 class="mt-1 text-2xl sm:text-3xl font-bold text-ink tracking-tight">4 Langkah Transparan Pemesanan Mobil</h2>
                <p class="mt-1 text-sm text-muted">Alur terverifikasi langsung dari dealer resmi hingga serah terima kendaraan.</p>
            </div>

            <ol class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6" data-reveal-stagger>
                @foreach ([
                    ['01', 'Pilih Unit & Cek Ketersediaan', 'Tentukan varian, warna, dan cabang dari stok fisik dengan nomor rangka.', 'Stok per VIN fisik', 'katalog.index'],
                    ['02', 'Transfer Booking Fee Resmi', 'Bayar tanda jadi ke rekening resmi cabang sebelum batas waktu kedaluwarsa.', 'Batas bayar 24 jam', 'lacak.form'],
                    ['03', 'Verifikasi Staf & SPK Terbit', 'Admin memvalidasi transaksi dan menerbitkan dokumen SPK serta invoice.', 'Invoice otomatis', 'lacak.form'],
                    ['04', 'Pelunasan & Serah Terima', 'Selesaikan pembayaran di cabang dan unit diserahkan bersama berita acara (BAST).', 'Serah terima BAST', 'cabang.index']
                ] as [$no, $judul, $desc, $catatan, $route])
                    <li class="reveal relative bg-surface border border-line rounded-2xl p-6 flex flex-col justify-between hover:border-accent transition-colors" data-reveal="left">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-accent-strong to-[#9E0E19] text-white text-sm font-bold tabular-nums shadow-md shadow-accent/20">{{ $no }}</span>
                                <span class="text-[10px] uppercase tracking-wider text-muted font-bold">Langkah {{ $no }}</span>
                            </div>
                            <a href="{{ route($route) }}" class="block font-bold text-base text-ink hover:text-accent transition-colors">{{ $judul }}</a>
                            <p class="mt-2 text-xs sm:text-sm text-muted leading-relaxed">{{ $desc }}</p>
                        </div>
                        <div class="mt-6 pt-3 border-t border-line flex items-center gap-1.5 text-xs text-muted font-medium">
                            <span class="w-1.5 h-1.5 rounded-full bg-accent-strong"></span>
                            <span>{{ $catatan }}</span>
                        </div>
                    </li>
                @endforeach
            </ol>
        </section>

        <!-- Official Services Grid -->
        <section class="reveal">
            <div class="pb-4 border-b border-line">
                <p class="text-xs font-semibold tracking-wider text-accent uppercase">Layanan Terpadu</p>
                <h2 class="mt-1 text-2xl sm:text-3xl font-bold text-ink tracking-tight">Fasilitas Dealer & Purnajual</h2>
                <p class="mt-1 text-sm text-muted">Pusat servis resmi bersertifikat, uji coba kendaraan, tukar tambah, dan jaminan suku cadang asli.</p>
            </div>

            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5" data-reveal-stagger>
                @foreach ([
                    ['servis.create', 'Booking Servis Berkala', 'Perawatan rutin mesin dan kelistrikan di bengkel resmi terakreditasi.', 'wrench'],
                    ['test-drive.create', 'Uji Coba Test Drive', 'Rasakan performa dan kenyamanan berkendara unit pilihan sebelum membeli.', 'car'],
                    ['trade-in.create', 'Tukar Tambah (Trade-In)', 'Inspeksi objektif mobil lama Anda sebagai uang muka unit baru.', 'swap'],
                    ['sparepart.index', 'Suku Cadang Asli', 'Ketersediaan suku cadang asli dengan nomor part terverifikasi.', 'box']
                ] as [$route, $label, $desc, $ikon])
                    <a href="{{ route($route) }}" class="reveal bg-surface border border-line rounded-2xl p-6 flex flex-col justify-between hover:border-accent/50 hover:shadow-xl hover:shadow-accent/5 hover:-translate-y-1 transition-all duration-300 group">
                        <div>
                            <span class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-accent-strong/10 text-accent group-hover:bg-accent-strong group-hover:text-white transition-colors duration-200" aria-hidden="true">
                                <x-nav-icon name="{{ $ikon }}" class="w-6 h-6" />
                            </span>
                            <h3 class="mt-4 font-bold text-lg text-ink group-hover:text-accent transition-colors">{{ $label }}</h3>
                            <p class="mt-2 text-xs sm:text-sm text-muted leading-relaxed">{{ $desc }}</p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-line flex items-center justify-between text-xs font-semibold text-accent group-hover:text-accent">
                            <span>Akses Layanan</span>
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

    </div>

    <x-site-footer />
</x-site-layout>
