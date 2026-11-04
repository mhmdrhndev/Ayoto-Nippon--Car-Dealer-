<x-site-layout judul="Pengajuan SPK" deskripsi="Pemesanan resmi Surat Pesanan Kendaraan (SPK) mobil baru di dealer Ayoto Nippon.">
    <x-site-header />

    <div class="w-full px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-3xl p-6 sm:p-10 shadow-2xl shadow-black/5 w-full">
            <div class="pb-6 border-b border-[#E5E7EB]">
                <p class="text-xs font-semibold tracking-wider text-[#C1121F] uppercase">Pemesanan Resmi Dealer</p>
                <h1 class="mt-1 text-2xl sm:text-3xl font-extrabold text-[#16181D] tracking-tight">Pengajuan Surat Pesanan Kendaraan (SPK)</h1>
                <p class="mt-2 text-xs sm:text-sm text-[#4B5563] leading-relaxed">
                    Pilih alokasi fisik unit nomor rangka (VIN) yang tersedia di cabang dealer. Setelah formulir dikirim, nomor SPK resmi akan diterbitkan dengan batas waktu pembayaran booking fee 24 jam.
                </p>
            </div>

            <div class="mt-8 space-y-5">
                <div>
                    <label for="variant_id" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Pilih Model & Varian Kendaraan</label>
                    <select id="variant_id" 
                        class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5" 
                        onchange="location.href='{{ route('spk.create') }}?variant_id=' + this.value + '&color_id=' + document.getElementById('color_id').value">
                        @foreach ($variants as $v)
                            <option value="{{ $v->id }}" @selected((string) $variant_id === (string) $v->id)>
                                {{ $v->carModel->brand->nama }} {{ $v->carModel->nama }} - {{ $v->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="branch_id" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Filter Cabang</label>
                        <select id="branch_id" 
                            class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                            <option value="">Semua Cabang</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}" @selected((string) $branch_id === (string) $branch->id)>{{ $branch->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="color_id" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Filter Warna Fisik</label>
                        <select id="color_id" 
                            class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                            <option value="">Semua Warna</option>
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}" @selected((string) $color_id === (string) $color->id)>{{ $color->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <form action="{{ route('spk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 pt-2">
                    @csrf

                    <div>
                        <label for="unit_id" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Pilih Unit Fisik Tersedia</label>
                        <select id="unit_id" name="unit_id" required 
                            class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                            <option value="">Pilih unit ready stock dari daftar...</option>
                            @forelse ($branches as $branch)
                                @php $daftar = $units->where('branch_id', $branch->id); @endphp
                                @if ($daftar->isNotEmpty())
                                    <optgroup label="Cabang {{ $branch->nama }}" class="bg-[#FFFFFF] text-[#4B5563] font-bold">
                                        @foreach ($daftar as $unit)
                                            <option value="{{ $unit->id }}" data-branch="{{ $unit->branch_id }}" data-color="{{ $unit->color_id }}" data-variant="{{ $unit->variant_id }}" data-model="{{ $unit->variant->car_model_id }}" @selected((string) $unit_id === (string) $unit->id) class="text-[#16181D]">
                                                {{ $unit->variant->carModel->brand->nama }} {{ $unit->variant->carModel->nama }} {{ $unit->variant->nama }} | Warna: {{ $unit->color->nama }} | OTR: Rp {{ number_format($unit->harga, 0, ',', '.') }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endif
                            @empty
                                <option value="" disabled>Tidak ada unit tersedia untuk varian ini</option>
                            @endforelse
                        </select>
                        <p id="unit-pesan" class="hidden mt-2 text-xs font-medium text-[#C1121F] bg-rose-500/10 border border-rose-500/20 p-2.5 rounded-xl"></p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="nama" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Nama Pemesan (Sesuai KTP)</label>
                            <input id="nama" name="nama" value="{{ old('nama') }}" required 
                                placeholder="Nama lengkap pemesan"
                                class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] placeholder-gray-500 text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                        </div>

                        <div>
                            <label for="nik" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">NIK KTP (16 Digit)</label>
                            <input id="nik" name="nik" value="{{ old('nik') }}" required inputmode="numeric" maxlength="16" 
                                placeholder="3201..."
                                class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] placeholder-gray-500 text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                        </div>

                        <div>
                            <label for="telp" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Nomor Telepon / WhatsApp</label>
                            <input id="telp" name="telp" value="{{ old('telp') }}" required inputmode="tel" 
                                placeholder="0812..."
                                class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] placeholder-gray-500 text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                        </div>

                        <div>
                            <label for="metode" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Metode Pembayaran</label>
                            <select id="metode" name="metode" required 
                                class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                                @foreach (['Cash', 'Kredit', 'TradeIn', 'Transfer'] as $m)
                                    <option value="{{ $m }}" @selected(old('metode') === $m)>{{ $m }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="alamat" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Alamat Lengkap KTP / Domisili STNK</label>
                        <textarea id="alamat" name="alamat" required rows="2" 
                            placeholder="Alamat lengkap yang akan tertera pada faktur & STNK..."
                            class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] placeholder-gray-500 text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] p-3.5">{{ old('alamat') }}</textarea>
                    </div>

                    <div>
                        <label for="sales_id" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Sales Consultant Pendamping (Opsional)</label>
                        <select id="sales_id" name="sales_id" 
                            class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                            <option value="">Tanpa Sales Khusus (Dialokasikan Otomatis)</option>
                            @foreach ($salesList as $sales)
                                <option value="{{ $sales->id }}" @selected(old('sales_id') == $sales->id)>{{ $sales->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 p-5 bg-[#FFFFFF] border border-[#E5E7EB] rounded-2xl">
                        <div>
                            <label for="leasing_id" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Leasing (Jika Kredit)</label>
                            <select id="leasing_id" name="leasing_id" 
                                class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[44px] px-3">
                                <option value="">Tanpa Leasing (Tunai)</option>
                                @foreach ($leasings as $leasing)
                                    <option value="{{ $leasing->id }}" @selected((string) old('leasing_id', $prefill['leasing_id'] ?? '') === (string) $leasing->id)>{{ $leasing->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="tenor" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Tenor Kredit</label>
                            <select id="tenor" name="tenor" 
                                class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[44px] px-3">
                                <option value="">Pilih Tenor</option>
                                @foreach ([12, 24, 36, 48] as $t)
                                    <option value="{{ $t }}" @selected((string) old('tenor', $prefill['tenor'] ?? '') === (string) $t)>{{ $t }} Bulan</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="dp_rencana" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Rencana DP (Nominal Rp)</label>
                            <input id="dp_rencana" type="number" name="dp_rencana" value="{{ old('dp_rencana', $prefill['dp'] ?? 0) }}" min="0" 
                                class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[44px] px-3.5 tabular-nums">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="ktp" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Upload KTP Asli (Wajib)</label>
                            <div class="mt-1.5 p-3.5 bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl">
                                <input id="ktp" type="file" name="ktp" required accept=".jpg,.jpeg,.png,.pdf" 
                                    class="w-full text-xs text-[#4B5563] file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#C1121F] file:text-white hover:file:bg-[#9E0E19] cursor-pointer">
                            </div>
                        </div>

                        <div>
                            <label for="kk" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Upload KK / NPWP (Opsional)</label>
                            <div class="mt-1.5 p-3.5 bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl">
                                <input id="kk" type="file" name="kk" accept=".jpg,.jpeg,.png,.pdf" 
                                    class="w-full text-xs text-[#4B5563] file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#E5E7EB] file:text-[#4B5563] hover:file:bg-[#E5E7EB] cursor-pointer">
                            </div>
                        </div>
                    </div>

                    <x-input-error :messages="$errors->all()" class="text-[#C1121F] text-xs" />

                    <div class="pt-4 border-t border-[#E5E7EB]">
                        <button type="submit" 
                            class="w-full py-4 px-6 font-bold text-base text-white bg-[#C1121F] hover:bg-[#9E0E19] rounded-xl min-h-[52px] shadow-lg shadow-[#C1121F]/30 transition-all flex items-center justify-center active:scale-[0.99]">
                            Terbitkan Dokumen SPK
                        </button>
                        <p class="mt-3 text-center text-xs text-gray-500">
                            Setelah SPK diterbitkan, tanda jadi dapat ditransfer ke rekening resmi dealer sebelum batas kadaluwarsa 24 jam.
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-site-footer />

    <script>
        (function () {
            const branch = document.getElementById('branch_id');
            const color = document.getElementById('color_id');
            const unit = document.getElementById('unit_id');
            const pesan = document.getElementById('unit-pesan');
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
