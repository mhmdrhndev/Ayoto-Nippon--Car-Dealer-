<x-site-layout judul="Pesanan Saya" robots="noindex, nofollow" deskripsi="Riwayat SPK, test drive, servis, trade-in, dan order sparepart Anda di Ayoto Nippon.">
    <x-site-header />

    <div class="w-full px-4 sm:px-6 lg:px-8 py-10 space-y-10">
        <div class="pb-6 border-b border-[#E5E7EB]">
            <p class="text-xs font-semibold tracking-wider text-[#C1121F] uppercase">Pusat Aktivitas Akun</p>
            <h1 class="mt-1 text-3xl sm:text-4xl font-extrabold text-[#16181D] tracking-tight">Riwayat & Pesanan Saya</h1>
            <p class="mt-2 text-sm text-[#4B5563]">
                Pantau seluruh pengajuan unit kendaraan, pemesanan suku cadang, dan jadwal layanan bengkel Anda.
            </p>
        </div>

        <!-- Section 1: SPK -->
        <section aria-labelledby="riwayat-spk" class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-3xl overflow-hidden shadow-xl">
            <div class="px-6 py-4 bg-[#FFFFFF] border-b border-[#E5E7EB] flex items-center justify-between">
                <div>
                    <h2 id="riwayat-spk" class="font-bold text-base text-[#16181D]">Surat Pesanan Kendaraan (SPK)</h2>
                    <p class="text-xs text-[#4B5563]">Daftar pemesanan unit baru dan status alokasi nomor rangka.</p>
                </div>
            </div>
            <div class="divide-y divide-[#E5E7EB]">
                @forelse ($spks as $order)
                    <div class="px-6 py-4 flex flex-wrap items-center justify-between gap-3 hover:bg-[#F9FAFB] transition-colors">
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                            <a href="{{ route('spk.show', $order->no_spk) }}" class="font-mono font-bold text-sm text-[#C1121F] hover:text-[#C1121F] underline underline-offset-2 min-h-[44px] inline-flex items-center">
                                {{ $order->no_spk }}
                            </a>
                            <span class="text-xs sm:text-sm text-[#4B5563]">
                                {{ $order->unit->variant->carModel->brand->nama ?? '' }} {{ $order->unit->variant->carModel->nama ?? '' }} {{ $order->unit->variant->nama ?? '' }}
                                <span class="text-gray-500">•</span>
                                <span class="text-[#4B5563]">{{ $order->branch->nama }}</span>
                            </span>
                        </div>
                        <div class="flex items-center gap-3">
                            <x-status-badge :status="$order->statusTampil()" />
                            <a href="{{ route('spk.show', $order->no_spk) }}" class="text-xs font-semibold text-[#4B5563] hover:text-[#16181D] min-h-[44px] inline-flex items-center">
                                Rincian &rarr;
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-sm text-[#4B5563]">
                        <p>Belum ada pemesanan SPK aktif.</p>
                        <a href="{{ route('katalog.index') }}" class="mt-2 inline-block font-semibold text-[#C1121F] hover:underline">Jelajahi Katalog Mobil</a>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Section 2: Test Drive -->
        <section aria-labelledby="riwayat-td" class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-3xl overflow-hidden shadow-xl">
            <div class="px-6 py-4 bg-[#FFFFFF] border-b border-[#E5E7EB]">
                <h2 id="riwayat-td" class="font-bold text-base text-[#16181D]">Jadwal Uji Kemudi (Test Drive)</h2>
                <p class="text-xs text-[#4B5563]">Kelola atau ajukan penjadwalan ulang selama status masih aktif.</p>
            </div>
            <div class="divide-y divide-[#E5E7EB]">
                @forelse ($testDrives as $td)
                    <div class="px-6 py-5 space-y-3">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <div>
                                <span class="font-bold text-sm text-[#16181D]">{{ $td->variant->carModel->brand->nama }} {{ $td->variant->carModel->nama }} {{ $td->variant->nama }}</span>
                                <p class="text-xs text-[#4B5563] mt-0.5 tabular-nums">{{ $td->jadwal->format('d M Y H:i') }} WIB • Cabang {{ $td->branch->nama }}</p>
                            </div>
                            <x-status-badge :status="$td->status" />
                        </div>

                        @if (in_array($td->status, ['Menunggu', 'Dikonfirmasi'], true))
                            <div class="pt-3 border-t border-[#E5E7EB] flex flex-wrap items-center gap-3">
                                <form action="{{ route('pesanan.test-drive.jadwal', $td) }}" method="POST" class="flex flex-wrap items-center gap-2">
                                    @csrf @method('PATCH')
                                    <label for="jadwal-td-{{ $td->id }}" class="text-xs text-[#4B5563]">Ubah Waktu:</label>
                                    <input id="jadwal-td-{{ $td->id }}" type="datetime-local" name="jadwal" required 
                                        class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] text-xs min-h-[40px] px-3 focus:border-[#C1121F]">
                                    <button type="submit" class="px-3.5 py-2 text-xs font-bold text-[#16181D] bg-[#FFFFFF] border border-[#E5E7EB] hover:bg-[#F3F4F6] rounded-xl min-h-[40px] transition-colors">
                                        Simpan Jadwal Baru
                                    </button>
                                </form>
                                <form action="{{ route('pesanan.test-drive.batal', $td) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan jadwal test drive ini?')">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="px-3.5 py-2 text-xs font-bold text-[#C1121F] bg-rose-500/10 border border-rose-500/20 hover:bg-rose-500/20 rounded-xl min-h-[40px] transition-colors">
                                        Batalkan
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-sm text-[#4B5563]">
                        <p>Belum ada jadwal test drive yang terdaftar.</p>
                        <a href="{{ route('test-drive.create') }}" class="mt-2 inline-block font-semibold text-[#C1121F] hover:underline">Booking Test Drive Sekarang</a>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Section 3: Servis -->
        <section aria-labelledby="riwayat-svc" class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-3xl overflow-hidden shadow-xl">
            <div class="px-6 py-4 bg-[#FFFFFF] border-b border-[#E5E7EB]">
                <h2 id="riwayat-svc" class="font-bold text-base text-[#16181D]">Booking Servis Berkala</h2>
                <p class="text-xs text-[#4B5563]">Pantau proses perbaikan dan unduh invoice resmi servis.</p>
            </div>
            <div class="divide-y divide-[#E5E7EB]">
                @forelse ($servis as $svc)
                    <div class="px-6 py-5 space-y-3">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <div>
                                <span class="font-mono font-bold text-sm text-[#16181D]">{{ $svc->no_svc }}</span>
                                <span class="text-xs text-[#4B5563] font-mono ms-2 px-2 py-0.5 bg-[#FFFFFF] border border-[#E5E7EB] rounded-md">{{ $svc->nopol }}</span>
                                <p class="text-xs text-[#4B5563] mt-1 tabular-nums">{{ $svc->jadwal->format('d M Y H:i') }} WIB • Cabang {{ $svc->branch->nama }}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                @if ($svc->status === 'Selesai')
                                    <a href="{{ route('servis.invoice', $svc) }}" class="text-xs font-bold text-emerald-700 hover:underline min-h-[44px] inline-flex items-center">
                                        Unduh Invoice PDF &rarr;
                                    </a>
                                @endif
                                <x-status-badge :status="$svc->status" />
                            </div>
                        </div>

                        @if (in_array($svc->status, ['Menunggu', 'Dikonfirmasi'], true))
                            <div class="pt-3 border-t border-[#E5E7EB] flex flex-wrap items-center gap-3">
                                <form action="{{ route('pesanan.servis.jadwal', $svc) }}" method="POST" class="flex flex-wrap items-center gap-2">
                                    @csrf @method('PATCH')
                                    <label for="jadwal-svc-{{ $svc->id }}" class="text-xs text-[#4B5563]">Ubah Waktu:</label>
                                    <input id="jadwal-svc-{{ $svc->id }}" type="datetime-local" name="jadwal" required 
                                        class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] text-xs min-h-[40px] px-3 focus:border-[#C1121F]">
                                    <button type="submit" class="px-3.5 py-2 text-xs font-bold text-[#16181D] bg-[#FFFFFF] border border-[#E5E7EB] hover:bg-[#F3F4F6] rounded-xl min-h-[40px] transition-colors">
                                        Simpan Jadwal Baru
                                    </button>
                                </form>
                                <form action="{{ route('pesanan.servis.batal', $svc) }}" method="POST" onsubmit="return confirm('Batalkan booking servis ini?')">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="px-3.5 py-2 text-xs font-bold text-[#C1121F] bg-rose-500/10 border border-rose-500/20 hover:bg-rose-500/20 rounded-xl min-h-[40px] transition-colors">
                                        Batalkan
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-sm text-[#4B5563]">
                        <p>Belum ada riwayat booking servis.</p>
                        <a href="{{ route('servis.create') }}" class="mt-2 inline-block font-semibold text-[#C1121F] hover:underline">Booking Servis Sekarang</a>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Section 4: Trade-In -->
        <section aria-labelledby="riwayat-ti" class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-3xl overflow-hidden shadow-xl">
            <div class="px-6 py-4 bg-[#FFFFFF] border-b border-[#E5E7EB]">
                <h2 id="riwayat-ti" class="font-bold text-base text-[#16181D]">Tukar Tambah (Trade-In)</h2>
                <p class="text-xs text-[#4B5563]">Hasil taksiran nilai jual mobil lama Anda oleh tim appraisal.</p>
            </div>
            <div class="divide-y divide-[#E5E7EB]">
                @forelse ($tradeIns as $ti)
                    <div class="px-6 py-4 flex flex-wrap items-center justify-between gap-3 hover:bg-[#F9FAFB] transition-colors">
                        <div>
                            <span class="font-bold text-sm text-[#16181D]">{{ $ti->merk_tipe }} (Tahun {{ $ti->tahun }})</span>
                            @if ($ti->harga_penawaran)
                                <p class="text-xs font-extrabold text-emerald-700 tabular-nums mt-0.5">Penawaran Appraisal: Rp {{ number_format($ti->harga_penawaran, 0, ',', '.') }}</p>
                            @else
                                <p class="text-xs text-[#4B5563] mt-0.5">Menunggu jadwal inspeksi fisik oleh staf appraisal.</p>
                            @endif
                        </div>
                        <x-status-badge :status="$ti->status" />
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-sm text-[#4B5563]">
                        <p>Belum ada pengajuan tukar tambah.</p>
                        <a href="{{ route('trade-in.create') }}" class="mt-2 inline-block font-semibold text-[#C1121F] hover:underline">Ajukan Trade-In</a>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Section 5: Order Sparepart -->
        <section aria-labelledby="riwayat-spo" class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-3xl overflow-hidden shadow-xl">
            <div class="px-6 py-4 bg-[#FFFFFF] border-b border-[#E5E7EB]">
                <h2 id="riwayat-spo" class="font-bold text-base text-[#16181D]">Pesanan Suku Cadang (SPO)</h2>
                <p class="text-xs text-[#4B5563]">Riwayat transaksi pembelian suku cadang asli dealer.</p>
            </div>
            <div class="divide-y divide-[#E5E7EB]">
                @forelse ($spos as $spo)
                    <div class="px-6 py-4 flex flex-wrap items-center justify-between gap-3 hover:bg-[#F9FAFB] transition-colors">
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                            <a href="{{ route('sparepart.order.show', $spo->no_spo) }}" class="font-mono font-bold text-sm text-[#C1121F] hover:text-[#C1121F] underline underline-offset-2 min-h-[44px] inline-flex items-center">
                                {{ $spo->no_spo }}
                            </a>
                            <span class="text-xs sm:text-sm text-[#4B5563] tabular-nums">
                                Total: Rp {{ number_format($spo->total, 0, ',', '.') }}
                                <span class="text-gray-500">•</span>
                                <span class="text-[#4B5563]">{{ $spo->branch->nama }}</span>
                            </span>
                        </div>
                        <div class="flex items-center gap-3">
                            <x-status-badge :status="$spo->status" />
                            <a href="{{ route('sparepart.order.show', $spo->no_spo) }}" class="text-xs font-semibold text-[#4B5563] hover:text-[#16181D] min-h-[44px] inline-flex items-center">
                                Detail &rarr;
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-sm text-[#4B5563]">
                        <p>Belum ada pesanan suku cadang.</p>
                        <a href="{{ route('sparepart.index') }}" class="mt-2 inline-block font-semibold text-[#C1121F] hover:underline">Buka Katalog Sparepart</a>
                    </div>
                @endforelse
            </div>
        </section>
    </div>

    <x-site-footer />
</x-site-layout>
