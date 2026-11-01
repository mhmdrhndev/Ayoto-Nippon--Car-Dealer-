<x-site-layout judul="Pesanan Saya" robots="noindex, nofollow" deskripsi="Riwayat SPK, test drive, servis, trade-in, dan order sparepart Anda di Ayoto Nippon.">
    <x-site-header />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold text-[#16181D]">Pesanan Saya</h1>
        <p class="mt-1 text-sm text-[#4B5563]">Semua pengajuan Anda dalam satu halaman.</p>

        <section aria-labelledby="riwayat-spk" class="mt-6 bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200">
                <h2 id="riwayat-spk" class="font-bold text-[#16181D]">SPK</h2>
                <p class="text-xs text-gray-500">Surat pemesanan kendaraan Anda.</p>
            </div>
            @forelse ($spks as $order)
                <div class="px-4 py-3 border-b last:border-0 flex flex-wrap items-center gap-2">
                    <a href="{{ route('spk.show', $order->no_spk) }}" class="font-mono font-semibold text-[#16181D] underline min-h-[44px] inline-flex items-center">{{ $order->no_spk }}</a>
                    <span class="text-sm text-gray-500">{{ $order->unit->variant->carModel->brand->nama ?? '' }} {{ $order->unit->variant->carModel->nama ?? '' }} • {{ $order->branch->nama }}</span>
                    <span class="ml-auto"><x-status-badge :status="$order->status" /></span>
                </div>
            @empty
                <p class="px-4 py-6 text-sm text-gray-500">Belum ada SPK. <a href="{{ route('katalog.index') }}" class="font-semibold text-[#C1121F] underline">Lihat katalog</a></p>
            @endforelse
        </section>

        <section aria-labelledby="riwayat-td" class="mt-4 bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200">
                <h2 id="riwayat-td" class="font-bold text-[#16181D]">Test Drive</h2>
                <p class="text-xs text-gray-500">Batalkan atau ajukan jadwal baru selama belum diproses final.</p>
            </div>
            @forelse ($testDrives as $td)
                <div class="px-4 py-3 border-b last:border-0">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="font-semibold text-[#16181D]">{{ $td->variant->carModel->brand->nama }} {{ $td->variant->carModel->nama }} {{ $td->variant->nama }}</span>
                        <span class="text-sm text-gray-500 tabular-nums">{{ $td->jadwal->format('d M Y H:i') }} • {{ $td->branch->nama }}</span>
                        <span class="ml-auto"><x-status-badge :status="$td->status" /></span>
                    </div>
                    @if (in_array($td->status, ['Menunggu', 'Dikonfirmasi'], true))
                        <div class="mt-2 flex flex-wrap items-center gap-2">
                            <form action="{{ route('pesanan.test-drive.jadwal', $td) }}" method="POST" class="flex flex-wrap items-center gap-2">
                                @csrf @method('PATCH')
                                <label for="jadwal-td-{{ $td->id }}" class="text-xs text-gray-500">Jadwal baru</label>
                                <input id="jadwal-td-{{ $td->id }}" type="datetime-local" name="jadwal" required class="rounded-lg border-gray-300 text-sm min-h-[44px]">
                                <button type="submit" class="px-4 py-2 text-sm font-semibold text-[#16181D] border border-gray-300 rounded-lg min-h-[44px]">Ajukan Ulang</button>
                            </form>
                            <form action="{{ route('pesanan.test-drive.batal', $td) }}" method="POST" onsubmit="return confirm('Batalkan test drive ini?')">
                                @csrf @method('PATCH')
                                <button type="submit" class="px-4 py-2 text-sm font-semibold text-[#C1121F] border border-gray-300 rounded-lg min-h-[44px]">Batalkan</button>
                            </form>
                        </div>
                    @endif
                </div>
            @empty
                <p class="px-4 py-6 text-sm text-gray-500">Belum ada test drive. <a href="{{ route('test-drive.create') }}" class="font-semibold text-[#C1121F] underline">Booking sekarang</a></p>
            @endforelse
        </section>

        <section aria-labelledby="riwayat-svc" class="mt-4 bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200">
                <h2 id="riwayat-svc" class="font-bold text-[#16181D]">Servis</h2>
                <p class="text-xs text-gray-500">Batalkan atau ajukan jadwal baru selama belum dikerjakan.</p>
            </div>
            @forelse ($servis as $svc)
                <div class="px-4 py-3 border-b last:border-0">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="font-mono font-semibold text-[#16181D]">{{ $svc->no_svc }}</span>
                        <span class="text-sm text-gray-500 font-mono">{{ $svc->nopol }}</span>
                        <span class="text-sm text-gray-500 tabular-nums">{{ $svc->jadwal->format('d M Y H:i') }} • {{ $svc->branch->nama }}</span>
                        <span class="ml-auto flex items-center gap-2">
                            @if ($svc->status === 'Selesai')
                                <a href="{{ route('servis.invoice', $svc) }}" class="text-xs font-semibold text-[#16181D] underline min-h-[44px] inline-flex items-center">Unduh Invoice</a>
                            @endif
                            <x-status-badge :status="$svc->status" />
                        </span>
                    </div>
                    @if (in_array($svc->status, ['Menunggu', 'Dikonfirmasi'], true))
                        <div class="mt-2 flex flex-wrap items-center gap-2">
                            <form action="{{ route('pesanan.servis.jadwal', $svc) }}" method="POST" class="flex flex-wrap items-center gap-2">
                                @csrf @method('PATCH')
                                <label for="jadwal-svc-{{ $svc->id }}" class="text-xs text-gray-500">Jadwal baru</label>
                                <input id="jadwal-svc-{{ $svc->id }}" type="datetime-local" name="jadwal" required class="rounded-lg border-gray-300 text-sm min-h-[44px]">
                                <button type="submit" class="px-4 py-2 text-sm font-semibold text-[#16181D] border border-gray-300 rounded-lg min-h-[44px]">Ajukan Ulang</button>
                            </form>
                            <form action="{{ route('pesanan.servis.batal', $svc) }}" method="POST" onsubmit="return confirm('Batalkan booking servis ini?')">
                                @csrf @method('PATCH')
                                <button type="submit" class="px-4 py-2 text-sm font-semibold text-[#C1121F] border border-gray-300 rounded-lg min-h-[44px]">Batalkan</button>
                            </form>
                        </div>
                    @endif
                </div>
            @empty
                <p class="px-4 py-6 text-sm text-gray-500">Belum ada booking servis. <a href="{{ route('servis.create') }}" class="font-semibold text-[#C1121F] underline">Booking sekarang</a></p>
            @endforelse
        </section>

        <section aria-labelledby="riwayat-ti" class="mt-4 bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200">
                <h2 id="riwayat-ti" class="font-bold text-[#16181D]">Trade-In</h2>
                <p class="text-xs text-gray-500">Penawaran tukar tambah dari tim inspeksi.</p>
            </div>
            @forelse ($tradeIns as $ti)
                <div class="px-4 py-3 border-b last:border-0 flex flex-wrap items-center gap-2">
                    <span class="font-semibold text-[#16181D]">{{ $ti->merk_tipe }} ({{ $ti->tahun }})</span>
                    @if ($ti->harga_penawaran)
                        <span class="text-sm font-semibold text-[#16181D] tabular-nums">Ditawar Rp {{ number_format($ti->harga_penawaran, 0, ',', '.') }}</span>
                    @endif
                    <span class="ml-auto"><x-status-badge :status="$ti->status" /></span>
                </div>
            @empty
                <p class="px-4 py-6 text-sm text-gray-500">Belum ada pengajuan. <a href="{{ route('trade-in.create') }}" class="font-semibold text-[#C1121F] underline">Ajukan trade-in</a></p>
            @endforelse
        </section>

        <section aria-labelledby="riwayat-spo" class="mt-4 bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200">
                <h2 id="riwayat-spo" class="font-bold text-[#16181D]">Order Sparepart</h2>
                <p class="text-xs text-gray-500">Bayar sebelum batas waktu agar order tidak kedaluwarsa.</p>
            </div>
            @forelse ($spos as $spo)
                <div class="px-4 py-3 border-b last:border-0 flex flex-wrap items-center gap-2">
                    <a href="{{ route('sparepart.order.show', $spo->no_spo) }}" class="font-mono font-semibold text-[#16181D] underline min-h-[44px] inline-flex items-center">{{ $spo->no_spo }}</a>
                    <span class="text-sm text-gray-500 tabular-nums">Rp {{ number_format($spo->total, 0, ',', '.') }} • {{ $spo->branch->nama }}</span>
                    <span class="ml-auto"><x-status-badge :status="$spo->status" /></span>
                </div>
            @empty
                <p class="px-4 py-6 text-sm text-gray-500">Belum ada order. <a href="{{ route('sparepart.index') }}" class="font-semibold text-[#C1121F] underline">Lihat sparepart</a></p>
            @endforelse
        </section>
    </div>

    <x-site-footer />
</x-site-layout>
