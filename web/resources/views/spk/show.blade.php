<x-site-layout judul="Lacak {{ $order->no_spk }}" robots="noindex, nofollow">
    <x-site-header />

    <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-8 sm:py-12 space-y-8">
        @if (session('sukses'))
            <div class="p-4 text-sm font-medium text-emerald-700 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('sukses') }}</span>
            </div>
        @endif

        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 pb-6 border-b border-[#E5E7EB]">
            <div>
                <p class="text-xs font-semibold tracking-wider text-[#C1121F] uppercase">Status Surat Pesanan Kendaraan</p>
                <h1 class="mt-1 text-2xl sm:text-3xl font-extrabold text-[#16181D] tracking-tight flex items-center gap-2">
                    Lacak SPK <span class="font-mono text-[#C1121F]">{{ $order->no_spk }}</span>
                </h1>
            </div>
            <a href="{{ route('lacak.form') }}" class="text-xs sm:text-sm font-medium text-[#4B5563] hover:text-[#16181D] min-h-[44px] inline-flex items-center gap-1.5 transition-colors">
                <span>Lacak Nomor Lain</span>
            </a>
        </div>

        <!-- 4 Stat Summary Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-2xl p-4">
                <p class="text-[10px] uppercase tracking-wider text-[#4B5563] font-medium">Nomor SPK</p>
                <p class="mt-1 text-sm font-bold font-mono text-[#16181D]">{{ $order->no_spk }}</p>
            </div>
            <div class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-2xl p-4">
                <p class="text-[10px] uppercase tracking-wider text-[#4B5563] font-medium">Waktu Pengajuan</p>
                <p class="mt-1 text-sm font-bold text-[#16181D]">{{ $order->created_at->format('d M Y H:i') }}</p>
            </div>
            <div class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-2xl p-4">
                <p class="text-[10px] uppercase tracking-wider text-[#4B5563] font-medium">Cabang Pengiriman</p>
                <p class="mt-1 text-sm font-bold text-[#16181D] truncate">{{ $order->branch->nama }}</p>
            </div>
            <div class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-2xl p-4 flex flex-col justify-between">
                <p class="text-[10px] uppercase tracking-wider text-[#4B5563] font-medium">Status Transaksi</p>
                <div class="mt-1"><x-status-badge status="{{ $order->statusTampil() }}" /></div>
            </div>
        </div>

        <!-- Unit Overview -->
        <div class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-3xl p-6 grid grid-cols-1 sm:grid-cols-2 gap-6 items-center shadow-xl">
            <div class="overflow-hidden rounded-2xl bg-[#FFFFFF]">
                @if ($order->unit->foto_utama)
                    <img src="{{ asset($order->unit->foto_utama) }}" alt="{{ $order->unit->variant->carModel->brand->nama }} {{ $order->unit->variant->carModel->nama }} {{ $order->unit->variant->nama }}" class="w-full aspect-video object-cover">
                @else
                    <div class="w-full aspect-video bg-[#FFFFFF] flex items-center justify-center text-sm text-gray-500">Foto menyusul</div>
                @endif
            </div>
            <div>
                <p class="text-xs font-semibold text-[#C1121F] uppercase tracking-wider">{{ $order->unit->variant->carModel->brand->nama }} {{ $order->unit->variant->carModel->nama }}</p>
                <h2 class="mt-1 text-2xl font-bold text-[#16181D]">{{ $order->unit->variant->nama }}</h2>

                <dl class="mt-4 space-y-2 text-xs sm:text-sm">
                    <div class="flex justify-between py-1.5 border-b border-[#E5E7EB]">
                        <dt class="text-[#4B5563]">Pilihan Warna Fisik</dt>
                        <dd class="font-semibold text-[#16181D]">{{ $order->unit->color->nama }}</dd>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-[#E5E7EB]">
                        <dt class="text-[#4B5563]">Nomor Rangka (VIN)</dt>
                        <dd class="font-mono font-semibold text-[#C1121F] break-all">{{ $order->unit->vin }}</dd>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-[#E5E7EB]">
                        <dt class="text-[#4B5563]">Transmisi</dt>
                        <dd class="font-semibold text-[#16181D]">{{ $order->unit->variant->transmisi }}</dd>
                    </div>
                    <div class="flex justify-between py-1.5">
                        <dt class="text-[#4B5563]">Harga OTR Kendaraan</dt>
                        <dd class="font-extrabold text-[#16181D] tabular-nums">Rp {{ number_format($order->unit->harga, 0, ',', '.') }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Progress Timeline -->
        @php
            $alur = ['MenungguBayar' => 'SPK Diterbitkan', 'MenungguVerifikasi' => 'Bukti Diunggah', 'Deal' => 'Terverifikasi (Deal)', 'Lunas' => 'Pelunasan Diterima'];
            $statusTampil = $order->statusTampil();
            $posisi = array_search($statusTampil, array_keys($alur), true);
        @endphp
        <div class="space-y-4">
            <h2 class="text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Tahapan Proses Pemesanan</h2>
            <ol class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                @foreach ($alur as $kode => $label)
                    @php
                        $lewat = $posisi !== false && array_search($kode, array_keys($alur), true) < $posisi;
                        $aktif = $posisi !== false && $kode === $statusTampil;
                    @endphp
                    <li class="border rounded-2xl p-4 transition-all {{ $aktif ? 'border-[#C1121F] bg-[#C1121F]/10 shadow-lg shadow-[#C1121F]/5' : ($lewat ? 'border-emerald-500/30 bg-emerald-500/10' : 'border-[#E5E7EB] bg-[#FFFFFF]') }}">
                        <p class="text-sm font-bold {{ $aktif ? 'text-[#C1121F]' : ($lewat ? 'text-emerald-700' : 'text-[#4B5563]') }}">{{ $label }}</p>
                        <p class="mt-1 text-xs text-[#4B5563]">{{ $aktif ? 'Tahap Aktif Saat Ini' : ($lewat ? 'Selesai Terverifikasi' : 'Tahap Selanjutnya') }}</p>
                    </li>
                @endforeach
            </ol>
        </div>

        <!-- Payment & Verification Action Panel -->
        @if ($order->status === 'MenungguBayar')
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Payment Instructions -->
                <div class="p-6 bg-[#FFFFFF] border border-[#E5E7EB] rounded-3xl shadow-xl space-y-4">
                    <p class="text-xs font-semibold tracking-wider text-[#C1121F] uppercase">Instruksi Pembayaran</p>
                    <h2 class="font-bold text-lg text-[#16181D]">Transfer Tanda Jadi (Booking Fee)</h2>
                    <p class="text-3xl font-extrabold text-[#16181D] tabular-nums tracking-tight">Rp {{ number_format($order->booking_fee, 0, ',', '.') }}</p>
                    
                    <div class="space-y-2 pt-2">
                        @foreach ($order->branch->bankAccounts->where('aktif', true) as $rek)
                            <div class="flex items-center justify-between gap-3 bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl px-4 py-3">
                                <div>
                                    <p class="text-xs text-[#4B5563]">{{ $rek->bank }}</p>
                                    <p class="font-mono font-bold text-[#16181D] text-sm">{{ $rek->no_rek }}</p>
                                    <p class="text-[11px] text-[#4B5563]">a.n. {{ $rek->atas_nama }}</p>
                                </div>
                                <button type="button" data-salin="{{ $rek->no_rek }}" 
                                    class="text-xs font-bold text-[#16181D] bg-[#E5E7EB] hover:bg-[#E5E7EB] px-3 py-1.5 rounded-lg min-h-[36px] transition-colors">
                                    Salin
                                </button>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 pt-4 border-t border-[#E5E7EB] space-y-1">
                        <p class="text-xs font-semibold text-[#C1121F]">Batas Waktu Bayar: {{ $order->deadline_at->format('d M Y H:i') }} WIB</p>
                        <p class="text-xs text-[#4B5563]">Sisa waktu: <span id="sisa-bayar" data-deadline="{{ $order->deadline_at->toIso8601String() }}" class="font-bold text-[#16181D] tabular-nums">-</span></p>
                        <p class="text-[11px] text-gray-500 leading-relaxed pt-1">Jika melewati batas waktu pembayaran, SPK akan otomatis kedaluwarsa (Expired) dan alokasi unit dilepas kembali ke katalog.</p>
                    </div>
                </div>

                <!-- Proof of Payment Upload -->
                <div class="p-6 bg-[#FFFFFF] border border-[#E5E7EB] rounded-3xl shadow-xl flex flex-col justify-between">
                    <div>
                        <h2 class="font-bold text-lg text-[#16181D]">Unggah Bukti Transfer</h2>
                        <p class="mt-1 text-xs text-[#4B5563]">Format file yang didukung: JPG, PNG, atau PDF (Maksimal 2 MB).</p>

                        @auth
                            @if ($order->customer->user_id !== null && $order->customer->user_id !== auth()->id())
                                <p class="mt-4 p-4 text-xs font-medium text-amber-700 bg-amber-500/10 border border-amber-500/20 rounded-2xl">
                                    SPK ini terdaftar atas akun lain. Masuk dengan akun pembuat SPK untuk mengunggah bukti bayar.
                                </p>
                            @else
                                <form action="{{ route('spk.upload', $order->no_spk) }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4">
                                    @csrf
                                    <div>
                                        <label for="bukti" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">File Bukti Struk / Mutasi</label>
                                        <div class="mt-2 p-4 bg-[#FFFFFF] border border-[#E5E7EB] rounded-2xl">
                                            <input id="bukti" type="file" name="bukti" required accept=".jpg,.jpeg,.png,.pdf" 
                                                class="w-full text-xs text-[#4B5563] file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#C1121F] file:text-white hover:file:bg-[#9E0E19] cursor-pointer">
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->all()" class="text-[#C1121F] text-xs" />
                                    <button type="submit" 
                                        class="w-full py-3.5 px-6 font-bold text-sm text-white bg-[#C1121F] hover:bg-[#9E0E19] rounded-xl shadow-lg shadow-[#C1121F]/25 transition-all min-h-[48px] flex items-center justify-center">
                                        Kirim Bukti Pembayaran
                                    </button>
                                </form>
                            @endif
                        @else
                            <div class="mt-6 p-6 bg-[#FFFFFF] border border-[#E5E7EB] rounded-2xl text-center">
                                <p class="text-sm text-[#4B5563]">Silakan masuk ke akun Anda terlebih dahulu untuk mengunggah bukti bayar.</p>
                                <a href="{{ route('login') }}" class="mt-4 inline-flex items-center px-5 py-2.5 text-xs font-bold text-white bg-[#C1121F] rounded-xl">
                                    Masuk Akun
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        @endif

        @if ($order->status === 'MenungguVerifikasi')
            <div class="p-6 bg-amber-500/10 border border-amber-500/20 rounded-3xl flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-amber-500/20 flex items-center justify-center text-amber-700 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-[#16181D] text-base">Bukti Pembayaran Sedang Diverifikasi</h3>
                    <p class="text-xs text-amber-300/80 mt-0.5">Admin cabang sedang memeriksa validitas transaksi Anda. Notifikasi akan diperbarui segera.</p>
                </div>
            </div>
        @endif

        @if ($order->status === 'Deal')
            <div class="p-6 bg-emerald-500/10 border border-emerald-500/20 rounded-3xl space-y-3">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-700"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span>
                    <h2 class="text-lg font-bold text-[#16181D]">Status SPK Telah Dikonfirmasi (Deal)</h2>
                </div>
                <p class="text-xs sm:text-sm text-[#4B5563]">Unit fisik nomor rangka telah terkunci untuk pesanan Anda. Pelunasan sisa tagihan dilakukan di dealer resmi sebelum serah terima.</p>
                @if ($order->invoice)
                    <div class="mt-4 pt-3 border-t border-emerald-500/20 flex items-center justify-between text-xs sm:text-sm">
                        <span class="text-[#4B5563]">Nomor Invoice Resmi: <strong class="font-mono text-[#16181D]">{{ $order->invoice->no_inv }}</strong></span>
                        @auth
                            <a href="{{ route('invoice.download', $order->invoice) }}" class="font-bold text-emerald-700 hover:text-emerald-300 underline">Unduh Invoice PDF</a>
                        @else
                            <span class="text-gray-500">(Minta salinan ke admin cabang)</span>
                        @endauth
                    </div>
                @endif
            </div>

            @if (auth()->user()?->hasAnyRole(['admin-cabang', 'sales', 'pimpinan', 'superadmin', 'owner']))
                <div class="p-6 bg-[#FFFFFF] border border-[#E5E7EB] rounded-3xl">
                    @if ($order->bast_path)
                        <p class="text-xs text-emerald-700 font-semibold flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Dokumen BAST serah terima unit sudah diunggah.</p>
                    @else
                        <form action="{{ route('admin.orders.bast', $order) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                            @csrf @method('PATCH')
                            <label for="bast" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Upload Berita Acara Serah Terima (BAST)</label>
                            <input id="bast" type="file" name="bast" required accept=".jpg,.jpeg,.png,.pdf" 
                                class="w-full text-xs text-[#4B5563] file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-[#C1121F] file:text-white cursor-pointer">
                            <button class="w-full py-2.5 px-4 font-bold text-xs text-white bg-[#C1121F] rounded-xl">Unggah BAST</button>
                        </form>
                    @endif
                </div>
            @endif
        @endif

        @if ($order->tolak_alasan)
            <div class="p-4 text-xs font-medium text-[#C1121F] bg-rose-500/10 border border-rose-500/20 rounded-2xl">
                Catatan Penolakan: {{ $order->tolak_alasan }}
            </div>
        @endif

        @if (in_array($order->status, ['Expired', 'Batal', 'Ditolak']))
            <div class="p-6 bg-[#FFFFFF] border border-[#E5E7EB] rounded-2xl text-center">
                <p class="text-sm text-[#4B5563]">Unit fisik telah dilepaskan dari pesanan ini. Anda dapat memilih kembali unit yang tersedia di katalog dealer.</p>
                <a href="{{ route('katalog.index') }}" class="mt-4 inline-flex items-center px-5 py-2.5 text-xs font-bold text-white bg-[#C1121F] rounded-xl">
                    Buka Katalog Mobil
                </a>
            </div>
        @endif

        @if ($order->branch->telp)
            <div class="p-6 bg-[#FFFFFF] border border-[#E5E7EB] rounded-3xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-sm font-bold text-[#16181D]">Butuh Bantuan Langsung Mengenai SPK Ini?</h3>
                    <p class="text-xs text-[#4B5563] mt-0.5">Hubungi customer service cabang {{ $order->branch->nama }} melalui WhatsApp.</p>
                </div>
                <a href="{{ \App\Support\Wa::chat($order->branch->telp, 'Halo '.$order->branch->nama.', saya ingin konfirmasi mengenai SPK '.$order->no_spk.'.') }}" target="_blank" rel="noopener" 
                    class="px-6 py-3 text-center font-bold text-xs text-[#16181D] bg-[#FFFFFF] border border-[#E5E7EB] hover:border-emerald-500/50 hover:text-emerald-700 rounded-xl min-h-[44px] inline-flex items-center justify-center gap-2 transition-colors">
                    <span>Chat WhatsApp Cabang</span>
                    <svg class="w-4 h-4 text-emerald-700" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.174.086.275.072.376-.044.101-.116.433-.506.549-.68.116-.173.231-.144.39-.086s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824z"/></svg>
                </a>
            </div>
        @endif
    </div>

    <x-site-footer />

    <script>
        (function () {
            document.querySelectorAll('[data-salin]').forEach((btn) => {
                btn.addEventListener('click', async () => {
                    try {
                        await navigator.clipboard.writeText(btn.dataset.salin);
                        const awal = btn.textContent;
                        btn.textContent = 'Tersalin!';
                        setTimeout(() => { btn.textContent = awal; }, 1500);
                    } catch (e) {
                        btn.textContent = 'Gagal';
                    }
                });
            });
            const sisa = document.getElementById('sisa-bayar');
            if (sisa) {
                const batas = new Date(sisa.dataset.deadline).getTime();
                const tulis = () => {
                    const selisih = batas - Date.now();
                    if (selisih <= 0) {
                        sisa.textContent = 'Batas Waktu Berakhir';
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
