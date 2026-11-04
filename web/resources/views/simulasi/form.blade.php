<x-site-layout judul="Simulasi Kredit" deskripsi="Hitung angsuran mobil baru per varian, cabang, dan leasing. Hasil simulasi diteruskan ke sales Ayoto Nippon.">
    <x-site-header />

    <div class="w-full px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-3xl p-6 sm:p-10 shadow-2xl shadow-black/5 w-full">
            <div class="pb-6 border-b border-[#E5E7EB]">
                <p class="text-xs font-semibold tracking-wider text-[#C1121F] uppercase">Kalkulator Pembiayaan</p>
                <h1 class="mt-1 text-2xl sm:text-3xl font-extrabold text-[#16181D] tracking-tight">Simulasi Angsuran Kredit</h1>
                <p class="mt-2 text-xs sm:text-sm text-[#4B5563] leading-relaxed">
                    Hitung estimasi uang muka dan cicilan bulanan secara instan dengan mitra lembaga keuangan resmi.
                </p>
            </div>

            <form action="{{ route('simulasi.hitung') }}" method="POST" class="mt-8 space-y-6">
                @csrf

                <div>
                    <label for="variant_id" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Pilih Model & Varian Mobil</label>
                    <select id="variant_id" name="variant_id" required 
                        class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                        <option value="" @selected(! old('variant_id', $variantId ?? null))>Pilih Varian Kendaraan</option>
                        @foreach ($variants as $variant)
                            <option value="{{ $variant->id }}" @selected((string) old('variant_id', $variantId ?? '') === (string) $variant->id)>{{ $variant->carModel->brand->nama }} {{ $variant->carModel->nama }} {{ $variant->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="branch_id" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Cabang Pengiriman (Harga OTR Wilayah)</label>
                    <select id="branch_id" name="branch_id" required 
                        class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                        <option value="" @selected(! old('branch_id'))>Pilih Cabang Dealer</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}" @selected((string) old('branch_id') === (string) $branch->id)>{{ $branch->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="leasing_id" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Lembaga Pembiayaan (Leasing Rekanan)</label>
                    <select id="leasing_id" name="leasing_id" required 
                        class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                        @foreach ($leasings as $leasing)
                            <option value="{{ $leasing->id }}">{{ $leasing->nama }} (Bunga {{ $leasing->bunga_dasar }}%, DP min {{ $leasing->dp_min_persen }}%)</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="dp" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Rencana Uang Muka (DP, Nominal Rp)</label>
                    <input id="dp" type="number" name="dp" value="{{ old('dp') }}" min="0" required 
                        placeholder="Masukkan nominal DP..."
                        class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5 tabular-nums">
                    <p id="dp-hint" class="mt-2 text-xs text-[#C1121F] font-medium">Pilih varian dan cabang terlebih dahulu untuk melihat batas DP minimum.</p>
                </div>

                <div>
                    <label for="tenor" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Jangka Waktu Tenor</label>
                    <select id="tenor" name="tenor" required 
                        class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                        @foreach ([12, 24, 36, 48] as $t)
                            <option value="{{ $t }}">{{ $t }} Bulan ({{ $t / 12 }} Tahun)</option>
                        @endforeach
                    </select>
                </div>

                <x-input-error :messages="$errors->all()" class="text-[#C1121F] text-xs" />

                <div class="pt-2">
                    <button type="submit" 
                        class="w-full py-3.5 px-6 font-bold text-sm text-white bg-[#C1121F] hover:bg-[#9E0E19] rounded-xl min-h-[48px] shadow-lg shadow-[#C1121F]/25 transition-all flex items-center justify-center active:scale-[0.99]">
                        Hitung Estimasi Angsuran
                    </button>
                    <p class="mt-3 text-center text-xs text-gray-500">
                        Hasil perhitungan diteruskan secara otomatis ke tim sales untuk konfirmasi simulasi resmi.
                    </p>
                </div>
            </form>
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
