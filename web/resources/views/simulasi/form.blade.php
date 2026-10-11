<x-site-layout>
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2 min-h-[44px]">
                <img src="{{ asset('images/logo-an.png') }}" alt="Logo Ayoto Nippon" class="h-10 w-10 object-contain">
                <span class="text-xl font-bold text-[#16181D]">Ayoto Nippon</span>
            </a>
            <a href="{{ route('katalog.index') }}" class="px-3 py-2 text-sm font-medium text-[#16181D] hover:underline min-h-[44px] inline-flex items-center">Katalog</a>
        </div>
    </div>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 py-8">
        <h1 class="text-2xl font-bold text-[#16181D]">Simulasi Kredit</h1>
        <p class="mt-1 text-sm text-[#4B5563]">Hasil simulasi tersimpan dan diteruskan ke sales kami.</p>
        <form action="{{ route('simulasi.hitung') }}" method="POST" class="mt-6 space-y-4">
            @csrf
            <div>
                <label for="variant_id" class="block text-sm font-medium text-[#16181D]">Varian</label>
                <select id="variant_id" name="variant_id" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                    @foreach ($variants as $variant)
                        <option value="{{ $variant->id }}" @selected((string) old('variant_id', $variantId ?? '') === (string) $variant->id)>{{ $variant->carModel->brand->nama }} {{ $variant->carModel->nama }} {{ $variant->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="branch_id" class="block text-sm font-medium text-[#16181D]">Cabang (harga OTR)</label>
                <select id="branch_id" name="branch_id" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="dp" class="block text-sm font-medium text-[#16181D]">Uang muka (DP, Rp)</label>
                <input id="dp" type="number" name="dp" min="0" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                <p id="dp-hint" class="mt-1 text-sm text-[#4B5563]"></p>
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
            const row = prices.find((p) => String(p.variant_id) === String(v) && String(p.branch_id) === String(b));
            if (!row) {
                dp.min = 0;
                hint.textContent = 'Harga OTR belum tersedia untuk kombinasi ini.';
                return;
            }
            const min = Math.ceil(row.otr * (leasings[l] ?? 0) / 100);
            dp.min = min;
            if (!dp.value || Number(dp.value) < min) dp.value = min;
            hint.textContent = 'DP minimal ' + rupiah(min) + ' (' + (leasings[l] ?? 0) + '% dari OTR ' + rupiah(row.otr) + '). Tidak bisa kurang dari itu.';
        }
        ['variant_id', 'branch_id', 'leasing_id'].forEach((id) => document.getElementById(id).addEventListener('change', syncDp));
        syncDp();
    </script>
</x-site-layout>
