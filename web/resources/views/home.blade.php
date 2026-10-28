<x-site-layout judul="Mobil Baru Harga OTR Jelas" deskripsi="Ayoto Nippon: katalog mobil baru dengan harga OTR jelas per cabang, simulasi kredit, test drive, servis, dan trade-in di Jakarta dan Bandung.">
    <x-site-header />

    <section class="relative bg-[#16181D] overflow-hidden" aria-label="Sorotan"
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
        <div class="absolute inset-0 pointer-events-none">
            @foreach ($slides as $i => $slide)
                <img src="{{ asset($slide->foto) }}" alt=""
                    @if ($i === 0) fetchpriority="high" @endif
                    class="absolute inset-0 h-full w-full object-cover"
                    style="transition: opacity 1.6s cubic-bezier(0.4, 0, 0.2, 1), transform 8s ease-out;"
                    :class="active === {{ $i }} ? 'opacity-40 scale-105' : 'opacity-0 scale-100'">
            @endforeach
            <div class="absolute inset-0 bg-[#16181D]/60"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-24">
            <p class="inline-flex items-center text-xs sm:text-sm font-semibold text-white border border-white/60 rounded-full px-4 py-1.5">Dealer Jakarta dan Bandung</p>
            <h1 class="mt-3 text-3xl sm:text-5xl font-bold text-white max-w-2xl">Mobil baru dengan harga OTR jelas per cabang</h1>
            <form action="{{ route('katalog.index') }}" method="GET" class="mt-6 max-w-2xl flex flex-col sm:flex-row gap-3">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari model atau varian, contoh: Avanza"
                    aria-label="Cari model atau varian" class="flex-1 rounded-xl border-gray-300 min-h-[44px]">
                <select name="cabang" aria-label="Pilih cabang" class="rounded-xl border-gray-300 min-h-[44px]">
                    <option value="">Semua cabang</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->kode }}">{{ $branch->nama }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-6 py-2 font-semibold text-white bg-[#C1121F] rounded-xl min-h-[44px]">Cari Mobil</button>
            </form>
            <div class="mt-4 flex flex-wrap gap-2">
                <a href="{{ route('test-drive.create') }}" class="px-3 py-1.5 text-xs font-medium text-gray-200 border border-white/40 rounded-lg min-h-[44px] inline-flex items-center hover:text-white hover:border-white/70">Booking Test Drive</a>
                <a href="{{ route('simulasi.form') }}" class="px-3 py-1.5 text-xs font-medium text-gray-200 border border-white/40 rounded-lg min-h-[44px] inline-flex items-center hover:text-white hover:border-white/70">Simulasi Kredit</a>
                <a href="{{ route('lacak.form') }}" class="px-3 py-1.5 text-xs font-medium text-gray-200 border border-white/40 rounded-lg min-h-[44px] inline-flex items-center hover:text-white hover:border-white/70">Lacak SPK</a>
            </div>
            <p class="mt-4 text-sm sm:text-base font-medium text-gray-200 max-w-xl tabular-nums">{{ number_format($totalUnit, 0, ',', '.') }} unit tersedia, {{ $brands->count() }} merek, {{ $branches->count() }} cabang.</p>
        </div>

        <div class="absolute bottom-4 right-4 sm:right-8 flex items-center gap-1 z-10" x-show="total > 1">
            @foreach ($slides as $i => $slide)
                <button type="button" @click="active = {{ $i }}; mulaiUlang()"
                    class="min-h-[44px] min-w-[44px] inline-flex items-center justify-center" aria-label="Slide {{ $i + 1 }}: {{ $slide->nama }}">
                    <span class="h-2.5 rounded-full transition-all duration-300" :class="active === {{ $i }} ? 'bg-white w-7' : 'bg-white/40 w-2.5'"></span>
                </button>
            @endforeach
            <button type="button" @click="jalan ? jeda() : putar()" :aria-pressed="jalan"
                class="min-h-[44px] min-w-[44px] inline-flex items-center justify-center text-xs font-semibold text-white" aria-label="Jeda atau putar slider">
                <span x-text="jalan ? 'Jeda' : 'Putar'"></span>
            </button>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <section id="allbrands" class="reveal mt-12 scroll-mt-20" x-data="{ showAll: window.location.hash === '#allbrands' }" x-init="window.addEventListener('hashchange', () => { if (window.location.hash === '#allbrands') showAll = true; })">
            <div class="flex items-end justify-between gap-4">
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold text-[#16181D]">Merek Mobil Populer</h2>
                    <p class="mt-1 text-xs sm:text-sm text-[#4B5563]">Pilih merek favorit untuk melihat model, spesifikasi, dan harga terbaru</p>
                </div>
                <button type="button" @click="showAll = !showAll" class="text-xs sm:text-sm font-semibold text-[#C1121F] hover:underline inline-flex items-center gap-1.5 flex-shrink-0 min-h-[44px]">
                    <span x-text="showAll ? 'Tampilkan Lebih Sedikit' : 'Lihat Semua Merek ({{ $brands->count() }})'"></span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': showAll }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
            </div>
            <div class="mt-5 grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-3 sm:gap-4">
                @foreach ($brands as $index => $brand)
                    <a href="{{ route('katalog.index', ['brand' => $brand->slug]) }}"
                        x-show="showAll || {{ $index }} < 16"
                        class="bg-white border border-gray-200 rounded-xl sm:rounded-2xl p-3 sm:p-4 flex flex-col justify-center shadow-xs hover:border-[#C1121F] hover:shadow-md hover:-translate-y-1 transition-all group min-h-[105px]">
                        <span class="h-10 w-full flex items-center justify-center">
                            <img src="{{ $brand->logo_url }}" alt="" aria-hidden="true" class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-200" loading="lazy">
                        </span>
                        <span class="mt-1.5 w-full text-center text-xs sm:text-sm font-semibold text-[#16181D] group-hover:text-[#C1121F] transition-colors truncate">{{ $brand->nama }}</span>

                    </a>
                @endforeach
            </div>
        </section>

        @if ($unggulan->isNotEmpty())
            <section class="reveal mt-12">
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold text-[#16181D]">Katalog Unit Siap Kirim</h2>
                        <p class="mt-1 text-xs sm:text-sm text-[#4B5563]">Harga OTR mulai dan stok nyata per varian</p>
                    </div>
                    <a href="{{ route('katalog.index') }}" class="text-xs sm:text-sm font-semibold text-[#C1121F] hover:underline flex-shrink-0 min-h-[44px] inline-flex items-center">Semua Unit</a>
                </div>
                <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach ($unggulan as $top)
                        @php
                            $fotoTop = $top->units->where('status', 'Tersedia')->first()?->foto_utama ?? $top->units->first()?->foto_utama;
                            $mulaiTop = $top->priceLists->min('otr');
                            $stokTop = $top->units->where('status', 'Tersedia')->count();
                        @endphp
                        <a href="{{ route('katalog.show', $top->slug) }}" class="border border-gray-200 rounded-2xl overflow-hidden flex flex-col transition-all duration-300 hover:-translate-y-1 hover:shadow-lg focus-visible:-translate-y-1 focus-visible:shadow-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#16181D]">
                            @if ($fotoTop)
                                <img src="{{ asset($fotoTop) }}" alt="{{ $top->carModel->brand->nama }} {{ $top->carModel->nama }} {{ $top->nama }}" class="h-44 w-full object-cover" loading="lazy">
                            @else
                                <div class="h-44 w-full bg-gray-100 flex items-center justify-center text-sm text-[#4B5563]">Foto menyusul</div>
                            @endif
                            <div class="p-5 flex flex-col flex-1">
                                <p class="text-xs font-medium text-[#4B5563]">{{ $top->carModel->brand->nama }} {{ $top->carModel->nama }}</p>
                                <h3 class="font-bold text-[#16181D]">{{ $top->nama }}</h3>
                                <p class="mt-2 text-lg font-bold text-[#16181D] tabular-nums">{{ $mulaiTop ? 'Mulai Rp '.number_format($mulaiTop, 0, ',', '.') : 'Harga belum tersedia' }}</p>
                                <p class="mt-1 text-xs text-[#4B5563] tabular-nums">{{ $stokTop }} unit tersedia</p>
                                <span class="mt-4 px-4 py-2 inline-flex items-center justify-center text-sm font-semibold text-white bg-[#16181D] rounded-lg min-h-[44px]">Lihat Detail</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        @if ($promos->isNotEmpty())
            <section class="reveal mt-10 scroll-mt-20" aria-labelledby="promo-judul">
            <div class="flex items-end justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold tracking-widest text-[#C1121F]">PENAWARAN TERBATAS</p>
                    <h2 id="promo-judul" class="mt-1 text-xl sm:text-2xl font-bold text-[#16181D]">Promo berjalan</h2>
                    <p class="mt-1 text-xs sm:text-sm text-[#4B5563]">Penawaran resmi per cabang dan periode.</p>
                </div>
                <a href="{{ route('promo.index') }}" class="text-xs sm:text-sm font-semibold text-[#C1121F] hover:underline flex-shrink-0 min-h-[44px] inline-flex items-center">Semua promo</a>
            </div>
            <div class="mt-5 grid grid-cols-1 sm:grid-cols-3 gap-4">
                @foreach ($promos as $promo)
                    <a href="{{ route('promo.index') }}#promo-{{ $promo->id }}" class="relative block rounded-2xl overflow-hidden min-h-[180px] flex items-end">
                        @if ($promo->banner)
                            <img src="{{ asset($promo->banner) }}" alt="{{ $promo->judul }}" loading="lazy" class="absolute inset-0 h-full w-full object-cover">
                        @endif
                        <span class="absolute inset-0 bg-black/55"></span>
                        <span class="relative p-5">
                            <span class="block font-bold text-white text-lg">{{ $promo->judul }}</span>
                            <span class="block text-xs text-gray-200">{{ $promo->branch->nama ?? 'Semua cabang' }}, sampai {{ $promo->selesai->format('d M Y') }}</span>
                        </span>
                    </a>
                @endforeach
            </div>
            </section>
        @endif

        <p class="mt-10 text-xs font-semibold tracking-widest text-[#C1121F]">STANDAR OPERASIONAL PEMBELIAN</p>
        <h2 class="mt-1 text-xl sm:text-2xl font-bold text-[#16181D]">4 Langkah Transparan Kepemilikan Unit</h2>
        <ol class="reveal mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-0">
            @foreach ([['01', 'Pilih Unit dan Cek Ketersediaan', 'Tentukan varian, warna, dan cabang dari stok nyata per VIN.', 'Stok per VIN', 'katalog.index'], ['02', 'Transfer Booking Fee Resmi', 'Bayar tanda jadi ke rekening cabang sebelum batas bayar.', 'Batas bayar 24 jam', 'lacak.form'], ['03', 'Verifikasi Admin dan SPK', 'Upload bukti, admin memverifikasi dan menerbitkan invoice.', 'Invoice otomatis', 'lacak.form'], ['04', 'Pelunasan dan Serah Terima', 'Selesaikan pembayaran di dealer, unit diserahkan dengan BAST.', 'Serah terima BAST', 'cabang.index']] as [$no, $judul, $desc, $catatan, $route])
                <li class="relative bg-gray-50 rounded-xl p-5 flex flex-col lg:bg-transparent lg:rounded-none lg:py-0 lg:px-6 {{ $loop->first ? 'lg:pl-0' : '' }} {{ $loop->last ? 'lg:pr-0' : '' }}">
                    <span class="flex items-center gap-3" aria-hidden="true">
                        <span class="relative z-10 inline-flex items-center justify-center w-9 h-9 rounded-full bg-[#16181D] text-white text-sm font-bold tabular-nums shrink-0">{{ $no }}</span>
                        @if (!$loop->last)
                            <span class="hidden lg:block h-0.5 flex-1 -mr-6 bg-gray-200"></span>
                        @endif
                    </span>
                    <a href="{{ route($route) }}" class="mt-3 block font-bold text-[#16181D] hover:underline">{{ $judul }}</a>
                    <span class="mt-1 block text-sm text-[#4B5563] flex-1">{{ $desc }}</span>
                    <span class="mt-3 inline-flex items-center gap-1.5 text-xs font-medium text-[#16181D]"><span class="w-1.5 h-1.5 rounded-full bg-[#C1121F]"></span>{{ $catatan }}</span>
                </li>
            @endforeach
        </ol>

        <div class="mt-10 flex items-end justify-between gap-4">
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-[#16181D]">Layanan Resmi Terakreditasi</h2>
                <p class="mt-1 text-xs sm:text-sm text-[#4B5563]">Servis, test drive, trade-in, dan sparepart resmi.</p>
            </div>
        </div>
        <div class="reveal mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            @foreach ([['servis.create', 'Booking Servis', 'Jadwal servis terjadwal per cabang', 'wrench'], ['test-drive.create', 'Test Drive', 'Coba unit sebelum membeli', 'car'], ['trade-in.create', 'Trade-In', 'Tukar tambah mobil lama', 'swap'], ['sparepart.index', 'Sparepart', 'Suku cadang per cabang', 'box']] as [$route, $label, $desc, $ikon])
                <a href="{{ route($route) }}" class="block p-5 bg-gray-50 rounded-xl border border-transparent transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:border-[#16181D] focus-visible:-translate-y-1 focus-visible:shadow-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#16181D]">
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-[#C1121F]/10 text-[#C1121F]" aria-hidden="true"><x-nav-icon name="{{ $ikon }}" /></span>
                    <span class="mt-3 block font-bold text-[#16181D]">{{ $label }}</span>
                    <span class="mt-1 block text-sm text-[#4B5563]">{{ $desc }}</span>
                    <span class="mt-3 block text-sm font-semibold text-[#C1121F]">Buka layanan</span>
                </a>
            @endforeach
        </div>
    </div>

    <x-site-footer />
</x-site-layout>
