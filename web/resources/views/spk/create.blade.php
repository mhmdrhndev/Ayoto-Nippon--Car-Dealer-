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
        <h1 class="text-2xl font-bold text-[#16181D]">Pengajuan SPK</h1>
        <div class="mt-4">
            <label for="variant_id" class="block text-sm font-medium text-[#16181D]">Model & Varian Mobil</label>
            <select id="variant_id" class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]" onchange="location.href='{{ route('spk.create') }}?variant_id=' + this.value + '&color_id=' + document.getElementById('color_id').value">
                @foreach ($variants as $v)
                    <option value="{{ $v->id }}" @selected((string) $variant_id === (string) $v->id)>
                        {{ $v->carModel->brand->nama }} {{ $v->carModel->nama }} - {{ $v->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
            <div>
                <label for="branch_id" class="block text-sm font-medium text-[#16181D]">Cabang</label>
                <select id="branch_id" class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                    <option value="">Semua cabang</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}" @selected((string) $branch_id === (string) $branch->id)>{{ $branch->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="color_id" class="block text-sm font-medium text-[#16181D]">Warna</label>
                <select id="color_id" class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                    <option value="">Semua warna</option>
                    @foreach ($colors as $color)
                        <option value="{{ $color->id }}" @selected((string) $color_id === (string) $color->id)>{{ $color->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <form action="{{ route('spk.store') }}" method="POST" enctype="multipart/form-data" class="mt-4 space-y-4">
            @csrf
        <div>
            <label for="unit_id" class="block text-sm font-medium text-[#16181D]">Pilih unit tersedia</label>
            <select id="unit_id" name="unit_id" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                <option value="">Pilih unit dari daftar</option>
                @forelse ($branches as $branch)
                    @php $daftar = $units->where('branch_id', $branch->id); @endphp
                    @if ($daftar->isNotEmpty())
                        <optgroup label="{{ $branch->nama }}">
                            @foreach ($daftar as $unit)
                                <option value="{{ $unit->id }}" data-branch="{{ $unit->branch_id }}" data-color="{{ $unit->color_id }}" data-variant="{{ $unit->variant_id }}" data-model="{{ $unit->variant->car_model_id }}" @selected((string) $unit_id === (string) $unit->id)>
                                    {{ $unit->variant->carModel->brand->nama }} {{ $unit->variant->carModel->nama }} {{ $unit->variant->nama }}, {{ $unit->color->nama }}, Rp {{ number_format($unit->harga, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endif
                @empty
                    <option value="" disabled>Tidak ada unit tersedia untuk varian ini</option>
                @endforelse
            </select>
            <p id="unit-pesan" class="hidden mt-1 text-sm font-medium text-[#C1121F]"></p>
        </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="nama" class="block text-sm font-medium text-[#16181D]">Nama lengkap</label>
                    <input id="nama" name="nama" value="{{ old('nama') }}" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                </div>
                <div>
                    <label for="nik" class="block text-sm font-medium text-[#16181D]">NIK (16 digit)</label>
                    <input id="nik" name="nik" value="{{ old('nik') }}" required inputmode="numeric" class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                </div>
                <div>
                    <label for="telp" class="block text-sm font-medium text-[#16181D]">No. telepon (10-15 digit)</label>
                    <input id="telp" name="telp" value="{{ old('telp') }}" required inputmode="tel" class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                </div>
                <div>
                    <label for="metode" class="block text-sm font-medium text-[#16181D]">Metode bayar</label>
                    <select id="metode" name="metode" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                        @foreach (['Cash', 'Kredit', 'TradeIn', 'Transfer'] as $m)
                            <option value="{{ $m }}" @selected(old('metode') === $m)>{{ $m }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <label for="alamat" class="block text-sm font-medium text-[#16181D]">Alamat</label>
                <textarea id="alamat" name="alamat" required rows="2" class="mt-1 w-full rounded-lg border-gray-300">{{ old('alamat') }}</textarea>
            </div>
            <div>
                <label for="sales_id" class="block text-sm font-medium text-[#16181D]">Pilih sales pendamping (opsional)</label>
                <select id="sales_id" name="sales_id" class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                    <option value="">Tanpa sales khusus</option>
                    @foreach ($salesList as $sales)
                        <option value="{{ $sales->id }}" @selected(old('sales_id') == $sales->id)>{{ $sales->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="leasing_id" class="block text-sm font-medium text-[#16181D]">Leasing (wajib jika Kredit)</label>
                    <select id="leasing_id" name="leasing_id" class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                        <option value="">Tanpa leasing</option>
                        @foreach ($leasings as $leasing)
                            <option value="{{ $leasing->id }}" @selected((string) old('leasing_id', $prefill['leasing_id'] ?? '') === (string) $leasing->id)>{{ $leasing->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="tenor" class="block text-sm font-medium text-[#16181D]">Tenor (wajib jika Kredit)</label>
                    <select id="tenor" name="tenor" class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                        <option value="">Pilih</option>
                        @foreach ([12, 24, 36, 48] as $t)
                            <option value="{{ $t }}" @selected((string) old('tenor', $prefill['tenor'] ?? '') === (string) $t)>{{ $t }} bulan</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="dp_rencana" class="block text-sm font-medium text-[#16181D]">DP rencana (Rp)</label>
                    <input id="dp_rencana" type="number" name="dp_rencana" value="{{ old('dp_rencana', $prefill['dp'] ?? 0) }}" min="0" class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="ktp" class="block text-sm font-medium text-[#16181D]">Foto KTP (JPG/PNG/PDF, maks 2 MB)</label>
                    <input id="ktp" type="file" name="ktp" required accept=".jpg,.jpeg,.png,.pdf" class="mt-1 w-full min-h-[44px]">
                </div>
                <div>
                    <label for="kk" class="block text-sm font-medium text-[#16181D]">Foto KK (opsional)</label>
                    <input id="kk" type="file" name="kk" accept=".jpg,.jpeg,.png,.pdf" class="mt-1 w-full min-h-[44px]">
                </div>
            </div>
            <x-input-error :messages="$errors->all()" class="mt-2" />
            <button type="submit" class="w-full px-6 py-3 font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Buat SPK</button>
        </form>
    </div>
    <script>
        (function () {
            const branch = document.getElementById('branch_id');
            const color = document.getElementById('color_id');
            const unit = document.getElementById('unit_id');
            const pesan = document.getElementById('unit-pesan');
            // Identitas kendaraan yang sedang dikerjakan. Hanya berubah saat pengguna memilih unit secara manual,
            // tidak pernah diubah oleh perubahan filter cabang atau warna.
            let varianTerkunci = null;
            let modelTerkunci = null;
            function pilihanUnit() {
                const opt = unit.selectedOptions.length ? unit.selectedOptions[0] : null;
                return opt && opt.value ? opt : null;
            }
            function kunciDariPilihan() {
                const opt = pilihanUnit();
                varianTerkunci = opt ? (opt.dataset.variant || null) : null;
                modelTerkunci = opt ? (opt.dataset.model || null) : null;
            }
            kunciDariPilihan();
            function saring(umumkan) {
                const b = branch.value;
                let c = color.value;
                const warnaAda = new Set();
                Array.from(unit.options).forEach((opt) => {
                    if (!opt.value) return;
                    if (b && opt.dataset.branch !== b) return;
                    if (varianTerkunci && opt.dataset.variant !== varianTerkunci) return;
                    if (modelTerkunci && opt.dataset.model && opt.dataset.model !== modelTerkunci) return;
                    warnaAda.add(opt.dataset.color);
                });
                let warnaBerubah = false;
                Array.from(color.options).forEach((opt) => {
                    if (!opt.value) return;
                    const ada = warnaAda.has(opt.value);
                    opt.disabled = !ada;
                    if (!ada && color.value === opt.value) {
                        color.value = '';
                        warnaBerubah = true;
                    }
                });
                c = color.value;
                let nampak = 0;
                Array.from(unit.options).forEach((opt) => {
                    if (!opt.value) return;
                    const cocok = (!b || opt.dataset.branch === b)
                        && (!varianTerkunci || opt.dataset.variant === varianTerkunci)
                        && (!modelTerkunci || !opt.dataset.model || opt.dataset.model === modelTerkunci)
                        && (!c || opt.dataset.color === c);
                    opt.hidden = !cocok;
                    opt.disabled = !cocok;
                    if (cocok) nampak++;
                });
                Array.from(unit.getElementsByTagName('optgroup')).forEach((g) => {
                    const ada = Array.from(g.children).some((opt) => !opt.disabled);
                    g.hidden = !ada;
                });
                const terpilih = pilihanUnit();
                if (terpilih && terpilih.disabled) {
                    unit.value = '';
                    if (umumkan) {
                        pesan.textContent = 'Unit yang dipilih tidak tersedia pada cabang dan warna ini. Silakan pilih unit lain untuk varian ini.';
                        pesan.classList.remove('hidden');
                    }
                } else if (nampak === 0) {
                    unit.value = '';
                    pesan.textContent = 'Tidak ada unit varian ini yang cocok dengan filter cabang dan warna ini.';
                    pesan.classList.remove('hidden');
                } else if (!terpilih && umumkan) {
                    pesan.textContent = 'Silakan pilih unit dari daftar yang sudah difilter.';
                    pesan.classList.remove('hidden');
                } else if ((!terpilih || !terpilih.disabled) && !warnaBerubah) {
                    pesan.classList.add('hidden');
                } else if (warnaBerubah) {
                    pesan.textContent = 'Warna tersebut kosong untuk varian ini di cabang ini, filter warna direset.';
                    pesan.classList.remove('hidden');
                }
            }
            branch.addEventListener('change', () => saring(true));
            color.addEventListener('change', () => saring(true));
            unit.addEventListener('change', () => {
                kunciDariPilihan();
                saring(false);
                if (!pilihanUnit()) {
                    pesan.textContent = 'Silakan pilih unit dari daftar unit tersedia.';
                    pesan.classList.remove('hidden');
                } else {
                    pesan.classList.add('hidden');
                }
            });
            saring(false);
        })();
    </script>
</x-site-layout>
