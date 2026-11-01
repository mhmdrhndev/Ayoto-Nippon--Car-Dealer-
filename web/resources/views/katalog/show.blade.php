<x-site-layout judul="{{ $variant->carModel->brand->nama }} {{ $variant->carModel->nama }} {{ $variant->nama }}" deskripsi="Spesifikasi, harga OTR, stok cabang, dan simulasi kredit {{ $variant->nama }} di Ayoto Nippon.">
    <x-site-header />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <a href="{{ route('katalog.index') }}" class="text-sm font-medium text-[#4B5563] hover:underline min-h-[44px] inline-flex items-center">Kembali ke katalog</a>
        @php $unitSpk = $variant->units->where('status', 'Tersedia')->first(); @endphp
        <div class="mt-2 grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div>
                @php
                    $galeri = $variant->units->filter(fn ($u) => $u->foto_utama)->unique('foto_utama')->map(fn ($u) => ['foto' => $u->foto_utama, 'warna' => $u->color_id])->values();
                    $warnaTersedia = $variant->units->where('status', 'Tersedia')->map(fn ($u) => $u->color)->filter()->unique('id')->values();
                @endphp
                @if ($galeri->isNotEmpty())
                    <img id="galeri-utama" src="{{ asset($galeri[0]['foto']) }}" alt="{{ $variant->carModel->brand->nama }} {{ $variant->carModel->nama }} {{ $variant->nama }}" fetchpriority="high" class="w-full aspect-video object-cover rounded-2xl">
                    @if ($galeri->count() > 1)
                        <div class="mt-2 grid grid-cols-4 gap-2">
                            @foreach ($galeri->take(8) as $i => $item)
                                <button type="button" data-galeri="{{ asset($item['foto']) }}" data-foto-warna="{{ $item['warna'] }}" aria-label="Lihat foto {{ $i + 1 }}" class="rounded-xl overflow-hidden border-2 border-transparent focus:border-[#C1121F] min-h-[44px] min-w-[44px]">
                                    <img src="{{ asset($item['foto']) }}" alt="" loading="lazy" class="w-full aspect-video object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="w-full aspect-video bg-gray-100 rounded-2xl flex items-center justify-center text-sm text-[#4B5563]">Foto menyusul</div>
                @endif
                @if ($warnaTersedia->isNotEmpty())
                    <h2 class="mt-4 text-sm font-bold text-[#16181D]">Pilihan warna tersedia</h2>
                    <div class="mt-2 flex flex-wrap gap-2">
                        @foreach ($warnaTersedia as $warna)
                            <button type="button" data-warna="{{ $warna->id }}" data-nama="{{ $warna->nama }}" aria-pressed="false" title="Pilih warna {{ $warna->nama }}" class="flex flex-col items-center gap-1 min-w-[56px] p-1 rounded-xl min-h-[44px]">
                                <span class="swatch block w-10 h-10 rounded-2xl border border-gray-300" style="background-color: {{ $warna->kode_hex }}"></span>
                                <span class="text-[11px] text-[#4B5563]">{{ $warna->nama }}</span>
                            </button>
                        @endforeach
                    </div>
                    <p id="warna-pilihan" class="hidden mt-1 text-xs text-[#4B5563]"></p>
                @endif
                <p class="mt-2 text-xs text-[#4B5563]">Warna dan detail mengikuti unit sebenarnya di cabang.</p>
            </div>
            <div>
                @php
                    $spek = $variant->spekLengkap();
                    $mulaiOtr = $variant->priceLists->min('otr');
                    $mulaiBooking = $variant->priceLists->map(fn ($p) => $p->branch->booking_fee)->filter()->min();
                    $kursi = $variant->spesifikasi['kursi'] ?? null;
                @endphp
                <p class="text-sm font-medium text-[#4B5563]">{{ $variant->carModel->brand->nama }} {{ $variant->carModel->nama }}</p>
                <h1 class="mt-1 text-2xl sm:text-3xl font-bold text-[#16181D]">{{ $variant->nama }}</h1>
                <p class="mt-2 flex flex-wrap gap-2 text-xs">
                    <span class="px-2 py-1 bg-gray-100 rounded-md text-[#16181D]">{{ $variant->transmisi }}</span>
                    <span class="px-2 py-1 bg-gray-100 rounded-md text-[#16181D]">{{ $variant->bbm }}</span>
                    @if ($kursi)
                        <span class="px-2 py-1 bg-gray-100 rounded-md text-[#16181D]">{{ $kursi }} kursi</span>
                    @endif
                </p>
                <div class="mt-4 p-5 bg-gray-50 border border-gray-200 rounded-2xl">
                    <p class="text-sm text-[#4B5563]">Harga OTR mulai</p>
                    <p class="mt-1 text-2xl font-bold text-[#16181D] tabular-nums">{{ $mulaiOtr ? 'Rp '.number_format($mulaiOtr, 0, ',', '.') : 'Mengikuti cabang' }}</p>
                    @if ($mulaiBooking)
                        <p class="mt-1 text-xs text-[#4B5563]">Booking fee mulai Rp {{ number_format($mulaiBooking, 0, ',', '.') }}</p>
                    @endif
                </div>
                <div class="mt-4 hidden lg:flex gap-3">
                    @auth
                        <a data-cta-spk href="{{ $unitSpk ? route('spk.create', ['unit_id' => $unitSpk->id]) : route('spk.create') }}" class="flex-1 px-6 py-3 text-center font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Ajukan SPK</a>
                    @else
                        <a href="{{ route('register') }}" class="flex-1 px-6 py-3 text-center font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Daftar untuk Ajukan SPK</a>
                    @endauth
                    <button type="button" data-simulasi-toggle aria-expanded="false" aria-controls="simulasi" class="px-6 py-3 text-center font-semibold text-[#16181D] border border-gray-300 rounded-lg min-h-[44px]">Simulasi Kredit</button>
                    <a data-cta-testdrive href="{{ route('test-drive.create', ['variant_id' => $variant->id]) }}" class="px-6 py-3 text-center font-semibold text-[#16181D] border border-gray-300 rounded-lg min-h-[44px]">Test Drive</a>
                </div>
                <div class="mt-4 p-5 bg-white border border-gray-200 rounded-2xl">
                    <h2 class="text-sm font-bold text-[#16181D]">Performa utama sekilas</h2>
                    <div class="mt-2 grid grid-cols-3 gap-2 text-center">
                        @foreach ([['Tenaga', $spek['Mesin dan performa']['Tenaga maksimum'] ?? '-'], ['Torsi', $spek['Mesin dan performa']['Torsi maksimum'] ?? '-'], ['Ground clearance', $spek['Dimensi dan kapasitas']['Ground clearance'] ?? '-']] as [$label, $nilai])
                            <div class="bg-gray-50 rounded-xl p-3">
                                <p class="text-[11px] text-[#4B5563]">{{ $label }}</p>
                                <p class="mt-1 text-sm font-bold text-[#16181D]">{{ $nilai }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <section id="simulasi" aria-labelledby="simulasi-judul" class="mt-8 border border-gray-200 rounded-2xl p-5" hidden>
            <p class="text-xs font-semibold tracking-widest text-[#C1121F]">FASILITAS FINANSIAL</p>
            <h2 id="simulasi-judul" tabindex="-1" class="mt-1 text-xl sm:text-2xl font-bold text-[#16181D]">Kalkulator Simulasi Kredit</h2>
            <p class="mt-1 text-sm text-[#4B5563]">{{ $variant->carModel->brand->nama }} {{ $variant->carModel->nama }} {{ $variant->nama }}</p>
            @php $bungaAcuan = $leasings->min('bunga_dasar'); @endphp
            @if ($variant->priceLists->isNotEmpty() && $leasings->isNotEmpty())
                <div class="mt-2 flex justify-end">
                    <span class="text-[11px] font-semibold text-[#4B5563] bg-gray-100 rounded-md px-2 py-1">Bunga flat mulai {{ $bungaAcuan }}% p.a.</span>
                </div>
                <div class="mt-4 grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <form id="simulasi-form" action="{{ route('simulasi.hitung') }}" method="POST" class="space-y-5">
                        @csrf
                        <input type="hidden" name="variant_id" value="{{ $variant->id }}">
                        <div>
                            <label for="sim-branch" class="block text-sm font-medium text-[#16181D]">Pilih Cabang OTR Pengiriman</label>
                            <select id="sim-branch" name="branch_id" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                                @foreach ($variant->priceLists as $price)
                                    <option value="{{ $price->branch_id }}" data-otr="{{ $price->otr }}">{{ $price->branch->nama }} (OTR Rp {{ number_format($price->otr, 0, ',', '.') }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-[#16181D]">Uang Muka (DP Minimum 20%)</span>
                                <span id="sim-dp-persen-label" class="text-xs font-semibold text-[#16181D] tabular-nums">20% OTR</span>
                            </div>
                            <div class="mt-2 grid grid-cols-2 sm:grid-cols-4 gap-2" role="group" aria-label="Persen DP">
                                @foreach ([20, 25, 30, 40] as $p)
                                    <button type="button" data-dp-persen="{{ $p }}" class="p-3 text-left border border-gray-300 rounded-xl min-h-[44px]">
                                        <span class="block text-sm font-bold text-[#16181D] tabular-nums">{{ $p }}%</span>
                                        <span data-dp-rp="{{ $p }}" class="block text-xs text-[#4B5563] tabular-nums">-</span>
                                    </button>
                                @endforeach
                            </div>
                            <div class="mt-2 flex items-center gap-3">
                                <span class="text-sm text-[#4B5563]">Rp</span>
                                <input id="sim-dp" type="number" name="dp" min="0" required class="flex-1 rounded-lg border-gray-300 min-h-[44px] tabular-nums">
                            </div>
                            <style>
                                #sim-dp-range { -webkit-appearance: none; appearance: none; height: 4px; border-radius: 9999px; background: #E5E7EB; outline-offset: 4px; }
                                #sim-dp-range::-webkit-slider-thumb { -webkit-appearance: none; appearance: none; width: 20px; height: 20px; border-radius: 9999px; background: #16181D; border: none; cursor: pointer; }
                                #sim-dp-range::-moz-range-track { height: 4px; border-radius: 9999px; background: #E5E7EB; }
                                #sim-dp-range::-moz-range-progress { height: 4px; border-radius: 9999px; background: #16181D; }
                                #sim-dp-range::-moz-range-thumb { width: 20px; height: 20px; border-radius: 9999px; background: #16181D; border: none; cursor: pointer; }
                            </style>
                            <div class="min-h-[44px] flex items-center">
                                <input id="sim-dp-range" type="range" min="0" max="100" value="20" aria-label="Geser persen DP" class="w-full">
                            </div>
                            <p id="sim-dp-hint" class="mt-1 text-sm text-[#4B5563]"></p>
                        </div>
                        <div>
                            <span class="block text-sm font-medium text-[#16181D]">Jangka Waktu Pembiayaan (Tenor)</span>
                            <div class="mt-2 grid grid-cols-2 sm:grid-cols-4 gap-2" role="group" aria-label="Tenor">
                                @foreach ([12, 24, 36, 48] as $t)
                                    <button type="button" data-tenor="{{ $t }}" class="p-3 text-left border border-gray-300 rounded-xl min-h-[44px]">
                                        <span class="block text-sm font-bold text-[#16181D] tabular-nums">{{ $t }} Bulan</span>
                                        <span class="block text-xs text-[#4B5563]">{{ $t / 12 }} Tahun</span>
                                    </button>
                                @endforeach
                            </div>
                            <input type="hidden" id="sim-tenor" name="tenor" value="12">
                        </div>
                        <div>
                            <span class="block text-sm font-medium text-[#16181D]">Pilihan Lembaga Pembiayaan</span>
                            <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-2" role="group" aria-label="Leasing">
                                <input type="hidden" id="sim-leasing" name="leasing_id" value="{{ $leasings->first()->id }}">
                                @foreach ($leasings as $leasing)
                                    <button type="button" data-leasing="{{ $leasing->id }}" data-dp-min="{{ $leasing->dp_min_persen }}" data-bunga="{{ $leasing->bunga_dasar }}" aria-pressed="{{ $loop->first ? 'true' : 'false' }}" class="text-left border rounded-xl p-3 min-h-[44px] {{ $loop->first ? 'border-[#16181D] bg-gray-50' : 'border-gray-300' }}">
                                        <span class="block text-xs font-semibold text-[#16181D]">{{ $leasing->nama }}</span>
                                        <span class="block text-xs text-[#4B5563]">Bunga {{ $leasing->bunga_dasar }}% p.a., DP min {{ $leasing->dp_min_persen }}%
                                            @if ($leasing->bunga_dasar == $bungaAcuan)
                                                <span class="ml-1 px-1.5 py-0.5 text-[10px] font-bold text-white bg-[#C1121F] rounded">Rekomendasi</span>
                                            @endif
                                        </span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                        <p id="simulasi-error" class="hidden text-sm font-medium text-[#C1121F]" role="alert"></p>
                    </form>
                    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5 h-fit">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-bold text-[#16181D]">Ringkasan Pembiayaan</h3>
                            <span id="ring-tenor" class="text-xs text-[#4B5563] tabular-nums"></span>
                        </div>
                        <div id="simulasi-hasil" class="mt-2" aria-live="polite">
                            <p class="text-sm text-[#4B5563]">Isi formulir lalu kirim pengajuan.</p>
                        </div>
                        <dl class="mt-3 text-sm border-t border-gray-200 pt-3 hidden" id="ring-rincian">
                            <div class="flex justify-between py-1">
                                <dt class="text-[#4B5563]">Harga Kendaraan OTR</dt>
                                <dd id="ring-otr" class="font-semibold tabular-nums text-[#16181D]">-</dd>
                            </div>
                            <div class="flex justify-between py-1">
                                <dt class="text-[#4B5563]">Uang Muka (DP)</dt>
                                <dd id="ring-dp" class="font-semibold tabular-nums text-[#16181D]">-</dd>
                            </div>
                            <div class="flex justify-between py-1">
                                <dt class="text-[#4B5563]">Pokok Hutang</dt>
                                <dd id="ring-pokok" class="font-semibold tabular-nums text-[#16181D]">-</dd>
                            </div>
                            <div class="flex justify-between py-1">
                                <dt class="text-[#4B5563]">Bunga flat</dt>
                                <dd id="ring-bunga" class="font-semibold tabular-nums text-[#16181D]">-</dd>
                            </div>
                        </dl>
                        <p id="ring-angsuran-wrap" class="hidden mt-3 text-2xl font-bold text-[#C1121F] tabular-nums"><span id="ring-angsuran">Rp 0</span><span class="text-sm font-medium text-[#4B5563]">/bulan</span></p>
                        <button type="submit" form="simulasi-form" id="sim-submit" class="mt-4 w-full px-6 py-3 font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Hitung Simulasi</button>
                        <a id="sim-lanjut" href="#" class="hidden mt-4 w-full px-6 py-3 font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px] flex items-center justify-center">Lanjut ke Pengajuan SPK</a>
                        <p class="mt-2 text-xs text-[#4B5563]">Hasil perhitungan adalah estimasi kasar. Pengajuan tersimpan dan sales kami akan menghubungi Anda.</p>
                    </div>
                </div>
            @else
                <p class="mt-2 text-sm text-[#4B5563]">Simulasi belum tersedia untuk varian ini.</p>
            @endif
        </section>

        <p class="mt-8 text-xs font-semibold tracking-widest text-[#C1121F]">SPESIFIKASI LENGKAP</p>
        <h2 class="mt-1 text-xl sm:text-2xl font-bold text-[#16181D]">Data teknis {{ $variant->carModel->nama }} {{ $variant->nama }}</h2>
        <div class="reveal mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach ($variant->spekLengkap() as $grup => $baris)
                <div class="border border-gray-200 rounded-2xl p-5">
                    <h3 class="text-sm font-bold text-[#C1121F]">{{ $grup }}</h3>
                    <dl class="mt-2">
                        @foreach ($baris as $label => $nilai)
                            <div class="flex justify-between gap-4 border-b border-gray-100 py-2 last:border-0">
                                <dt class="text-sm text-[#4B5563]">{{ $label }}</dt>
                                <dd class="text-sm font-semibold text-right text-[#16181D]">{{ $nilai }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </div>
            @endforeach
        </div>
        <p class="mt-3 text-xs text-[#4B5563]">Angka di atas acuan katalog. Minta brosur resmi ke sales untuk angka pasti sebelum SPK.</p>

        <p class="mt-8 text-xs font-semibold tracking-widest text-[#C1121F]">STOK PER CABANG</p>
        <h2 class="mt-1 text-xl sm:text-2xl font-bold text-[#16181D]">OTR dan Alokasi Stok Cabang</h2>
        <div class="reveal mt-4 overflow-x-auto border border-gray-200 rounded-xl">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left font-semibold text-[#16181D] px-4 py-3">Cabang</th>
                        <th class="text-left font-semibold text-[#16181D] px-4 py-3">Warna tersedia</th>
                        <th class="text-right font-semibold text-[#16181D] px-4 py-3">Harga OTR</th>
                        <th class="text-right font-semibold text-[#16181D] px-4 py-3">Stok</th>
                        <th class="text-right font-semibold text-[#16181D] px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($variant->priceLists as $price)
                        <tr class="border-b border-gray-100 last:border-0">
                            <td class="px-4 py-3 text-[#16181D]">{{ $price->branch->nama }}</td>
                            <td class="px-4 py-3 text-[#16181D]">{{ ($warnaPerCabang[$price->branch_id] ?? collect())->join(', ') ?: 'Stok kosong' }}</td>
                            <td class="px-4 py-3 text-right font-semibold text-[#16181D] tabular-nums">Rp {{ number_format($price->otr, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right"><x-status-badge status="{{ ($stok[$price->branch_id] ?? 0) > 0 ? 'Tersedia' : 'Dipesan' }}" /></td>
                            <td class="px-4 py-3 text-right">
                                @if (($stok[$price->branch_id] ?? 0) > 0)
                                    <a href="{{ route('spk.create') }}" class="underline font-medium text-[#16181D] min-h-[44px] inline-flex items-center">Ajukan SPK</a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="lg:hidden sticky bottom-0 bg-white border-t border-gray-200 p-3 flex gap-2">
        @auth
            <a data-cta-spk href="{{ $unitSpk ? route('spk.create', ['unit_id' => $unitSpk->id]) : route('spk.create') }}" class="flex-1 px-4 py-3 text-center text-sm font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Ajukan SPK</a>
        @else
            <a href="{{ route('register') }}" class="flex-1 px-4 py-3 text-center text-sm font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Daftar untuk Ajukan SPK</a>
        @endauth
        <button type="button" data-simulasi-toggle aria-expanded="false" aria-controls="simulasi" class="px-4 py-3 text-center text-sm font-semibold text-[#16181D] border border-gray-300 rounded-lg min-h-[44px]">Simulasi</button>
        <a data-cta-testdrive href="{{ route('test-drive.create', ['variant_id' => $variant->id]) }}" class="px-4 py-3 text-center text-sm font-semibold text-[#16181D] border border-gray-300 rounded-lg min-h-[44px]">Test Drive</a>
    </div>

    <x-site-footer />
    <script>
        (function () {
            const panel = document.getElementById('simulasi');
            if (!panel) return;
            const toggles = document.querySelectorAll('[data-simulasi-toggle]');
            const judul = document.getElementById('simulasi-judul');
            function buka(tampilkan) {
                panel.hidden = !tampilkan;
                toggles.forEach((t) => t.setAttribute('aria-expanded', tampil ? 'true' : 'false'));
                if (tampilkan) {
                    panel.scrollIntoView();
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
                        infoWarna.textContent = 'Warna dipilih: ' + (btn ? btn.dataset.nama : '') + '. Ajukan SPK dan Test Drive mengikuti warna ini.';
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
                dpRange.style.background = 'linear-gradient(to right, #16181D ' + p + '%, #E5E7EB ' + p + '%)';
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
                    b.classList.toggle('border-[#16181D]', nyala);
                    b.classList.toggle('bg-gray-50', nyala);
                    b.classList.toggle('border-gray-300', !nyala);
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
                    b.classList.toggle('border-[#16181D]', nyala);
                    b.classList.toggle('bg-gray-50', nyala);
                    b.classList.toggle('border-gray-300', !nyala);
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
                hasil.innerHTML = '<p class="text-sm text-[#4B5563]">Isi formulir lalu kirim pengajuan.</p>';
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
                hasil.innerHTML = '<p class="text-sm text-[#4B5563]">Menghitung...</p>';
                fetch(form.action, {
                    method: 'POST',
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                    body: new FormData(form),
                }).then(async (res) => {
                    const data = await res.json().catch(() => ({}));
                    if (!res.ok || !data.angsuran) {
                        const pesan = data.errors ? Object.values(data.errors).flat().join(' ') : (data.message || 'Gagal menghitung. Coba lagi.');
                        galat.textContent = pesan;
                        galat.classList.remove('hidden');
                        hasil.innerHTML = '';
                        keTahapHitung();
                        return;
                    }
                    isiRingkasan(data);
                    hasil.innerHTML = '<p class="text-sm text-[#16181D]">Hasil dihitung. Lanjut ke SPK untuk mengajukan, data tersimpan saat SPK dibuat.</p>';
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
                    galat.textContent = 'Jaringan bermasalah. Coba lagi.';
                    galat.classList.remove('hidden');
                    hasil.innerHTML = '';
                });
            });
        })();
    </script>
</x-site-layout>
