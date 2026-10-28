<x-site-layout>
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2 min-h-[44px]">
                <img src="{{ asset('images/logo-an.png') }}" alt="Logo Ayoto Nippon" class="h-10 w-10 object-contain">
                <span class="text-xl font-bold text-[#16181D]">Ayoto Nippon</span>
            </a>
            <a href="{{ route('lacak.form') }}" class="px-3 py-2 text-sm font-medium text-[#16181D] hover:underline min-h-[44px] inline-flex items-center">Lacak SPK</a>
        </div>
    </div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-8">
        @if (session('sukses'))
            <p class="p-3 text-sm font-medium text-[#16181D] bg-green-50 border border-green-200 rounded-lg">{{ session('sukses') }}</p>
        @endif
        <p class="text-xs font-semibold tracking-widest text-[#C1121F]">STATUS SURAT PEMESANAN KENDARAAN</p>
        <h1 class="mt-1 text-2xl sm:text-3xl font-bold text-[#16181D]">Lacak SPK <span class="font-mono">{{ $order->no_spk }}</span></h1>

        <div class="mt-4 grid grid-cols-2 lg:grid-cols-4 gap-3">
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                <p class="text-[11px] text-[#4B5563]">Nomor SPK</p>
                <p class="mt-1 text-sm font-bold font-mono text-[#16181D]">{{ $order->no_spk }}</p>
            </div>
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                <p class="text-[11px] text-[#4B5563]">Tanggal pengajuan</p>
                <p class="mt-1 text-sm font-bold text-[#16181D]">{{ $order->created_at->format('d M Y H:i') }}</p>
            </div>
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                <p class="text-[11px] text-[#4B5563]">Cabang</p>
                <p class="mt-1 text-sm font-bold text-[#16181D]">{{ $order->branch->nama }}</p>
            </div>
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                <p class="text-[11px] text-[#4B5563]">Status</p>
                <p class="mt-1"><x-status-badge status="{{ $order->status }}" /></p>
            </div>
        </div>

        <div class="mt-4 bg-white border border-gray-200 rounded-2xl p-5 grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div class="min-w-0">
                @if ($order->unit->foto_utama)
                    <img src="{{ asset($order->unit->foto_utama) }}" alt="{{ $order->unit->variant->carModel->brand->nama }} {{ $order->unit->variant->carModel->nama }} {{ $order->unit->variant->nama }}" class="w-full aspect-video object-cover rounded-xl">
                @else
                    <div class="w-full aspect-video bg-gray-100 rounded-xl flex items-center justify-center text-sm text-[#4B5563]">Foto menyusul</div>
                @endif
            </div>
            <div class="min-w-0">
                <p class="text-sm font-medium text-[#4B5563] break-words">{{ $order->unit->variant->carModel->brand->nama }} {{ $order->unit->variant->carModel->nama }}</p>
                <p class="mt-1 text-xl font-bold text-[#16181D] break-words">{{ $order->unit->variant->nama }}</p>
                <dl class="mt-3 text-sm">
                    <div class="flex justify-between border-b border-gray-100 py-2">
                        <dt class="text-[#4B5563]">Warna</dt>
                        <dd class="font-semibold text-[#16181D]">{{ $order->unit->color->nama }}</dd>
                    </div>
                    <div class="flex justify-between border-b border-gray-100 py-2">
                        <dt class="text-[#4B5563]">VIN</dt>
                        <dd class="font-mono font-semibold text-right text-[#16181D] break-all">{{ $order->unit->vin }}</dd>
                    </div>
                    <div class="flex justify-between border-b border-gray-100 py-2">
                        <dt class="text-[#4B5563]">Transmisi</dt>
                        <dd class="font-semibold text-[#16181D]">{{ $order->unit->variant->transmisi }}</dd>
                    </div>
                    <div class="flex justify-between py-2">
                        <dt class="text-[#4B5563]">Harga unit</dt>
                        <dd class="font-semibold text-[#16181D] tabular-nums">Rp {{ number_format($order->unit->harga, 0, ',', '.') }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        @php
            $alur = ['MenungguBayar' => 'SPK dibuat', 'MenungguVerifikasi' => 'Bukti diterima', 'Deal' => 'Deal'];
            $posisi = array_search($order->status, array_keys($alur), true);
        @endphp
        <h2 class="mt-8 text-lg font-bold text-[#16181D]">Perjalanan SPK</h2>
        <ol class="mt-3 grid grid-cols-1 sm:grid-cols-3 gap-3">
            @foreach ($alur as $kode => $label)
                @php
                    $lewat = $posisi !== false && array_search($kode, array_keys($alur), true) < $posisi;
                    $aktif = $posisi !== false && $kode === $order->status;
                @endphp
                <li class="border rounded-xl p-4 {{ $aktif ? 'border-[#C1121F] bg-red-50' : ($lewat ? 'border-green-200 bg-green-50' : 'border-gray-200 bg-white') }}">
                    <p class="text-sm font-bold {{ $aktif ? 'text-[#C1121F]' : 'text-[#16181D]' }}">{{ $label }}</p>
                    <p class="mt-1 text-xs text-[#4B5563]">{{ $aktif ? 'Tahap aktif' : ($lewat ? 'Selesai' : 'Menunggu') }}</p>
                </li>
            @endforeach
        </ol>

        @if ($order->status === 'MenungguBayar')
            <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-4">
                <div class="p-5 border border-gray-200 rounded-2xl">
                    <p class="text-xs font-semibold tracking-widest text-[#C1121F]">INSTRUKSI PEMBAYARAN</p>
                    <h2 class="mt-1 font-bold text-[#16181D]">Transfer booking fee</h2>
                    <p class="mt-2 text-3xl font-bold text-[#16181D] tabular-nums">Rp {{ number_format($order->booking_fee, 0, ',', '.') }}</p>
                    @foreach ($order->branch->bankAccounts->where('aktif', true) as $rek)
                        <div class="mt-3 flex items-center justify-between gap-2 border border-gray-100 rounded-lg px-3 py-2">
                            <p class="text-sm text-[#16181D]">{{ $rek->bank }} <span class="font-mono font-semibold">{{ $rek->no_rek }}</span> a.n. {{ $rek->atas_nama }}</p>
                            <button type="button" data-salin="{{ $rek->no_rek }}" class="text-xs font-semibold text-[#C1121F] hover:underline min-h-[44px] px-2 flex-shrink-0">Salin</button>
                        </div>
                    @endforeach
                    <p class="mt-3 text-sm font-semibold text-[#C1121F]">Batas bayar: {{ $order->deadline_at->format('d M Y H:i') }}</p>
                    <p class="text-sm text-[#4B5563]">Sisa waktu: <span id="sisa-bayar" data-deadline="{{ $order->deadline_at->toIso8601String() }}" class="font-semibold text-[#16181D] tabular-nums">-</span></p>
                    <p class="mt-1 text-xs text-[#4B5563]">Lewat batas, SPK otomatis Expired dan unit dilepas.</p>
                </div>
                <div class="p-5 border border-gray-200 rounded-2xl">
                    <h2 class="font-bold text-[#16181D]">Konfirmasi bukti transfer</h2>
                    <p class="mt-1 text-sm text-[#4B5563]">JPG, PNG, atau PDF maksimal 2 MB.</p>
                    @auth
                        @if ($order->customer->user_id !== null && $order->customer->user_id !== auth()->id())
                            <p class="mt-4 p-3 text-sm text-[#16181D] bg-yellow-50 border border-yellow-200 rounded-lg">SPK ini milik akun lain. Masuk dengan akun yang membuat SPK untuk mengunggah bukti.</p>
                        @else
                            <form action="{{ route('spk.upload', $order->no_spk) }}" method="POST" enctype="multipart/form-data" class="mt-4 space-y-3">
                                @csrf
                                <label for="bukti" class="block text-sm font-medium text-[#16181D]">Upload bukti transfer</label>
                                <input id="bukti" type="file" name="bukti" required accept=".jpg,.jpeg,.png,.pdf" class="w-full min-h-[44px]">
                                <x-input-error :messages="$errors->all()" />
                                <button type="submit" class="w-full px-6 py-3 font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Kirim Bukti Pembayaran</button>
                            </form>
                        @endif
                    @else
                        <p class="mt-4 text-sm text-[#4B5563]"><a href="{{ route('login') }}" class="underline font-medium text-[#16181D]">Masuk</a> untuk mengunggah bukti bayar.</p>
                    @endauth
                </div>
            </div>
        @endif

        @if ($order->status === 'MenungguVerifikasi')
            <p class="mt-8 p-4 text-sm text-[#16181D] bg-yellow-50 border border-yellow-200 rounded-xl">Bukti sudah diterima dan menunggu verifikasi admin.</p>
        @endif
        @if ($order->status === 'Deal')
            <div class="mt-8 p-5 border border-green-200 bg-green-50 rounded-2xl">
                <h2 class="font-bold text-[#16181D]">SPK Deal</h2>
                <p class="mt-1 text-sm text-[#16181D]">Unit sudah menjadi milik proses Anda. Pelunasan sisa dilakukan offline di dealer.</p>
                @if ($order->invoice)
                    <p class="mt-2 text-sm text-[#16181D]">Invoice: <span class="font-mono font-semibold">{{ $order->invoice->no_inv }}</span>
                    @auth
                        <a href="{{ route('invoice.download', $order->invoice) }}" class="underline font-semibold">Unduh PDF</a>
                    @else
                        (minta salinan PDF ke admin cabang)
                    @endif
                    </p>
                @endif
            </div>
            @if (auth()->user()?->hasAnyRole(['admin-cabang', 'sales', 'pimpinan', 'superadmin', 'owner']))
                @if ($order->bast_path)
                    <p class="mt-2 text-sm text-[#16181D]">BAST serah terima sudah diunggah.</p>
                @else
                    <form action="{{ route('admin.orders.bast', $order) }}" method="POST" enctype="multipart/form-data" class="mt-3 space-y-2">
                        @csrf @method('PATCH')
                        <label for="bast" class="block text-sm font-medium text-[#16181D]">Upload BAST serah terima (JPG/PNG/PDF, maks 2 MB)</label>
                        <input id="bast" type="file" name="bast" required accept=".jpg,.jpeg,.png,.pdf" class="w-full min-h-[44px]">
                        <button class="w-full px-6 py-3 font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Upload BAST</button>
                    </form>
                @endif
            @endif
        @endif
        @if ($order->tolak_alasan)
            <p class="mt-4 p-3 text-sm text-[#16181D] bg-red-50 border border-red-200 rounded-lg">Alasan penolakan: {{ $order->tolak_alasan }}</p>
        @endif
        @if (in_array($order->status, ['Expired', 'Batal', 'Ditolak']))
            <p class="mt-4 text-sm text-[#4B5563]">Unit sudah dilepas. Anda bisa mengajukan SPK baru dari katalog.</p>
        @endif
        @if ($order->branch->telp)
            <div class="mt-6 p-5 bg-gray-50 border border-gray-200 rounded-2xl flex flex-col sm:flex-row sm:items-center gap-3">
                <p class="text-sm text-[#16181D] flex-1">Butuh bantuan terkait SPK ini? Hubungi cabang langsung.</p>
                <a href="{{ \App\Support\Wa::chat($order->branch->telp, 'Halo'.$order->branch->nama.', saya bertanya mengenai SPK '.$order->no_spk.'.') }}" target="_blank" rel="noopener" class="px-6 py-3 text-center font-semibold text-white bg-[#16181D] rounded-lg min-h-[44px]">Chat WA Cabang</a>
            </div>
        @endif
    </div>
    <script>
        (function () {
            document.querySelectorAll('[data-salin]').forEach((btn) => {
                btn.addEventListener('click', async () => {
                    try {
                        await navigator.clipboard.writeText(btn.dataset.salin);
                        const awal = btn.textContent;
                        btn.textContent = 'Tersalin';
                        setTimeout(() => { btn.textContent = awal; }, 1500);
                    } catch (e) {
                        btn.textContent = 'Gagal menyalin';
                    }
                });
            });
            const sisa = document.getElementById('sisa-bayar');
            if (sisa) {
                const batas = new Date(sisa.dataset.deadline).getTime();
                const tulis = () => {
                    const selisih = batas - Date.now();
                    if (selisih <= 0) {
                        sisa.textContent = 'Lewat batas';
                        return;
                    }
                    const hari = Math.floor(selisih / 86400000);
                    const jam = Math.floor((selisih % 86400000) / 3600000);
                    const menit = Math.floor((selisih % 3600000) / 60000);
                    sisa.textContent = hari + ' hari ' + jam + ' jam ' + menit + ' mnt';
                };
                tulis();
                setInterval(tulis, 60000);
            }
        })();
    </script>
</x-site-layout>
