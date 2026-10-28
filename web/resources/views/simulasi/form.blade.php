<x-site-layout judul="Simulasi Kredit" deskripsi="Hitung angsuran mobil baru per varian, cabang, dan leasing. Hasil simulasi diteruskan ke sales Ayoto Nippon.">
    <x-site-header />
    <div class="max-w-2xl mx-auto px-4 sm:px-6 py-8">
        <h1 class="text-2xl font-bold text-[#16181D]">Simulasi Kredit</h1>
        <p class="mt-1 text-sm text-[#4B5563]">Hasil simulasi tersimpan dan diteruskan ke sales kami.</p>
        <form action="{{ route('simulasi.hitung') }}" method="POST" class="mt-6 space-y-4">
            @csrf
            <div>
                <label for="variant_id" class="block text-sm font-medium text-[#16181D]">Varian</label>
                <select id="variant_id" name="variant_id" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                    <option value="" @selected(! old('variant_id', $variantId ?? null))>Pilih varian</option>
                    @foreach ($variants as $variant)
                        <option value="{{ $variant->id }}" @selected((string) old('variant_id', $variantId ?? '') === (string) $variant->id)>{{ $variant->carModel->brand->nama }} {{ $variant->carModel->nama }} {{ $variant->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="branch_id" class="block text-sm font-medium text-[#16181D]">Cabang (harga OTR)</label>
                <select id="branch_id" name="branch_id" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                    <option value="" @selected(! old('branch_id'))>Pilih cabang</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}" @selected((string) old('branch_id') === (string) $branch->id)>{{ $branch->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="dp" class="block text-sm font-medium text-[#16181D]">Uang muka (DP, Rp)</label>
                <input id="dp" type="number" name="dp" value="{{ old('dp') }}" min="0" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                <p id="dp-hint" class="mt-1 text-sm text-[#4B5563]">Pilih varian dan cabang dulu untuk melihat DP minimum.</p>
            </div>
            <div>
                <label for="tenor" class="block text-sm font-medium text-[#16181D]">Tenor (bulan)</label>
                <select id="tenor" name="tenor" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                    @foreach ([12, 24, 36, 48] as $t)
                        <option value="{{ $t }}">{{ $t }} bulan</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="leasing_id" class="block text-sm font-medium text-[#16181D]">Leasing</label>
                <select id="leasing_id" name="leasing_id" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                    @foreach ($leasings as $leasing)
                        <option value="{{ $leasing->id }}">{{ $leasing->nama }} (DP min {{ $leasing->dp_min_persen }}%)</option>
                    @endforeach
                </select>
            </div>
            <x-input-error :messages="$errors->all()" class="mt-2" />
            <button type="submit" class="w-full px-6 py-3 font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Hitung Angsuran</button>
        </form>
    </div>
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
                hint.textContent = 'Pilih varian dan cabang dulu untuk melihat DP minimum.';
                return;
            }
            const row = prices.find((p) => String(p.variant_id) === String(v) && String(p.branch_id) === String(b));
            if (!row) {
                dp.min = 0;
                hint.textContent = 'Harga OTR belum tersedia untuk kombinasi ini.';
                return;
            }
            const min = Math.ceil(row.otr * (leasings[l] ?? 0) / 100);
            dp.min = min;
            hint.textContent = 'DP minimal ' + rupiah(min) + ' (' + (leasings[l] ?? 0) + '% dari OTR ' + rupiah(row.otr) + '). Tidak bisa kurang dari itu.';
        }
        ['variant_id', 'branch_id', 'leasing_id'].forEach((id) => document.getElementById(id).addEventListener('change', syncDp));
        syncDp();
    </script>
</x-site-layout>
