<x-site-layout judul="Mobil Baru Harga OTR Jelas" deskripsi="Ayoto Nippon: katalog mobil baru dengan harga OTR jelas per cabang, simulasi kredit, test drive, servis, dan trade-in di Jakarta dan Bandung.">
    <x-site-header />

    <!-- Hero Section -->
    <section class="relative bg-[#0B0C0E] overflow-hidden border-b border-[#E5E7EB]" aria-label="Sorotan Utama"
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

        <!-- Background Slides with Overlay -->
        <div class="absolute inset-0 pointer-events-none">
            @foreach ($slides as $i => $slide)
                <img src="{{ asset($slide->foto) }}" alt=""
                    @if ($i === 0) fetchpriority="high" @endif
                    class="absolute inset-0 h-full w-full object-cover"
                    style="transition: opacity 1.6s cubic-bezier(0.4, 0, 0.2, 1), transform 8s ease-out;"
                    :class="active === {{ $i }} ? 'opacity-100 scale-105' : 'opacity-0 scale-100'">
            @endforeach
            <div class="absolute inset-0 sm:hidden bg-gradient-to-b from-[#0B0C0E]/90 via-[#0B0C0E]/75 to-[#0B0C0E]/50"></div>
            <div class="absolute inset-0 hidden sm:block bg-gradient-to-r from-[#0B0C0E]/92 via-[#0B0C0E]/70 to-[#0B0C0E]/20"></div>
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-[#C1121F]/15 rounded-full blur-3xl pointer-events-none"></div>
        </div>

        <div class="relative w-full px-4 sm:px-6 lg:px-8 py-16 sm:py-28">
            <div class="inline-flex items-center gap-2 text-xs font-semibold text-white bg-white/10 border border-white/25 rounded-full px-4 py-1.5 backdrop-blur">
                <span class="w-1.5 h-1.5 rounded-full bg-[#FF6B6B] animate-pulse"></span>
                Dealer Resmi Jakarta & Bandung
            </div>

            <h1 class="mt-4 text-3xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight max-w-4xl leading-[1.12]">
                Mobil Baru dengan <span class="text-[#FF6B6B]">Harga OTR Transparan</span>
            </h1>
            <p class="mt-4 text-base sm:text-lg text-gray-200 max-w-3xl leading-relaxed">
                Pilih unit siap kirim per cabang, hitung simulasi pembiayaan secara mandiri, dan pantau proses penerbitan SPK secara real-time.
            </p>

            <!-- Search Form Card (Liquid Glass) -->
            <div class="mt-8 w-full max-w-4xl bg-white/10 backdrop-blur-2xl border border-white/25 rounded-2xl p-3 sm:p-4 shadow-2xl shadow-black/50 ring-1 ring-white/20">
                <form action="{{ route('katalog.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2.5">
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-white/70">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </span>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari model atau varian, misal: Avanza, CR-V"
                            aria-label="Cari model atau varian" 
                            style="outline: none !important; box-shadow: none !important;"
                            class="w-full pl-10 pr-4 py-3 bg-white/10 hover:bg-white/15 focus:bg-white/20 border border-white/25 rounded-xl text-white placeholder-white/70 text-sm focus:outline-none focus:ring-0 focus:border-white/60 min-h-[48px] backdrop-blur-md transition-all">
                    </div>

                    <select name="cabang" aria-label="Pilih cabang" 
                        style="outline: none !important; box-shadow: none !important;"
                        class="bg-white/10 hover:bg-white/15 focus:bg-white/20 border border-white/25 rounded-xl text-white text-sm focus:outline-none focus:ring-0 focus:border-white/60 min-h-[48px] px-3.5 sm:w-64 backdrop-blur-md transition-all">
                        <option value="" class="bg-[#16181D] text-white">Semua Cabang</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->kode }}" class="bg-[#16181D] text-white">{{ $branch->nama }}</option>
                        @endforeach
                    </select>

                    <button type="submit" 
                        class="px-8 py-3 font-semibold text-sm text-white bg-[#C1121F] hover:bg-[#9E0E19] rounded-xl min-h-[48px] shadow-lg shadow-[#C1121F]/30 border border-white/20 transition-all flex items-center justify-center gap-2 active:scale-[0.98]">
                        <span>Cari Unit</span>
                    </button>
                </form>
            </div>

            <!-- Quick Access Pills -->
            <div class="mt-5 flex flex-wrap items-center gap-2 sm:gap-2.5">
                <span class="text-xs text-gray-300 font-medium mr-1">Akses cepat:</span>
                <a href="{{ route('test-drive.create') }}" class="px-3.5 py-1.5 text-xs font-medium text-gray-100 bg-[#0B0C0E]/55 backdrop-blur border border-white/25 rounded-lg min-h-[38px] inline-flex items-center hover:text-white hover:border-[#FF6B6B] hover:bg-[#0B0C0E]/75 transition-all">Booking Test Drive</a>
                <a href="{{ route('simulasi.form') }}" class="px-3.5 py-1.5 text-xs font-medium text-gray-100 bg-[#0B0C0E]/55 backdrop-blur border border-white/25 rounded-lg min-h-[38px] inline-flex items-center hover:text-white hover:border-[#FF6B6B] hover:bg-[#0B0C0E]/75 transition-all">Simulasi Kredit</a>
                <a href="{{ route('lacak.form') }}" class="px-3.5 py-1.5 text-xs font-medium text-gray-100 bg-[#0B0C0E]/55 backdrop-blur border border-white/25 rounded-lg min-h-[38px] inline-flex items-center hover:text-white hover:border-[#FF6B6B] hover:bg-[#0B0C0E]/75 transition-all">Lacak Status SPK</a>
            </div>

            <div class="mt-8 flex flex-wrap items-center gap-6 pt-6 border-t border-white/20 text-xs sm:text-sm text-gray-300">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 shrink-0"></span>
                    <div class="flex items-center gap-2">
                        <strong class="text-white tabular-nums">{{ number_format($totalUnit, 0, ',', '.') }}</strong>
                        <span>Unit Siap Kirim</span>
                    </div>
                </div>
                <div class="text-white/30">•</div>
                <div class="flex items-center gap-2">
                    <strong class="text-white tabular-nums">{{ $brands->count() }}</strong>
                    <span>Merek Resmi</span>
                </div>
                <div class="text-white/30">•</div>
                <div class="flex items-center gap-2">
                    <strong class="text-white tabular-nums">{{ $branches->count() }}</strong>
                    <span>Cabang Aktif</span>
                </div>
            </div>
        </div>

        <!-- Slider Controls -->
        <div class="absolute bottom-5 right-4 sm:right-8 flex items-center gap-2 z-10 bg-[#0B0C0E]/60 backdrop-blur-md px-3 py-1.5 rounded-full border border-white/20" x-show="total > 1">
            @foreach ($slides as $i => $slide)
                <button type="button" @click="active = {{ $i }}; mulaiUlang()"
                    class="min-h-[32px] min-w-[32px] inline-flex items-center justify-center group" aria-label="Slide {{ $i + 1 }}: {{ $slide->nama }}">
                    <span class="h-1.5 rounded-full transition-all duration-300" :class="active === {{ $i }} ? 'bg-[#FF6B6B] w-6' : 'bg-white/30 group-hover:bg-white/50 w-2'"></span>
                </button>
            @endforeach
            <span class="w-px h-3 bg-white/25"></span>
            <button type="button" @click="jalan ? jeda() : putar()" :aria-pressed="jalan"
                class="px-2 py-1 text-[11px] font-semibold text-white/80 hover:text-white transition-colors" aria-label="Jeda atau putar slider">
                <span x-text="jalan ? 'Jeda' : 'Putar'"></span>
            </button>
        </div>
    </section>

    <!-- Main Content Container -->
    <div class="w-full px-4 sm:px-6 lg:px-8 py-12 space-y-20">

        <!-- Brands Section -->
        <section id="allbrands" class="reveal scroll-mt-24" x-data="{ showAll: window.location.hash === '#allbrands' }" x-init="window.addEventListener('hashchange', () => { if (window.location.hash === '#allbrands') showAll = true; })">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 pb-4 border-b border-[#E5E7EB]">
                <div>
                    <p class="text-xs font-semibold tracking-wider text-[#C1121F] uppercase">Pilihan Manufaktur</p>
                    <h2 class="mt-1 text-2xl sm:text-3xl font-bold text-[#16181D] tracking-tight">Merek Mobil Resmi</h2>
                    <p class="mt-1 text-sm text-[#4B5563]">Pilih merek untuk melihat model, spesifikasi teknis, dan alokasi unit cabang.</p>
                </div>
                <button type="button" @click="showAll = !showAll" class="text-xs sm:text-sm font-semibold text-[#C1121F] hover:text-[#C1121F] inline-flex items-center gap-1.5 flex-shrink-0 min-h-[44px] transition-colors">
                    <span x-text="showAll ? 'Tampilkan Lebih Sedikit' : 'Lihat Semua ({{ $brands->count() }})'"></span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': showAll }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
            </div>

            <div class="mt-6 grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-3 sm:gap-4" data-reveal-stagger>
                @foreach ($brands as $index => $brand)
                    <a href="{{ route('katalog.index', ['brand' => $brand->slug]) }}"
                        x-show="showAll || {{ $index }} < 16"
                        class="reveal bg-[#FFFFFF] border border-[#E5E7EB] rounded-2xl p-4 flex flex-col justify-center items-center shadow-sm hover:border-[#C1121F]/60 hover:shadow-lg hover:shadow-[#C1121F]/10 hover:-translate-y-1 transition-all duration-200 group min-h-[110px]">
                        <span class="h-10 w-full flex items-center justify-center">
                            <img src="{{ $brand->logo_url }}" alt="" aria-hidden="true" class="max-h-full max-w-full object-contain filter brightness-95 group-hover:brightness-110 group-hover:scale-105 transition-all duration-200" loading="lazy">
                        </span>
                        <span class="mt-2 w-full text-center text-xs font-semibold text-[#4B5563] group-hover:text-[#16181D] transition-colors truncate">{{ $brand->nama }}</span>
                    </a>
                @endforeach
            </div>
        </section>

        <!-- Katalog Unit Siap Kirim -->
        @if ($unggulan->isNotEmpty())
            <section class="reveal">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 pb-4 border-b border-[#E5E7EB]">
                    <div>
                        <p class="text-xs font-semibold tracking-wider text-[#C1121F] uppercase">Alokasi Dealer</p>
                        <h2 class="mt-1 text-2xl sm:text-3xl font-bold text-[#16181D] tracking-tight">Katalog Unit Siap Kirim</h2>
                        <p class="mt-1 text-sm text-[#4B5563]">Harga OTR resmi dengan ketersediaan fisik nomor rangka (VIN) di cabang.</p>
                    </div>
                    <a href="{{ route('katalog.index') }}" class="text-xs sm:text-sm font-semibold text-[#C1121F] hover:text-[#C1121F] flex-shrink-0 min-h-[44px] inline-flex items-center gap-1 transition-colors">
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
                        <a href="{{ route('katalog.show', $top->slug) }}" class="reveal bg-[#FFFFFF] border border-[#E5E7EB] rounded-2xl overflow-hidden flex flex-col transition-all duration-300 hover:border-[#C1121F] hover:shadow-xl hover:shadow-black/5 hover:-translate-y-1 focus-visible:-translate-y-1 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#C1121F] group">
                            <div class="relative overflow-hidden bg-[#FFFFFF]">
                                @if ($fotoTop)
                                    <img src="{{ asset($fotoTop) }}" alt="{{ $top->carModel->brand->nama }} {{ $top->carModel->nama }} {{ $top->nama }}" class="h-48 w-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                                @else
                                    <div class="h-48 w-full bg-[#FFFFFF] flex items-center justify-center text-sm text-gray-500">Foto menyusul</div>
                                @endif
                                <div class="absolute top-3 left-3">
                                    <x-status-badge status="{{ $stokTop > 0 ? 'Tersedia' : 'Dipesan' }}" />
                                </div>
                            </div>

                            <div class="p-5 flex flex-col flex-1">
                                <p class="text-xs font-semibold text-[#4B5563] uppercase tracking-wider">{{ $top->carModel->brand->nama }} {{ $top->carModel->nama }}</p>
                                <h3 class="mt-1 font-bold text-lg text-[#16181D] group-hover:text-[#C1121F] transition-colors line-clamp-1">{{ $top->nama }}</h3>
                                
                                <div class="mt-4 pt-3 border-t border-[#E5E7EB]">
                                    <p class="text-[11px] text-[#4B5563] font-medium">Harga OTR Mulai</p>
                                    <p class="mt-0.5 text-lg font-extrabold text-[#16181D] tabular-nums tracking-tight">{{ $mulaiTop ? 'Rp '.number_format($mulaiTop, 0, ',', '.') : 'Hubungi Cabang' }}</p>
                                    <p class="mt-1 text-xs text-emerald-700 font-medium tabular-nums">{{ $stokTop }} unit ready stock</p>
                                </div>

                                <div class="mt-5">
                                    <span class="w-full py-2.5 inline-flex items-center justify-center text-sm font-semibold text-[#16181D] bg-[#FFFFFF] border border-[#E5E7EB] group-hover:text-white group-hover:bg-[#C1121F] group-hover:border-[#C1121F] rounded-xl transition-all duration-200 min-h-[44px]">
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
                <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 pb-4 border-b border-[#E5E7EB]">
                    <div>
                        <p class="text-xs font-semibold tracking-wider text-[#C1121F] uppercase">Program Resmi</p>
                        <h2 id="promo-judul" class="mt-1 text-2xl sm:text-3xl font-bold text-[#16181D] tracking-tight">Promo Berjalan</h2>
                        <p class="mt-1 text-sm text-[#4B5563]">Penawaran resmi dan paket pembiayaan terbatas untuk cabang tertentu.</p>
                    </div>
                    <a href="{{ route('promo.index') }}" class="text-xs sm:text-sm font-semibold text-[#C1121F] hover:text-[#C1121F] flex-shrink-0 min-h-[44px] inline-flex items-center gap-1 transition-colors">
                        <span>Semua Promo</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-5" data-reveal-stagger>
                    @foreach ($promos as $promo)
                        <a href="{{ route('promo.index') }}#promo-{{ $promo->id }}" class="reveal relative block rounded-2xl overflow-hidden min-h-[200px] flex items-end border border-[#E5E7EB] hover:border-[#C1121F]/60 transition-all duration-300 group shadow-lg">
                            @if ($promo->banner)
                                <img src="{{ asset($promo->banner) }}" alt="{{ $promo->judul }}" loading="lazy" class="absolute inset-0 h-full w-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @endif
                            <span class="absolute inset-0 bg-gradient-to-t from-black via-black/70 to-black/30"></span>
                            <span class="relative p-6 w-full">
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-[#C1121F] text-white mb-2">Penawaran Spesial</span>
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
            <div class="pb-4 border-b border-[#E5E7EB]">
                <p class="text-xs font-semibold tracking-wider text-[#C1121F] uppercase">Standar Transaksi</p>
                <h2 class="mt-1 text-2xl sm:text-3xl font-bold text-[#16181D] tracking-tight">4 Langkah Transparan Pemesanan Mobil</h2>
                <p class="mt-1 text-sm text-[#4B5563]">Alur terverifikasi langsung dari dealer resmi hingga serah terima kendaraan.</p>
            </div>

            <ol class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6" data-reveal-stagger>
                @foreach ([
                    ['01', 'Pilih Unit & Cek Ketersediaan', 'Tentukan varian, warna, dan cabang dari stok fisik dengan nomor rangka.', 'Stok per VIN fisik', 'katalog.index'],
                    ['02', 'Transfer Booking Fee Resmi', 'Bayar tanda jadi ke rekening resmi cabang sebelum batas waktu kedaluwarsa.', 'Batas bayar 24 jam', 'lacak.form'],
                    ['03', 'Verifikasi Staf & SPK Terbit', 'Admin memvalidasi transaksi dan menerbitkan dokumen SPK serta invoice.', 'Invoice otomatis', 'lacak.form'],
                    ['04', 'Pelunasan & Serah Terima', 'Selesaikan pembayaran di cabang dan unit diserahkan bersama berita acara (BAST).', 'Serah terima BAST', 'cabang.index']
                ] as [$no, $judul, $desc, $catatan, $route])
                    <li class="reveal relative bg-[#FFFFFF] border border-[#E5E7EB] rounded-2xl p-6 flex flex-col justify-between hover:border-[#C1121F] transition-colors" data-reveal="left">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-[#C1121F] to-[#9E0E19] text-white text-sm font-bold tabular-nums shadow-md shadow-[#C1121F]/20">{{ $no }}</span>
                                <span class="text-[10px] uppercase tracking-wider text-gray-500 font-bold">Langkah {{ $no }}</span>
                            </div>
                            <a href="{{ route($route) }}" class="block font-bold text-base text-[#16181D] hover:text-[#C1121F] transition-colors">{{ $judul }}</a>
                            <p class="mt-2 text-xs sm:text-sm text-[#4B5563] leading-relaxed">{{ $desc }}</p>
                        </div>
                        <div class="mt-6 pt-3 border-t border-[#E5E7EB] flex items-center gap-1.5 text-xs text-[#4B5563] font-medium">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#C1121F]"></span>
                            <span>{{ $catatan }}</span>
                        </div>
                    </li>
                @endforeach
            </ol>
        </section>

        <!-- Official Services Grid -->
        <section class="reveal">
            <div class="pb-4 border-b border-[#E5E7EB]">
                <p class="text-xs font-semibold tracking-wider text-[#C1121F] uppercase">Layanan Terpadu</p>
                <h2 class="mt-1 text-2xl sm:text-3xl font-bold text-[#16181D] tracking-tight">Fasilitas Dealer & Purnajual</h2>
                <p class="mt-1 text-sm text-[#4B5563]">Pusat servis resmi bersertifikat, uji coba kendaraan, tukar tambah, dan jaminan suku cadang asli.</p>
            </div>

            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5" data-reveal-stagger>
                @foreach ([
                    ['servis.create', 'Booking Servis Berkala', 'Perawatan rutin mesin dan kelistrikan di bengkel resmi terakreditasi.', 'wrench'],
                    ['test-drive.create', 'Uji Coba Test Drive', 'Rasakan performa dan kenyamanan berkendara unit pilihan sebelum membeli.', 'car'],
                    ['trade-in.create', 'Tukar Tambah (Trade-In)', 'Inspeksi objektif mobil lama Anda sebagai uang muka unit baru.', 'swap'],
                    ['sparepart.index', 'Suku Cadang Asli', 'Ketersediaan suku cadang asli dengan nomor part terverifikasi.', 'box']
                ] as [$route, $label, $desc, $ikon])
                    <a href="{{ route($route) }}" class="reveal bg-[#FFFFFF] border border-[#E5E7EB] rounded-2xl p-6 flex flex-col justify-between hover:border-[#C1121F]/50 hover:shadow-xl hover:shadow-[#C1121F]/5 hover:-translate-y-1 transition-all duration-300 group">
                        <div>
                            <span class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-[#C1121F]/10 text-[#C1121F] group-hover:bg-[#C1121F] group-hover:text-white transition-colors duration-200" aria-hidden="true">
                                <x-nav-icon name="{{ $ikon }}" class="w-6 h-6" />
                            </span>
                            <h3 class="mt-4 font-bold text-lg text-[#16181D] group-hover:text-[#C1121F] transition-colors">{{ $label }}</h3>
                            <p class="mt-2 text-xs sm:text-sm text-[#4B5563] leading-relaxed">{{ $desc }}</p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-[#E5E7EB] flex items-center justify-between text-xs font-semibold text-[#C1121F] group-hover:text-[#C1121F]">
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
