<x-site-layout>
    <x-site-header />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <a href="{{ route('katalog.index') }}" class="text-sm font-medium text-[#4B5563] hover:underline min-h-[44px] inline-flex items-center">Kembali ke katalog</a>
        @php $unitSpk = $variant->units->where('status', 'Tersedia')->first(); @endphp
        <div class="mt-2 grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div>
                @php $galeri = $variant->units->pluck('foto_utama')->filter()->unique()->values(); @endphp
                @if ($galeri->isNotEmpty())
                    <img src="{{ asset($galeri[0]) }}" alt="{{ $variant->carModel->brand->nama }} {{ $variant->carModel->nama }} {{ $variant->nama }}" class="w-full aspect-video object-cover rounded-2xl">
                    @if ($galeri->count() > 1)
                        <div class="mt-2 grid grid-cols-3 gap-2">
                            @foreach ($galeri->slice(1, 3) as $foto)
                                <img src="{{ asset($foto) }}" alt="" loading="lazy" class="w-full aspect-video object-cover rounded-xl">
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="w-full aspect-video bg-gray-100 rounded-2xl flex items-center justify-center text-sm text-[#4B5563]">Foto menyusul</div>
                @endif
                <p class="mt-2 text-xs text-[#4B5563]">Warna dan detail mengikuti unit sebenarnya di cabang.</p>
            </div>
            <div>
                <p class="text-sm font-medium text-[#4B5563]">{{ $variant->carModel->brand->nama }} {{ $variant->carModel->nama }}</p>
                <h1 class="mt-1 text-2xl sm:text-3xl font-bold text-[#16181D]">{{ $variant->nama }}</h1>
                <p class="mt-2 flex gap-2 text-xs">
                    <span class="px-2 py-1 bg-gray-100 rounded-md text-[#16181D]">{{ $variant->transmisi }}</span>
                    <span class="px-2 py-1 bg-gray-100 rounded-md text-[#16181D]">{{ $variant->bbm }}</span>
                </p>
                <h2 class="mt-6 text-lg font-bold text-[#16181D]">Spesifikasi</h2>
                @foreach ($variant->spekLengkap() as $grup => $baris)
                    <h3 class="mt-4 text-sm font-bold text-[#16181D]">{{ $grup }}</h3>
                    <dl class="mt-1 grid grid-cols-1 sm:grid-cols-2 gap-x-6">
                        @foreach ($baris as $label => $nilai)
                            <div class="flex justify-between gap-4 border-b border-gray-100 py-2">
                                <dt class="text-sm text-[#4B5563]">{{ $label }}</dt>
                                <dd class="text-sm font-semibold text-right text-[#16181D]">{{ $nilai }}</dd>
                            </div>
                        @endforeach
                    </dl>
                @endforeach
                <p class="mt-3 text-xs text-[#4B5563]">Angka di atas acuan katalog. Minta brosur resmi ke sales untuk angka pasti sebelum SPK.</p>
                <div class="mt-6 hidden lg:flex gap-3">
                    @auth
                        <a href="{{ $unitSpk ? route('spk.create', ['unit_id' => $unitSpk->id]) : route('spk.create') }}" class="flex-1 px-6 py-3 text-center font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Ajukan SPK</a>
                    @else
                        <a href="{{ route('register') }}" class="flex-1 px-6 py-3 text-center font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Daftar untuk Ajukan SPK</a>
                    @endauth
                    <button type="button" data-simulasi-toggle aria-expanded="false" aria-controls="simulasi" class="px-6 py-3 text-center font-semibold text-[#16181D] border border-gray-300 rounded-lg min-h-[44px]">Simulasi Kredit</button>
                </div>
            </div>
        </div>

        <section id="simulasi" aria-labelledby="simulasi-judul" class="mt-8 border border-gray-200 rounded-2xl p-5" hidden>
            <h2 id="simulasi-judul" tabindex="-1" class="text-lg font-bold text-[#16181D]">Simulasi Kredit</h2>
            <p class="mt-1 text-sm text-[#4B5563]">{{ $variant->carModel->brand->nama }} {{ $variant->carModel->nama }} {{ $variant->nama }}</p>
            @if ($variant->priceLists->isNotEmpty() && $leasings->isNotEmpty())
                <form id="simulasi-form" action="{{ route('simulasi.hitung') }}" method="POST" class="mt-4 space-y-4">
                    @csrf
                    <input type="hidden" name="variant_id" value="{{ $variant->id }}">
                    <div>
                        <label for="sim-branch" class="block text-sm font-medium text-[#16181D]">Cabang (harga OTR)</label>
                        <select id="sim-branch" name="branch_id" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                            @foreach ($variant->priceLists as $price)
                                <option value="{{ $price->branch_id }}" data-otr="{{ $price->otr }}">{{ $price->branch->nama }} (Rp {{ number_format($price->otr, 0, ',', '.') }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="sim-dp" class="block text-sm font-medium text-[#16181D]">Uang muka (DP, Rp)</label>
                        <input id="sim-dp" type="number" name="dp" min="0" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                        <p id="sim-dp-hint" class="mt-1 text-sm text-[#4B5563]"></p>
                    </div>
                    <div>
                        <label for="sim-tenor" class="block text-sm font-medium text-[#16181D]">Tenor (bulan)</label>
                        <select id="sim-tenor" name="tenor" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                            @foreach ([12, 24, 36, 48] as $t)
                                <option value="{{ $t }}">{{ $t }} bulan</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="sim-leasing" class="block text-sm font-medium text-[#16181D]">Leasing</label>
                        <select id="sim-leasing" name="leasing_id" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                            @foreach ($leasings as $leasing)
                                <option value="{{ $leasing->id }}" data-dp-min="{{ $leasing->dp_min_persen }}">{{ $leasing->nama }} (DP min {{ $leasing->dp_min_persen }}%)</option>
                            @endforeach
                        </select>
                    </div>
                    <p id="simulasi-error" class="hidden text-sm font-medium text-[#C1121F]" role="alert"></p>
                    <button type="submit" class="w-full px-6 py-3 font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Hitung Angsuran</button>
                </form>
                <div id="simulasi-hasil" class="mt-4" aria-live="polite"></div>
            @else
                <p class="mt-2 text-sm text-[#4B5563]">Simulasi belum tersedia untuk varian ini.</p>
            @endif
        </section>

        <h2 class="mt-8 text-lg font-bold text-[#16181D]">Harga OTR dan stok per cabang</h2>
        <div class="mt-2 overflow-x-auto border border-gray-200 rounded-xl">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left font-semibold text-[#16181D] px-4 py-3">Cabang</th>
                        <th class="text-left font-semibold text-[#16181D] px-4 py-3">Warna tersedia</th>
                        <th class="text-right font-semibold text-[#16181D] px-4 py-3">Harga OTR</th>
                        <th class="text-right font-semibold text-[#16181D] px-4 py-3">Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($variant->priceLists as $price)
                        <tr class="border-b border-gray-100 last:border-0">
                            <td class="px-4 py-3 text-[#16181D]">{{ $price->branch->nama }}</td>
                            <td class="px-4 py-3 text-[#16181D]">{{ ($warnaPerCabang[$price->branch_id] ?? collect())->join(', ') ?: 'Stok kosong' }}</td>
                            <td class="px-4 py-3 text-right font-semibold text-[#16181D] tabular-nums">Rp {{ number_format($price->otr, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right"><x-status-badge status="{{ ($stok[$price->branch_id] ?? 0) > 0 ? 'Tersedia' : 'Dipesan' }}" /></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="lg:hidden sticky bottom-0 bg-white border-t border-gray-200 p-3 flex gap-2">
        @auth
            <a href="{{ $unitSpk ? route('spk.create', ['unit_id' => $unitSpk->id]) : route('spk.create') }}" class="flex-1 px-4 py-3 text-center text-sm font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Ajukan SPK</a>
        @else
            <a href="{{ route('register') }}" class="flex-1 px-4 py-3 text-center text-sm font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Daftar untuk Ajukan SPK</a>
        @endauth
        <button type="button" data-simulasi-toggle aria-expanded="false" aria-controls="simulasi" class="px-4 py-3 text-center text-sm font-semibold text-[#16181D] border border-gray-300 rounded-lg min-h-[44px]">Simulasi</button>
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
            const form = document.getElementById('simulasi-form');
            if (!form) return;
            const branch = document.getElementById('sim-branch');
            const leasing = document.getElementById('sim-leasing');
            const dp = document.getElementById('sim-dp');
            const hint = document.getElementById('sim-dp-hint');
            const galat = document.getElementById('simulasi-error');
            const hasil = document.getElementById('simulasi-hasil');
            const rupiah = (n) => 'Rp ' + Number(n).toLocaleString('id-ID');
            function syncDp() {
                const otr = Number(branch.selectedOptions[0].dataset.otr || 0);
                const minPersen = Number(leasing.selectedOptions[0].dataset.dpMin || 0);
                const min = Math.ceil(otr * minPersen / 100);
                dp.min = min;
                if (!dp.value || Number(dp.value) < min) dp.value = min;
                hint.textContent = 'DP minimal ' + rupiah(min) + ' (' + minPersen + '% dari OTR ' + rupiah(otr) + '). Tidak bisa kurang dari itu.';
            }
            branch.addEventListener('change', syncDp);
            leasing.addEventListener('change', syncDp);
            syncDp();
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                galat.classList.add('hidden');
                hasil.innerHTML = '<p class="text-sm text-[#4B5563]">Menghitung...</p>';
                fetch(form.action, {
                    method: 'POST',
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                    body: new FormData(form),
                }).then(async (res) => {
                    const data = await res.json().catch(() => ({}));
                    if (!res.ok) {
                        const pesan = data.errors ? Object.values(data.errors).flat().join(' ') : (data.message || 'Gagal menghitung. Coba lagi.');
                        galat.textContent = pesan;
                        galat.classList.remove('hidden');
                        hasil.innerHTML = '';
                        return;
                    }
                    hasil.innerHTML = data.html || '';
                }).catch(() => {
                    galat.textContent = 'Jaringan bermasalah. Coba lagi.';
                    galat.classList.remove('hidden');
                    hasil.innerHTML = '';
                });
            });
        })();
    </script>
</x-site-layout>
