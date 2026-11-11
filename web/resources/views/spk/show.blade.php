<x-site-layout judul="Lacak {{ $order->no_spk }}" robots="noindex, nofollow">
    <x-site-header />

    <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-8 sm:py-12 space-y-8">
        @if (session('sukses'))
            <div class="p-4 text-sm font-medium text-emerald-700 dark:text-emerald-300 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-700 dark:text-emerald-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('sukses') }}</span>
            </div>
        @endif

        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 pb-6 border-b border-line">
            <div>
                <p class="text-xs font-semibold tracking-wider text-accent uppercase">Status Surat Pesanan Kendaraan</p>
                <h1 class="mt-1 text-2xl sm:text-3xl font-extrabold text-ink tracking-tight flex items-center gap-2">
                    Lacak SPK <span class="font-mono text-accent">{{ $order->no_spk }}</span>
                </h1>
            </div>
            <a href="{{ route('lacak.form') }}" class="text-xs sm:text-sm font-medium text-muted hover:text-ink min-h-[44px] inline-flex items-center gap-1.5 transition-colors">
                <span>Lacak Nomor Lain</span>
            </a>
        </div>

        @php
            $statusTampil = $order->statusTampil();
            $warna = $order->unit->color;
            $namaUnit = trim(($order->unit->variant->carModel->brand->nama ?? '').' '.($order->unit->variant->carModel->nama ?? '').' '.$order->unit->variant->nama);
        @endphp

        <!-- Ringkasan Pesanan -->
        <div class="bg-surface border border-line rounded-3xl shadow-xl overflow-hidden">
            <div class="p-5 sm:p-6 grid grid-cols-1 sm:grid-cols-[10rem_minmax(0,1fr)_auto] gap-5 items-start">
                <div class="w-full aspect-[16/10] rounded-2xl overflow-hidden bg-surface-2">
                    @if ($order->unit->foto_utama)
                        <img src="{{ asset($order->unit->foto_utama) }}" alt="{{ $namaUnit }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-xs text-muted">Foto menyusul</div>
                    @endif
                </div>

                <div class="min-w-0">
                    <h2 class="text-xl sm:text-2xl font-extrabold text-ink tracking-tight">{{ $namaUnit }}</h2>
                    <p class="mt-1.5 flex items-center gap-2 text-xs text-muted">
                        <span class="w-3 h-3 rounded-full border border-line shrink-0" style="background: {{ $warna?->kode_hex ?: 'transparent' }}"></span>
                        <span>{{ $warna->nama ?? 'Warna menyusul' }}</span>
                    </p>
                    <p class="mt-2 text-xs text-muted">
                        No. pesanan <span class="font-mono font-semibold text-ink">{{ $order->no_spk }}</span> di Cabang {{ $order->branch->nama }}
                    </p>
                    <dl class="mt-3 flex flex-wrap gap-x-6 gap-y-1.5 text-xs">
                        <div class="flex gap-1.5">
                            <dt class="text-muted">VIN</dt>
                            <dd class="font-mono font-semibold text-ink break-all">{{ $order->unit->vin }}</dd>
                        </div>
                        <div class="flex gap-1.5">
                            <dt class="text-muted">Transmisi</dt>
                            <dd class="font-semibold text-ink">{{ $order->unit->variant->transmisi }}</dd>
                        </div>
                        <div class="flex gap-1.5">
                            <dt class="text-muted">Diajukan</dt>
                            <dd class="font-semibold text-ink tabular-nums">{{ $order->created_at->format('d M Y') }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="sm:text-right">
                    <x-status-badge :status="$statusTampil" />
                    <p class="mt-2 text-xl sm:text-2xl font-extrabold text-ink tabular-nums tracking-tight">Rp {{ number_format($order->unit->harga, 0, ',', '.') }}</p>
                    <p class="mt-0.5 text-xs text-muted tabular-nums">
                        @if ($order->metode === 'Kredit')
                            Kredit {{ $order->tenor }} bulan, DP Rp {{ number_format($order->dp_rencana, 0, ',', '.') }}
                        @else
                            {{ $order->metode }}
                        @endif
                    </p>
                </div>
            </div>

            @if ($order->jadwal_serah_at)
                <div class="px-5 sm:px-6 py-4 border-t border-line bg-surface-2 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <p class="text-sm text-muted leading-relaxed">
                        Unit siap diambil di Cabang {{ $order->branch->nama }} pada
                        <strong class="text-ink tabular-nums">{{ $order->jadwal_serah_at->format('d M Y') }}</strong>
                        pukul
                        <strong class="text-ink tabular-nums">{{ $order->jadwal_serah_at->format('H:i') }}</strong>.
                    </p>
                    @if ($order->branch->telp)
                        <a href="{{ \App\Support\Wa::chat($order->branch->telp, 'Halo '.$order->branch->nama.', saya ingin konfirmasi jadwal pengambilan unit untuk SPK '.$order->no_spk.'.') }}" target="_blank" rel="noopener"
                            class="px-4 py-2.5 text-center font-bold text-xs text-ink bg-surface border border-line hover:border-emerald-500/50 rounded-xl min-h-[44px] inline-flex items-center justify-center transition-colors">
                            Konfirmasi via WhatsApp
                        </a>
                    @endif
                </div>
            @endif
        </div>

        <!-- Tahapan dan Pembayaran -->
        @php
            $langkah = [
                ['label' => 'Pesanan dibuat', 'waktu' => $order->created_at, 'catatan' => 'SPK diterbitkan untuk unit pilihan Anda.'],
                ['label' => 'Pembayaran diverifikasi', 'waktu' => $order->verified_at, 'catatan' => 'Bukti transfer diperiksa admin cabang.'],
                ['label' => 'STNK dan BPKB selesai', 'waktu' => $order->stnk_selesai_at, 'catatan' => 'Dokumen kendaraan selesai diurus.'],
                ['label' => 'Unit siap serah terima', 'waktu' => $order->jadwal_serah_at, 'catatan' => 'Jadwal pengambilan unit di cabang.'],
                ['label' => 'Unit diserahkan', 'waktu' => $order->bast_at, 'catatan' => 'Berita acara serah terima ditandatangani.'],
            ];
            $langkahAktif = null;
            foreach ($langkah as $i => $l) {
                if (! $l['waktu']) {
                    $langkahAktif = $i;
                    break;
                }
            }
            $dihentikan = in_array($order->status, ['Batal', 'Expired', 'Ditolak'], true);
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-[1.05fr_1fr] gap-5">
            <section class="bg-surface border border-line rounded-3xl p-5 sm:p-6 shadow-xl" aria-labelledby="tahapan-pesanan">
                <h2 id="tahapan-pesanan" class="text-xs font-semibold uppercase tracking-wider text-muted">Tahapan Proses Pemesanan</h2>
                <ol class="mt-4">
                    @foreach ($langkah as $i => $l)
                        @php
                            $selesai = $l['waktu'] !== null;
                            $aktif = ! $selesai && $i === $langkahAktif && ! $dihentikan;
                        @endphp
                        <li class="flex gap-3">
                            <div class="flex flex-col items-center shrink-0">
                                <span class="w-3 h-3 rounded-full mt-1.5 {{ $selesai ? 'bg-accent-strong' : ($aktif ? 'bg-accent-strong ring-4 ring-accent-strong/20' : 'border-2 border-line bg-surface') }}"></span>
                                @unless ($loop->last)
                                    <span class="w-px flex-1 my-1 {{ $selesai ? 'bg-accent-strong/40' : 'bg-line' }}"></span>
                                @endunless
                            </div>
                            <div class="pb-4 min-w-0">
                                <p class="text-sm font-semibold {{ $selesai ? 'text-ink' : ($aktif ? 'text-accent' : 'text-muted') }}">{{ $l['label'] }}</p>
                                @if ($l['waktu'])
                                    <p class="text-xs text-muted tabular-nums mt-0.5">{{ $l['waktu']->format('d M Y, H:i') }} WIB</p>
                                @elseif ($aktif)
                                    <p class="text-xs text-muted mt-0.5">Tahap berikutnya</p>
                                @endif
                                <p class="text-[11px] text-muted mt-0.5 leading-relaxed">{{ $l['catatan'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ol>
                @if ($dihentikan)
                    <p class="pt-3 border-t border-line text-xs text-muted">Pesanan dihentikan dengan status {{ $statusTampil }}.</p>
                @endif
            </section>

            <section class="bg-surface border border-line rounded-3xl p-5 sm:p-6 shadow-xl" aria-labelledby="rincian-pembayaran">
                <h2 id="rincian-pembayaran" class="text-xs font-semibold uppercase tracking-wider text-muted">Rincian Pembayaran</h2>
                <dl class="mt-4 divide-y divide-line text-sm">
                    <div class="flex justify-between gap-3 py-2.5">
                        <dt class="text-muted">Harga unit</dt>
                        <dd class="font-semibold text-ink tabular-nums">Rp {{ number_format($order->unit->harga, 0, ',', '.') }}</dd>
                    </div>
                    <div class="flex justify-between gap-3 py-2.5">
                        <dt class="text-muted">Booking fee</dt>
                        <dd class="font-semibold text-ink tabular-nums">Rp {{ number_format($order->booking_fee, 0, ',', '.') }}</dd>
                    </div>
                    @if ($order->dp_rencana > 0)
                        <div class="flex justify-between gap-3 py-2.5">
                            <dt class="text-muted">Uang muka (DP)</dt>
                            <dd class="font-semibold text-ink tabular-nums">Rp {{ number_format($order->dp_rencana, 0, ',', '.') }}</dd>
                        </div>
                    @endif
                    @if ($order->metode === 'Kredit')
                        <div class="flex justify-between gap-3 py-2.5">
                            <dt class="text-muted">Angsuran estimasi</dt>
                            <dd class="font-semibold text-ink tabular-nums">{{ $order->angsuran_estimasi ? 'Rp '.number_format($order->angsuran_estimasi, 0, ',', '.').' / bulan' : '-' }}</dd>
                        </div>
                        <div class="flex justify-between gap-3 py-2.5">
                            <dt class="text-muted">Tenor</dt>
                            <dd class="font-semibold text-ink">{{ $order->tenor ? $order->tenor.' bulan' : '-' }}</dd>
                        </div>
                        <div class="flex justify-between gap-3 py-2.5">
                            <dt class="text-muted">Leasing</dt>
                            <dd class="font-semibold text-ink text-right">{{ $order->leasing->nama ?? '-' }}</dd>
                        </div>
                    @endif
                    <div class="flex justify-between gap-3 py-2.5">
                        <dt class="text-muted">Metode</dt>
                        <dd class="font-semibold text-ink">{{ $order->metode }}</dd>
                    </div>
                    <div class="flex justify-between gap-3 py-2.5">
                        <dt class="text-muted">Status pelunasan</dt>
                        <dd class="text-right">
                            @if ($order->invoice?->lunas_at)
                                <span class="font-semibold text-emerald-700 dark:text-emerald-300 tabular-nums">Lunas {{ $order->invoice->lunas_at->format('d M Y') }}</span>
                            @elseif ($order->invoice)
                                <span class="font-semibold text-ink">Belum lunas</span>
                            @else
                                <span class="text-muted">Invoice belum terbit</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </section>
        </div>

        <!-- Payment & Verification Action Panel -->
        @if ($order->status === 'MenungguBayar')
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Payment Instructions -->
                <div class="p-6 bg-surface border border-line rounded-3xl shadow-xl space-y-4">
                    <p class="text-xs font-semibold tracking-wider text-accent uppercase">Instruksi Pembayaran</p>
                    <h2 class="font-bold text-lg text-ink">Transfer Tanda Jadi (Booking Fee)</h2>
                    <p class="text-3xl font-extrabold text-ink tabular-nums tracking-tight">Rp {{ number_format($order->booking_fee, 0, ',', '.') }}</p>
                    
                    <div class="space-y-2 pt-2">
                        @foreach ($order->branch->bankAccounts->where('aktif', true) as $rek)
                            <div class="flex items-center justify-between gap-3 bg-surface border border-line rounded-xl px-4 py-3">
                                <div>
                                    <p class="text-xs text-muted">{{ $rek->bank }}</p>
                                    <p class="font-mono font-bold text-ink text-sm">{{ $rek->no_rek }}</p>
                                    <p class="text-[11px] text-muted">a.n. {{ $rek->atas_nama }}</p>
                                </div>
                                <button type="button" data-salin="{{ $rek->no_rek }}" 
                                    class="text-xs font-bold text-ink bg-line hover:bg-line px-3 py-1.5 rounded-lg min-h-[36px] transition-colors">
                                    Salin
                                </button>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 pt-4 border-t border-line space-y-1">
                        <p class="text-xs font-semibold text-accent">Batas Waktu Bayar: {{ $order->deadline_at->format('d M Y H:i') }} WIB</p>
                        <p class="text-xs text-muted">Sisa waktu: <span id="sisa-bayar" data-deadline="{{ $order->deadline_at->toIso8601String() }}" class="font-bold text-ink tabular-nums">-</span></p>
                        <p class="text-[11px] text-muted leading-relaxed pt-1">Jika melewati batas waktu pembayaran, SPK akan otomatis kedaluwarsa (Expired) dan alokasi unit dilepas kembali ke katalog.</p>
                    </div>
                </div>

                <!-- Proof of Payment Upload -->
                <div class="p-6 bg-surface border border-line rounded-3xl shadow-xl flex flex-col justify-between">
                    <div>
                        <h2 class="font-bold text-lg text-ink">Unggah Bukti Transfer</h2>
                        <p class="mt-1 text-xs text-muted">Format file yang didukung: JPG, PNG, atau PDF (Maksimal 2 MB).</p>

                        @auth
                            @if ($order->customer->user_id !== null && $order->customer->user_id !== auth()->id())
                                <p class="mt-4 p-4 text-xs font-medium text-amber-700 dark:text-amber-300 bg-amber-500/10 border border-amber-500/20 rounded-2xl">
                                    SPK ini terdaftar atas akun lain. Masuk dengan akun pembuat SPK untuk mengunggah bukti bayar.
                                </p>
                            @else
                                <form action="{{ route('spk.upload', $order->no_spk) }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4">
                                    @csrf
                                    <div>
                                        <label for="bukti" class="block text-xs font-semibold uppercase tracking-wider text-muted">File Bukti Struk / Mutasi</label>
                                        <div class="mt-2 p-4 bg-surface border border-line rounded-2xl">
                                            <input id="bukti" type="file" name="bukti" required accept=".jpg,.jpeg,.png,.pdf" 
                                                class="w-full text-xs text-muted file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-accent-strong file:text-white hover:file:bg-[#9E0E19] cursor-pointer">
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->all()" class="text-accent text-xs" />
                                    <button type="submit" 
                                        class="w-full py-3.5 px-6 font-bold text-sm text-white bg-accent-strong hover:bg-[#9E0E19] rounded-xl shadow-lg shadow-accent/25 transition-all min-h-[48px] flex items-center justify-center">
                                        Kirim Bukti Pembayaran
                                    </button>
                                </form>
                            @endif
                        @else
                            <div class="mt-6 p-6 bg-surface border border-line rounded-2xl text-center">
                                <p class="text-sm text-muted">Silakan masuk ke akun Anda terlebih dahulu untuk mengunggah bukti bayar.</p>
                                <a href="{{ route('login') }}" class="mt-4 inline-flex items-center px-5 py-2.5 text-xs font-bold text-white bg-accent-strong rounded-xl">
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
                <div class="w-10 h-10 rounded-full bg-amber-500/20 flex items-center justify-center text-amber-700 dark:text-amber-300 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-ink text-base">Bukti Pembayaran Sedang Diverifikasi</h3>
                    <p class="text-xs text-amber-300/80 mt-0.5">Admin cabang sedang memeriksa validitas transaksi Anda. Notifikasi akan diperbarui segera.</p>
                </div>
            </div>
        @endif

        @if ($order->status === 'Deal')
            <div class="p-6 bg-emerald-500/10 border border-emerald-500/20 rounded-3xl space-y-3">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-700 dark:text-emerald-300"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span>
                    <h2 class="text-lg font-bold text-ink">Status SPK Telah Dikonfirmasi (Deal)</h2>
                </div>
                <p class="text-xs sm:text-sm text-muted">Unit fisik nomor rangka telah terkunci untuk pesanan Anda. Pelunasan sisa tagihan dilakukan di dealer resmi sebelum serah terima.</p>
                @if ($order->invoice)
                    <div class="mt-4 pt-3 border-t border-emerald-500/20 flex items-center justify-between text-xs sm:text-sm">
                        <span class="text-muted">Nomor Invoice Resmi: <strong class="font-mono text-ink">{{ $order->invoice->no_inv }}</strong></span>
                        @auth
                            <a href="{{ route('invoice.download', $order->invoice) }}" class="font-bold text-emerald-700 dark:text-emerald-300 hover:text-emerald-300 underline">Unduh Invoice PDF</a>
                        @else
                            <span class="text-muted">(Minta salinan ke admin cabang)</span>
                        @endauth
                    </div>
                @endif
            </div>

            @if (auth()->user()?->hasAnyRole(['admin-cabang', 'sales', 'pimpinan', 'superadmin', 'owner']))
                <div class="p-6 bg-surface border border-line rounded-3xl">
                    @if ($order->bast_path)
                        <p class="text-xs text-emerald-700 dark:text-emerald-300 font-semibold flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Dokumen BAST serah terima unit sudah diunggah.</p>
                    @else
                        <form action="{{ route('admin.orders.bast', $order) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                            @csrf @method('PATCH')
                            <label for="bast" class="block text-xs font-semibold uppercase tracking-wider text-muted">Upload Berita Acara Serah Terima (BAST)</label>
                            <input id="bast" type="file" name="bast" required accept=".jpg,.jpeg,.png,.pdf" 
                                class="w-full text-xs text-muted file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-accent-strong file:text-white cursor-pointer">
                            <button class="w-full py-2.5 px-4 font-bold text-xs text-white bg-accent-strong rounded-xl">Unggah BAST</button>
                        </form>
                    @endif
                </div>
            @endif
        @endif

        @if ($order->tolak_alasan)
            <div class="p-4 text-xs font-medium text-accent bg-rose-500/10 border border-rose-500/20 rounded-2xl">
                Catatan Penolakan: {{ $order->tolak_alasan }}
            </div>
        @endif

        @if (in_array($order->status, ['Expired', 'Batal', 'Ditolak']))
            <div class="p-6 bg-surface border border-line rounded-2xl text-center">
                <p class="text-sm text-muted">Unit fisik telah dilepaskan dari pesanan ini. Anda dapat memilih kembali unit yang tersedia di katalog dealer.</p>
                <a href="{{ route('katalog.index') }}" class="mt-4 inline-flex items-center px-5 py-2.5 text-xs font-bold text-white bg-accent-strong rounded-xl">
                    Buka Katalog Mobil
                </a>
            </div>
        @endif

        @if ($order->branch->telp)
            <div class="p-6 bg-surface border border-line rounded-3xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-sm font-bold text-ink">Butuh Bantuan Langsung Mengenai SPK Ini?</h3>
                    <p class="text-xs text-muted mt-0.5">Hubungi customer service cabang {{ $order->branch->nama }} melalui WhatsApp.</p>
                </div>
                <a href="{{ \App\Support\Wa::chat($order->branch->telp, 'Halo '.$order->branch->nama.', saya ingin konfirmasi mengenai SPK '.$order->no_spk.'.') }}" target="_blank" rel="noopener" 
                    class="px-6 py-3 text-center font-bold text-xs text-ink bg-surface border border-line hover:border-emerald-500/50 hover:text-emerald-700 dark:text-emerald-300 rounded-xl min-h-[44px] inline-flex items-center justify-center gap-2 transition-colors">
                    <span>Chat WhatsApp Cabang</span>
                    <svg class="w-4 h-4 text-emerald-700 dark:text-emerald-300" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.174.086.275.072.376-.044.101-.116.433-.506.549-.68.116-.173.231-.144.39-.086s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824z"/></svg>
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
