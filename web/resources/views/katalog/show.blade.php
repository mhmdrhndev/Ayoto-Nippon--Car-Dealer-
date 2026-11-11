<x-site-layout judul="{{ $variant->carModel->brand->nama }} {{ $variant->carModel->nama }} {{ $variant->nama }}" deskripsi="Spesifikasi, harga OTR, stok cabang, dan simulasi kredit {{ $variant->nama }} di Ayoto Nippon.">
    <x-site-header />

    <div class="w-full px-4 sm:px-6 lg:px-8 py-10 space-y-12">
        <a href="{{ route('katalog.index') }}" class="text-sm font-medium text-muted hover:text-ink min-h-[44px] inline-flex items-center gap-2 transition-colors">
            <span>Kembali ke Katalog</span>
        </a>

        @php $unitSpk = $variant->units->where('status', 'Tersedia')->first(); @endphp

        <!-- Top Gallery & Core Info -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            <!-- Left: Gallery & Colors -->
            <div class="lg:col-span-6 space-y-4">
                @php
                    $galeri = $variant->units->filter(fn ($u) => $u->foto_utama)->unique('foto_utama')->map(fn ($u) => ['foto' => $u->foto_utama, 'warna' => $u->color_id])->values();
                    $warnaTersedia = $variant->units->where('status', 'Tersedia')->map(fn ($u) => $u->color)->filter()->unique('id')->values();
                @endphp

                <div class="bg-surface border border-line rounded-3xl overflow-hidden shadow-2xl shadow-black/5">
                    @if ($galeri->isNotEmpty())
                        <img id="galeri-utama" src="{{ asset($galeri[0]['foto']) }}" alt="{{ $variant->carModel->brand->nama }} {{ $variant->carModel->nama }} {{ $variant->nama }}" fetchpriority="high" class="w-full aspect-[16/10] lg:max-h-[460px] 2xl:max-h-[540px] object-cover transition-all duration-300">
                        @if ($galeri->count() > 1)
                            <div class="p-3 bg-surface border-t border-line grid grid-cols-4 sm:grid-cols-6 gap-2">
                                @foreach ($galeri->take(8) as $i => $item)
                                    <button type="button" data-galeri="{{ asset($item['foto']) }}" data-foto-warna="{{ $item['warna'] }}" aria-label="Lihat foto {{ $i + 1 }}" 
                                        class="rounded-xl overflow-hidden border-2 border-transparent hover:border-accent/50 focus:border-accent transition-all min-h-[44px] min-w-[44px] aspect-video bg-surface">
                                        <img src="{{ asset($item['foto']) }}" alt="" loading="lazy" class="w-full h-full object-cover">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="w-full aspect-[16/10] lg:max-h-[460px] 2xl:max-h-[540px] bg-surface flex items-center justify-center text-sm text-muted">Foto menyusul</div>
                    @endif
                </div>

                <!-- Color Selection Swatches -->
                @if ($warnaTersedia->isNotEmpty())
                    <div class="p-5 bg-surface border border-line rounded-2xl">
                        <div class="flex items-center justify-between mb-3">
                            <h2 class="text-xs font-semibold uppercase tracking-wider text-muted">Pilihan Warna Siap Kirim</h2>
                            <span class="text-xs text-muted">Klik untuk filter alokasi</span>
                        </div>
                        <div class="flex flex-wrap gap-2.5">
                            @foreach ($warnaTersedia as $warna)
                                <button type="button" data-warna="{{ $warna->id }}" data-nama="{{ $warna->nama }}" aria-pressed="false" title="Pilih warna {{ $warna->nama }}" 
                                    class="flex flex-col items-center gap-1.5 p-2 rounded-xl border border-line hover:border-accent bg-surface transition-all min-w-[64px] min-h-[44px]">
                                    <span class="swatch block w-8 h-8 rounded-full border border-line shadow-inner" style="background-color: {{ $warna->kode_hex }}"></span>
                                    <span class="text-[10px] text-muted font-medium truncate max-w-[64px]">{{ $warna->nama }}</span>
                                </button>
                            @endforeach
                        </div>
                        <p id="warna-pilihan" class="hidden mt-3 text-xs text-accent font-medium"></p>
                    </div>
                @endif
            </div>

            <!-- Right: Specs & Action Box -->
            <div class="lg:col-span-6 space-y-6">
                @php
                    $spek = $variant->spekLengkap();
                    $mulaiOtr = $variant->priceLists->min('otr');
                    $mulaiBooking = $variant->priceLists->map(fn ($p) => $p->branch->booking_fee)->filter()->min();
                    $kursi = $variant->spesifikasi['kursi'] ?? null;
                @endphp

                <div>
                    <p class="text-xs font-semibold tracking-wider text-accent uppercase">{{ $variant->carModel->brand->nama }} {{ $variant->carModel->nama }}</p>
                    <h1 class="mt-1 text-3xl sm:text-4xl font-extrabold text-ink tracking-tight">{{ $variant->nama }}</h1>

                    <div class="mt-3 flex flex-wrap gap-2 text-xs">
                        <span class="px-3 py-1 bg-surface border border-line rounded-lg text-ink font-medium">{{ $variant->transmisi }}</span>
                        <span class="px-3 py-1 bg-surface border border-line rounded-lg text-ink font-medium">{{ $variant->bbm }}</span>
                        @if ($kursi)
                            <span class="px-3 py-1 bg-surface border border-line rounded-lg text-ink font-medium">{{ $kursi }} Kursi</span>
                        @endif
                    </div>
                </div>

                <!-- Price Box -->
                <div class="p-6 bg-surface border border-line rounded-3xl shadow-xl">
                    <p class="text-xs text-muted font-medium uppercase tracking-wider">Harga OTR Mulai</p>
                    <p class="mt-1 text-3xl sm:text-4xl font-black text-ink tabular-nums tracking-tight">
                        {{ $mulaiOtr ? 'Rp '.number_format($mulaiOtr, 0, ',', '.') : 'Mengikuti Cabang' }}
                    </p>
                    @if ($mulaiBooking)
                        <div class="mt-3 pt-3 border-t border-line flex items-center justify-between text-xs text-muted">
                            <span>Tanda Jadi (Booking Fee):</span>
                            <strong class="text-accent font-bold tabular-nums">Rp {{ number_format($mulaiBooking, 0, ',', '.') }}</strong>
                        </div>
                    @endif
                </div>

                <!-- Main Desktop CTAs -->
                <div class="hidden lg:grid grid-cols-3 gap-2.5">
                    @auth
                        <a data-cta-spk href="{{ $unitSpk ? route('spk.create', ['unit_id' => $unitSpk->id]) : route('spk.create') }}" 
                           class="col-span-3 py-3.5 px-6 text-center font-bold text-sm text-white bg-accent-strong hover:bg-[#9E0E19] rounded-xl shadow-lg shadow-accent/25 transition-all min-h-[48px] flex items-center justify-center active:scale-[0.99]">
                            Ajukan Pemesanan SPK
                        </a>
                    @else
                        <a href="{{ route('register') }}" 
                           class="col-span-3 py-3.5 px-6 text-center font-bold text-sm text-white bg-accent-strong hover:bg-[#9E0E19] rounded-xl shadow-lg shadow-accent/25 transition-all min-h-[48px] flex items-center justify-center active:scale-[0.99]">
                            Daftar untuk Ajukan SPK
                        </a>
                    @endauth

                    <button type="button" data-simulasi-toggle aria-expanded="false" aria-controls="simulasi" 
                        class="col-span-2 py-3 px-4 text-center font-semibold text-xs sm:text-sm text-ink bg-surface border border-line hover:border-accent hover:text-ink rounded-xl transition-all min-h-[44px]">
                        Kalkulator Simulasi
                    </button>
                    <a data-cta-testdrive href="{{ route('test-drive.create', ['variant_id' => $variant->id]) }}" 
                        class="py-3 px-4 text-center font-semibold text-xs sm:text-sm text-ink bg-surface border border-line hover:border-accent hover:text-ink rounded-xl transition-all min-h-[44px] flex items-center justify-center">
                        Test Drive
                    </a>
                </div>

                <!-- Quick Technical Specs -->
                <div class="p-6 bg-surface border border-line rounded-3xl">
                    <h2 class="text-xs font-semibold uppercase tracking-wider text-muted">Ringkasan Performa</h2>
                    <div class="mt-4 grid grid-cols-3 gap-3 text-center">
                        @foreach ([
                            ['Tenaga', $spek['Mesin dan performa']['Tenaga maksimum'] ?? '-'],
                            ['Torsi', $spek['Mesin dan performa']['Torsi maksimum'] ?? '-'],
                            ['Ground Clearance', $spek['Dimensi dan kapasitas']['Ground clearance'] ?? '-']
                        ] as [$label, $nilai])
                            <div class="bg-surface border border-line rounded-2xl p-3">
                                <p class="text-[10px] uppercase tracking-wider text-muted">{{ $label }}</p>
                                <p class="mt-1 text-xs sm:text-sm font-bold text-ink">{{ $nilai }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Interactive Loan Calculator (Collapsible / Toggleable) -->
        <section id="simulasi" aria-labelledby="simulasi-judul" class="border border-line bg-surface rounded-3xl p-6 sm:p-8 shadow-2xl" hidden>
            <div class="pb-6 border-b border-line">
                <p class="text-xs font-semibold tracking-wider text-accent uppercase">Fasilitas Finansial</p>
                <h2 id="simulasi-judul" tabindex="-1" class="mt-1 text-2xl sm:text-3xl font-extrabold text-ink tracking-tight">Kalkulator Simulasi Kredit</h2>
                <p class="mt-1 text-sm text-muted">{{ $variant->carModel->brand->nama }} {{ $variant->carModel->nama }} {{ $variant->nama }}</p>
            </div>

            @php $bungaAcuan = $leasings->min('bunga_dasar'); @endphp
            @if ($variant->priceLists->isNotEmpty() && $leasings->isNotEmpty())
                <div class="mt-6 grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    <form id="simulasi-form" action="{{ route('simulasi.hitung') }}" method="POST" class="lg:col-span-7 space-y-6">
                        @csrf
                        <input type="hidden" name="variant_id" value="{{ $variant->id }}">

                        <div>
                            <label for="sim-branch" class="block text-xs font-semibold uppercase tracking-wider text-muted">Pilih Cabang OTR Pengiriman</label>
                            <select id="sim-branch" name="branch_id" required 
                                class="mt-2 w-full bg-surface border border-line rounded-xl text-ink text-sm focus:border-accent focus:ring-1 focus:ring-accent min-h-[48px] px-3.5">
                                @foreach ($variant->priceLists as $price)
                                    <option value="{{ $price->branch_id }}" data-otr="{{ $price->otr }}">{{ $price->branch->nama }} (OTR Rp {{ number_format($price->otr, 0, ',', '.') }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-semibold uppercase tracking-wider text-muted">Uang Muka (DP Minimum 20%)</span>
                                <span id="sim-dp-persen-label" class="text-xs font-bold text-accent tabular-nums">20% OTR</span>
                            </div>

                            <div class="mt-2.5 grid grid-cols-2 sm:grid-cols-4 gap-2" role="group" aria-label="Persen DP">
                                @foreach ([20, 25, 30, 40] as $p)
                                    <button type="button" data-dp-persen="{{ $p }}" 
                                        class="p-3 text-left bg-surface border border-line rounded-xl min-h-[44px] hover:border-accent transition-colors">
                                        <span class="block text-sm font-bold text-ink tabular-nums">{{ $p }}%</span>
                                        <span data-dp-rp="{{ $p }}" class="block text-xs text-muted tabular-nums mt-0.5">-</span>
                                    </button>
                                @endforeach
                            </div>

                            <div class="mt-3 flex items-center gap-3">
                                <span class="text-sm font-semibold text-muted">Rp</span>
                                <input id="sim-dp" type="number" name="dp" min="0" required 
                                    class="flex-1 bg-surface border border-line rounded-xl text-ink text-sm focus:border-accent focus:ring-1 focus:ring-accent min-h-[44px] px-3.5 tabular-nums">
                            </div>

                            <style>
                                #sim-dp-range { -webkit-appearance: none; appearance: none; height: 6px; border-radius: 9999px; background: rgb(var(--line)); outline-offset: 4px; }
                                #sim-dp-range::-webkit-slider-thumb { -webkit-appearance: none; appearance: none; width: 22px; height: 22px; border-radius: 9999px; background: rgb(var(--accent-strong)); border: 2px solid rgb(var(--surface)); cursor: pointer; box-shadow: 0 0 10px rgba(225,29,72,0.5); }
                                #sim-dp-range::-moz-range-track { height: 6px; border-radius: 9999px; background: rgb(var(--line)); }
                                #sim-dp-range::-moz-range-thumb { width: 22px; height: 22px; border-radius: 9999px; background: rgb(var(--accent-strong)); border: 2px solid rgb(var(--surface)); cursor: pointer; }
                            </style>
                            <div class="min-h-[44px] flex items-center mt-3">
                                <input id="sim-dp-range" type="range" min="0" max="100" value="20" aria-label="Geser persen DP" class="w-full">
                            </div>
                            <p id="sim-dp-hint" class="mt-1 text-xs text-muted"></p>
                        </div>

                        <div>
                            <span class="block text-xs font-semibold uppercase tracking-wider text-muted">Jangka Waktu Tenor</span>
                            <div class="mt-2.5 grid grid-cols-2 sm:grid-cols-4 gap-2" role="group" aria-label="Tenor">
                                @foreach ([12, 24, 36, 48] as $t)
                                    <button type="button" data-tenor="{{ $t }}" 
                                        class="p-3 text-left bg-surface border border-line rounded-xl min-h-[44px] hover:border-accent transition-colors">
                                        <span class="block text-sm font-bold text-ink tabular-nums">{{ $t }} Bulan</span>
                                        <span class="block text-xs text-muted mt-0.5">{{ $t / 12 }} Tahun</span>
                                    </button>
                                @endforeach
                            </div>
                            <input type="hidden" id="sim-tenor" name="tenor" value="12">
                        </div>

                        <div>
                            <span class="block text-xs font-semibold uppercase tracking-wider text-muted">Lembaga Pembiayaan Mitra Resmi</span>
                            <div class="mt-2.5 grid grid-cols-1 sm:grid-cols-2 gap-2" role="group" aria-label="Leasing">
                                <input type="hidden" id="sim-leasing" name="leasing_id" value="{{ $leasings->first()->id }}">
                                @foreach ($leasings as $leasing)
                                    <button type="button" data-leasing="{{ $leasing->id }}" data-dp-min="{{ $leasing->dp_min_persen }}" data-bunga="{{ $leasing->bunga_dasar }}" 
                                        aria-pressed="{{ $loop->first ? 'true' : 'false' }}" 
                                        class="text-left border rounded-xl p-3.5 min-h-[44px] transition-all {{ $loop->first ? 'border-accent bg-accent-strong/10' : 'border-line bg-surface hover:border-accent' }}">
                                        <span class="block text-xs font-bold text-ink">{{ $leasing->nama }}</span>
                                        <span class="block text-xs text-muted mt-0.5">Bunga {{ $leasing->bunga_dasar }}% p.a., DP min {{ $leasing->dp_min_persen }}%
                                            @if ($leasing->bunga_dasar == $bungaAcuan)
                                                <span class="ml-1 px-1.5 py-0.5 text-[9px] font-bold text-white bg-accent-strong rounded">Terbaik</span>
                                            @endif
                                        </span>
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <p id="simulasi-error" class="hidden text-sm font-medium text-accent bg-rose-500/10 border border-rose-500/20 p-3 rounded-xl" role="alert"></p>
                    </form>

                    <!-- Summary Panel -->
                    <div class="lg:col-span-5 bg-surface border border-line rounded-3xl p-6 shadow-xl">
                        <div class="flex items-center justify-between pb-4 border-b border-line">
                            <h3 class="text-sm font-bold text-ink uppercase tracking-wider">Ringkasan Pembiayaan</h3>
                            <span id="ring-tenor" class="text-xs font-semibold text-accent tabular-nums"></span>
                        </div>

                        <div id="simulasi-hasil" class="mt-4" aria-live="polite">
                            <p class="text-sm text-muted">Pilih parameter pembiayaan lalu klik hitung.</p>
                        </div>

                        <dl class="mt-4 text-xs sm:text-sm border-t border-line pt-4 hidden space-y-2.5" id="ring-rincian">
                            <div class="flex justify-between py-1 border-b border-line">
                                <dt class="text-muted">Harga OTR Kendaraan</dt>
                                <dd id="ring-otr" class="font-bold tabular-nums text-ink">-</dd>
                            </div>
                            <div class="flex justify-between py-1 border-b border-line">
                                <dt class="text-muted">Uang Muka (DP)</dt>
                                <dd id="ring-dp" class="font-bold tabular-nums text-ink">-</dd>
                            </div>
                            <div class="flex justify-between py-1 border-b border-line">
                                <dt class="text-muted">Pokok Hutang</dt>
                                <dd id="ring-pokok" class="font-bold tabular-nums text-ink">-</dd>
                            </div>
                            <div class="flex justify-between py-1">
                                <dt class="text-muted">Suku Bunga Flat</dt>
                                <dd id="ring-bunga" class="font-bold tabular-nums text-ink">-</dd>
                            </div>
                        </dl>

                        <div id="ring-angsuran-wrap" class="hidden mt-6 p-4 bg-surface border border-line rounded-2xl text-center">
                            <p class="text-[11px] text-muted font-medium uppercase tracking-wider">Estimasi Angsuran Bulanan</p>
                            <p class="mt-1 text-2xl sm:text-3xl font-black text-accent tabular-nums">
                                <span id="ring-angsuran">Rp 0</span>
                                <span class="text-xs font-medium text-muted">/bulan</span>
                            </p>
                        </div>

                        <button type="submit" form="simulasi-form" id="sim-submit" 
                            class="mt-6 w-full py-3.5 px-6 font-bold text-sm text-white bg-accent-strong hover:bg-[#9E0E19] rounded-xl shadow-lg shadow-accent/25 transition-all min-h-[48px] flex items-center justify-center">
                            Hitung Simulasi
                        </button>
                        <a id="sim-lanjut" href="#" 
                            class="hidden mt-6 w-full py-3.5 px-6 font-bold text-sm text-white bg-accent-strong hover:bg-[#9E0E19] rounded-xl shadow-lg shadow-accent/25 transition-all min-h-[48px] flex items-center justify-center">
                            Lanjut ke Pengajuan SPK
                        </a>
                        <p class="mt-4 text-[11px] text-muted leading-relaxed text-center">
                            Hasil kalkulasi adalah estimasi referensi. Sales consultant cabang kami akan mengonfirmasi rincian akhir saat penerbitan SPK.
                        </p>
                    </div>
                </div>
            @else
                <p class="mt-4 text-sm text-muted">Simulasi pembiayaan belum tersedia untuk varian ini.</p>
            @endif
        </section>

        <!-- Full Technical Specifications -->
        <section class="space-y-6">
            <div class="pb-4 border-b border-line">
                <p class="text-xs font-semibold tracking-wider text-accent uppercase">Spesifikasi Lengkap</p>
                <h2 class="mt-1 text-2xl sm:text-3xl font-extrabold text-ink tracking-tight">Data Teknis Resmi {{ $variant->carModel->nama }} {{ $variant->nama }}</h2>
            </div>

            <div class="reveal grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($variant->spekLengkap() as $grup => $baris)
                    <div class="bg-surface border border-line rounded-3xl p-6">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-accent pb-3 border-b border-line">{{ $grup }}</h3>
                        <dl class="mt-4 space-y-3">
                            @foreach ($baris as $label => $nilai)
                                <div class="flex justify-between items-start gap-4 text-xs sm:text-sm">
                                    <dt class="text-muted">{{ $label }}</dt>
                                    <dd class="font-semibold text-right text-ink">{{ $nilai }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>
                @endforeach
            </div>
            <p class="text-xs text-muted">Keterangan spesifikasi bersumber dari brosur pabrikan resmi. Konsultasikan dengan staf dealer kami untuk detail pembaruan teranyar.</p>
        </section>

        <!-- Branch Stock & Allocation Table -->
        <section class="space-y-6">
            <div class="pb-4 border-b border-line">
                <p class="text-xs font-semibold tracking-wider text-accent uppercase">Alokasi Dealer</p>
                <h2 class="mt-1 text-2xl sm:text-3xl font-extrabold text-ink tracking-tight">Harga OTR & Ketersediaan Stok Cabang</h2>
            </div>

            <div class="reveal overflow-x-auto bg-surface border border-line rounded-3xl shadow-xl">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-line bg-surface text-muted text-xs uppercase tracking-wider">
                            <th class="text-left font-bold px-6 py-4">Cabang Dealer</th>
                            <th class="text-left font-bold px-6 py-4">Pilihan Warna Fisik</th>
                            <th class="text-right font-bold px-6 py-4">Harga OTR Resmi</th>
                            <th class="text-center font-bold px-6 py-4">Ketersediaan</th>
                            <th class="text-right font-bold px-6 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line">
                        @foreach ($variant->priceLists as $price)
                            <tr class="hover:bg-surface-2 transition-colors">
                                <td class="px-6 py-4 font-semibold text-ink">{{ $price->branch->nama }}</td>
                                <td class="px-6 py-4 text-muted text-xs">{{ ($warnaPerCabang[$price->branch_id] ?? collect())->join(', ') ?: 'Stok belum tersedia' }}</td>
                                <td class="px-6 py-4 text-right font-extrabold text-ink tabular-nums">Rp {{ number_format($price->otr, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-center">
                                    <x-status-badge status="{{ ($stok[$price->branch_id] ?? 0) > 0 ? 'Tersedia' : 'Dipesan' }}" />
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if (($stok[$price->branch_id] ?? 0) > 0)
                                        <a href="{{ route('spk.create') }}" class="inline-flex items-center text-xs font-semibold text-accent hover:text-accent min-h-[44px]">
                                            Ajukan SPK &rarr;
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <!-- Mobile Bottom Fixed Bar -->
    <div class="lg:hidden sticky bottom-0 bg-surface/95 backdrop-blur-xl border-t border-line p-3 flex gap-2 z-30">
        @auth
            <a data-cta-spk href="{{ $unitSpk ? route('spk.create', ['unit_id' => $unitSpk->id]) : route('spk.create') }}" 
               class="flex-1 px-4 py-3 text-center text-sm font-bold text-white bg-accent-strong rounded-xl min-h-[44px] flex items-center justify-center shadow-lg shadow-accent/20">
                Ajukan SPK
            </a>
        @else
            <a href="{{ route('register') }}" 
               class="flex-1 px-4 py-3 text-center text-sm font-bold text-white bg-accent-strong rounded-xl min-h-[44px] flex items-center justify-center shadow-lg shadow-accent/20">
                Daftar SPK
            </a>
        @endauth
        <button type="button" data-simulasi-toggle aria-expanded="false" aria-controls="simulasi" 
            class="px-4 py-3 text-center text-xs font-semibold text-ink bg-surface border border-line rounded-xl min-h-[44px]">
            Simulasi
        </button>
        <a data-cta-testdrive href="{{ route('test-drive.create', ['variant_id' => $variant->id]) }}" 
            class="px-4 py-3 text-center text-xs font-semibold text-ink bg-surface border border-line rounded-xl min-h-[44px] flex items-center justify-center">
            Test Drive
        </a>
    </div>

    <x-site-footer />

    <!-- Interactive Script (preserves all calculations and state binding) -->
    <script>
        (function () {
            const panel = document.getElementById('simulasi');
            if (!panel) return;
            const toggles = document.querySelectorAll('[data-simulasi-toggle]');
            const judul = document.getElementById('simulasi-judul');
            function buka(tampilkan) {
                panel.hidden = !tampilkan;
                toggles.forEach((t) => t.setAttribute('aria-expanded', tampilkan ? 'true' : 'false'));
                if (tampilkan) {
                    panel.scrollIntoView({ behavior: 'smooth' });
                    judul.focus();
                }
            }
            toggles.forEach((t) => t.addEventListener('click', () => buka(panel.hidden)));
            const utama = document.getElementById('galeri-utama');
            const thumbBtns = Array.from(document.querySelectorAll('[data-galeri]'));
            function fotoWarna(idWarna) {
                const btn = thumbBtns.find((b) => String(b.dataset.fotoWarna) === String(idWarna));
                return btn ? btn.dataset.galeri : null;
            }
            document.querySelectorAll('[data-galeri]').forEach((btn) => {
                btn.addEventListener('click', () => {
                    if (utama) utama.src = btn.dataset.galeri;
                });
            });
            const spkBase = "{{ route('spk.create') }}";
            const tdBase = "{{ route('test-drive.create') }}";
            const varianId = "{{ $variant->id }}";
            const unitPerWarna = @json($variant->units->where('status', 'Tersedia')->groupBy('color_id')->map(fn ($g) => ['unit_id' => $g->first()->id, 'branch_id' => $g->first()->branch_id]));
            const warnaBtns = Array.from(document.querySelectorAll('[data-warna]'));
            const spkCtas = Array.from(document.querySelectorAll('[data-cta-spk]'));
            const tdCtas = Array.from(document.querySelectorAll('[data-cta-testdrive]'));
            const spkAwal = new Map(spkCtas.map((a) => [a, a.getAttribute('href')]));
            const infoWarna = document.getElementById('warna-pilihan');
            let warna = null;
            function unitWarna(idWarna) {
                return (typeof unitPerWarna !== 'undefined' && unitPerWarna[idWarna]) ? unitPerWarna[idWarna] : null;
            }
            function syncCta() {
                spkCtas.forEach((a) => {
                    if (!warna) {
                        a.setAttribute('href', spkAwal.get(a));
                        return;
                    }
                    let href = spkBase + '?variant_id=' + varianId + '&color_id=' + warna;
                    const u = unitWarna(warna);
                    if (u) {
                        href += '&unit_id=' + u.unit_id + '&branch_id=' + u.branch_id;
                    }
                    a.setAttribute('href', href);
                });
                tdCtas.forEach((a) => {
                    let href = tdBase + '?variant_id=' + varianId;
                    if (warna) {
                        const u = unitWarna(warna);
                        href += '&color_id=' + warna;
                        if (u) {
                            href += '&branch_id=' + u.branch_id;
                        }
                    }
                    a.setAttribute('href', href);
                });
                warnaBtns.forEach((b) => {
                    const aktif = b.dataset.warna === warna;
                    b.setAttribute('aria-pressed', aktif ? 'true' : 'false');
                    const swatch = b.querySelector('.swatch');
                    if (swatch) {
                        swatch.style.outline = aktif ? '2px solid #C1121F' : '';
                        swatch.style.outlineOffset = aktif ? '2px' : '';
                    }
                });
                if (utama && thumbBtns.length) {
                    if (warna) {
                        const cocok = fotoWarna(warna);
                        if (cocok) utama.src = cocok;
                    } else {
                        utama.src = thumbBtns[0].dataset.galeri;
                    }
                }
                thumbBtns.forEach((b) => {
                    b.classList.toggle('opacity-40', !!(warna && String(b.dataset.fotoWarna) !== String(warna)));
                });
                if (infoWarna) {
                    if (warna) {
                        const btn = warnaBtns.find((b) => b.dataset.warna === warna);
                        infoWarna.textContent = 'Warna dipilih: ' + (btn ? btn.dataset.nama : '') + '. Pengajuan SPK dan Test Drive akan dialokasikan untuk varian warna ini.';
                        infoWarna.classList.remove('hidden');
                    } else {
                        infoWarna.classList.add('hidden');
                    }
                }
            }
            warnaBtns.forEach((b) => b.addEventListener('click', () => {
                warna = (warna === b.dataset.warna) ? null : b.dataset.warna;
                syncCta();
            }));
            syncCta();
            const form = document.getElementById('simulasi-form');
            if (!form) return;
            const branch = document.getElementById('sim-branch');
            const dp = document.getElementById('sim-dp');
            const dpRange = document.getElementById('sim-dp-range');
            const dpLabel = document.getElementById('sim-dp-persen-label');
            const tenorInput = document.getElementById('sim-tenor');
            const hint = document.getElementById('sim-dp-hint');
            const galat = document.getElementById('simulasi-error');
            const hasil = document.getElementById('simulasi-hasil');
            const rupiah = (n) => 'Rp ' + Number(n).toLocaleString('id-ID');
            function paintRange() {
                if (!dpRange) return;
                const min = Number(dpRange.min || 0);
                const max = Number(dpRange.max || 100);
                const p = max > min ? Math.round((Number(dpRange.value) - min) / (max - min) * 100) : 0;
                dpRange.style.background = 'linear-gradient(to right, rgb(var(--accent-strong)) ' + p + '%, rgb(var(--line)) ' + p + '%)';
            }
            const leasingInput = document.getElementById('sim-leasing');
            const pilLeasing = Array.from(form.querySelectorAll('[data-leasing]'));
            const leasingAktif = () => pilLeasing.find((b) => b.dataset.leasing === leasingInput.value) || null;
            function otrAktif() {
                return Number(branch.selectedOptions[0].dataset.otr || 0);
            }
            function minPersen() {
                const l = leasingAktif();
                return l ? Number(l.dataset.dpMin || l.dataset.dpmin || 0) : 0;
            }
            function syncLeasing(aktif) {
                pilLeasing.forEach((b) => {
                    const nyala = b === aktif;
                    b.setAttribute('aria-pressed', nyala ? 'true' : 'false');
                    b.classList.toggle('border-accent', nyala);
                    b.classList.toggle('bg-accent-strong/10', nyala);
                    b.classList.toggle('border-line', !nyala);
                    b.classList.toggle('bg-surface', !nyala);
                });
                if (aktif) leasingInput.value = aktif.dataset.leasing;
            }
            const ringkasRp = (n) => n >= 1000000000
                ? 'Rp ' + (Math.round(n / 100000000) / 10).toLocaleString('id-ID') + ' M'
                : 'Rp ' + Math.round(n / 1000000) + ' jt';
            function tandaiPil(pil, aktif) {
                pil.forEach((b) => {
                    const nyala = b === aktif;
                    b.setAttribute('aria-pressed', nyala ? 'true' : 'false');
                    b.classList.toggle('border-accent', nyala);
                    b.classList.toggle('bg-accent-strong/10', nyala);
                    b.classList.toggle('border-line', !nyala);
                    b.classList.toggle('bg-surface', !nyala);
                });
            }
            const pilDp = Array.from(form.querySelectorAll('[data-dp-persen]'));
            const pilTenor = Array.from(form.querySelectorAll('[data-tenor]'));
            function syncDp(persen) {
                const otr = otrAktif();
                const min = Math.ceil(otr * minPersen() / 100);
                const nilai = Math.max(Math.ceil(otr * persen / 100), min);
                dp.min = min;
                dp.value = nilai;
                if (dpRange) {
                    dpRange.min = minPersen();
                    dpRange.max = 100;
                    dpRange.value = Math.round(nilai / otr * 100);
                    paintRange();
                }
                if (dpLabel) dpLabel.textContent = Math.round(nilai / otr * 100) + '% OTR';
                tandaiPil(pilDp, pilDp.find((b) => Number(b.dataset.dpPersen) === Math.round(nilai / otr * 100)) || null);
                pilDp.forEach((b) => {
                    const rp = b.querySelector('[data-dp-rp]');
                    if (rp) rp.textContent = ringkasRp(Math.max(Math.ceil(otr * Number(b.dataset.dpPersen) / 100), min));
                });
                hint.textContent = 'DP minimal ' + rupiah(min) + ' (' + minPersen() + '% dari OTR ' + rupiah(otr) + ').';
            }
            pilDp.forEach((b) => b.addEventListener('click', () => {
                syncDp(Number(b.dataset.dpPersen));
                keTahapHitung();
            }));
            if (dpRange) dpRange.addEventListener('input', () => {
                paintRange();
                const otr = otrAktif();
                const nilai = Math.max(Math.round(otr * Number(dpRange.value) / 100), Math.ceil(otr * minPersen() / 100));
                dp.value = nilai;
                if (dpLabel) dpLabel.textContent = Math.round(nilai / otr * 100) + '% OTR';
                tandaiPil(pilDp, pilDp.find((x) => Number(x.dataset.dpPersen) === Math.round(nilai / otr * 100)) || null);
                hint.textContent = 'DP ' + rupiah(nilai) + ' dari OTR ' + rupiah(otr) + '.';
            });
            dp.addEventListener('input', () => {
                const otr = otrAktif();
                const persen = otr ? Math.round(Number(dp.value || 0) / otr * 100) : 0;
                if (dpLabel && otr) dpLabel.textContent = persen + '% OTR';
                tandaiPil(pilDp, pilDp.find((x) => Number(x.dataset.dpPersen) === persen) || null);
            });
            function syncTenor(aktif) {
                tenorInput.value = aktif ? aktif.dataset.tenor : tenorInput.value;
                tandaiPil(pilTenor, aktif || pilTenor.find((x) => x.dataset.tenor === tenorInput.value) || null);
            }
            pilTenor.forEach((b) => b.addEventListener('click', () => {
                syncTenor(b);
                keTahapHitung();
            }));
            pilLeasing.forEach((b) => b.addEventListener('click', () => {
                syncLeasing(b);
                const otr = otrAktif();
                const persen = otr ? Math.max(Math.round(Number(dp.value || 0) / otr * 100), minPersen()) : minPersen();
                syncDp(persen);
                keTahapHitung();
            }));
            syncLeasing(pilLeasing[0]);
            branch.addEventListener('change', () => syncDp(20));
            syncDp(20);
            syncTenor(pilTenor[0]);
            const tombolKirim = document.getElementById('sim-submit');
            const linkLanjut = document.getElementById('sim-lanjut');
            let terkirim = false;
            function isiRingkasan(d) {
                document.getElementById('ring-tenor').textContent = d.tenor + ' Bulan (' + (d.tenor / 12) + ' Tahun)';
                document.getElementById('ring-otr').textContent = rupiah(d.otr);
                document.getElementById('ring-dp').textContent = rupiah(d.dp);
                document.getElementById('ring-pokok').textContent = rupiah(d.pokok);
                document.getElementById('ring-bunga').textContent = d.bunga + '% p.a.';
                document.getElementById('ring-rincian').classList.remove('hidden');
                document.getElementById('ring-angsuran-wrap').classList.remove('hidden');
                document.getElementById('ring-angsuran').textContent = rupiah(d.angsuran);
            }
            function keTahapHitung() {
                terkirim = false;
                document.getElementById('ring-rincian').classList.add('hidden');
                document.getElementById('ring-angsuran-wrap').classList.add('hidden');
                if (linkLanjut) linkLanjut.classList.add('hidden');
                if (tombolKirim) tombolKirim.classList.remove('hidden');
                galat.classList.add('hidden');
                hasil.innerHTML = '<p class="text-sm text-muted">Pilih parameter pembiayaan lalu klik hitung.</p>';
            }
            ['sim-branch', 'sim-dp', 'sim-tenor'].forEach((id) => {
                const el = document.getElementById(id);
                if (el) el.addEventListener(id === 'sim-dp' ? 'input' : 'change', keTahapHitung);
            });
            if (dpRange) dpRange.addEventListener('input', keTahapHitung);
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                if (terkirim) return;
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }
                galat.classList.add('hidden');
                hasil.innerHTML = '<p class="text-sm text-muted">Menghitung simulasi...</p>';
                fetch(form.action, {
                    method: 'POST',
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                    body: new FormData(form),
                }).then(async (res) => {
                    const data = await res.json().catch(() => ({}));
                    if (!res.ok || !data.angsuran) {
                        const pesan = data.errors ? Object.values(data.errors).flat().join(' ') : (data.message || 'Gagal menghitung simulasi. Silakan periksa kembali formulir.');
                        galat.textContent = pesan;
                        galat.classList.remove('hidden');
                        hasil.innerHTML = '';
                        keTahapHitung();
                        return;
                    }
                    isiRingkasan(data);
                    hasil.innerHTML = '<p class="text-xs text-emerald-700 dark:text-emerald-300 font-medium">Estimasi pembiayaan berhasil dihitung. Klik tombol di bawah untuk melanjutkan ke pengajuan SPK.</p>';
                    terkirim = true;
                    if (tombolKirim) tombolKirim.classList.add('hidden');
                    if (linkLanjut) {
                        const param = new URLSearchParams({
                            variant_id: varianId,
                            branch_id: branch.value,
                            dp_rencana: dp.value || 0,
                            tenor: tenorInput.value,
                            leasing_id: leasingInput.value,
                        });
                        if (warna) param.set('color_id', warna);
                        linkLanjut.setAttribute('href', spkBase + '?' + param.toString());
                        linkLanjut.classList.remove('hidden');
                    }
                }).catch(() => {
                    galat.textContent = 'Terjadi gangguan jaringan. Coba beberapa saat lagi.';
                    galat.classList.remove('hidden');
                    hasil.innerHTML = '';
                });
            });
        })();
    </script>
</x-site-layout>
