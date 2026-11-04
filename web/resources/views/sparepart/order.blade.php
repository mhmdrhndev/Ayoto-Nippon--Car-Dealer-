<x-site-layout judul="Order Sparepart {{ $order->no_spo }}">
    <x-site-header />

    <div class="w-full px-4 sm:px-6 lg:px-8 py-10 space-y-8">
        @if (session('sukses'))
            <div class="p-4 text-sm font-medium text-emerald-700 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('sukses') }}</span>
            </div>
        @endif

        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 pb-6 border-b border-[#E5E7EB]">
            <div>
                <p class="text-xs font-semibold tracking-wider text-[#C1121F] uppercase">Pesanan Suku Cadang</p>
                <h1 class="mt-1 text-2xl sm:text-3xl font-extrabold text-[#16181D] tracking-tight flex items-center gap-3">
                    Order <span class="font-mono text-[#C1121F]">{{ $order->no_spo }}</span>
                </h1>
            </div>
            <div class="flex items-center gap-2">
                <x-status-badge status="{{ $order->status }}" />
            </div>
        </div>

        <!-- Items Table -->
        <div class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-3xl overflow-hidden shadow-xl">
            <div class="px-6 py-4 bg-[#FFFFFF] border-b border-[#E5E7EB]">
                <h2 class="text-xs font-bold uppercase tracking-wider text-[#4B5563]">Rincian Barang yang Dipesan</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-[#E5E7EB] text-[#4B5563] text-xs uppercase">
                            <th class="text-left px-6 py-3.5">Nama Suku Cadang</th>
                            <th class="text-center px-6 py-3.5">Jumlah</th>
                            <th class="text-right px-6 py-3.5">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E5E7EB]">
                        @foreach ($order->items as $item)
                            <tr>
                                <td class="px-6 py-4 font-semibold text-[#16181D]">{{ $item->sparepart->nama }}</td>
                                <td class="px-6 py-4 text-center text-[#4B5563] tabular-nums">{{ $item->qty }}</td>
                                <td class="px-6 py-4 text-right font-extrabold text-[#16181D] tabular-nums">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        <tr class="bg-[#FFFFFF] font-bold">
                            <td colspan="2" class="px-6 py-4 text-[#16181D] text-right">Total Pembayaran:</td>
                            <td class="px-6 py-4 text-right text-lg text-[#C1121F] tabular-nums font-black">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Payment Instructions & Upload -->
        @if ($order->status === 'MenungguBayar')
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="p-6 bg-[#FFFFFF] border border-[#E5E7EB] rounded-3xl space-y-4 shadow-xl">
                    <p class="text-xs font-semibold tracking-wider text-[#C1121F] uppercase">Instruksi Pembayaran</p>
                    <h2 class="font-bold text-lg text-[#16181D]">Transfer Bank Resmi Cabang {{ $order->branch->nama }}</h2>
                    
                    <div class="space-y-2 pt-2">
                        @foreach ($order->branch->bankAccounts->where('aktif', true) as $rek)
                            <div class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl px-4 py-3">
                                <p class="text-xs text-[#4B5563]">{{ $rek->bank }}</p>
                                <p class="font-mono font-bold text-[#16181D] text-base">{{ $rek->no_rek }}</p>
                                <p class="text-xs text-[#4B5563]">a.n. {{ $rek->atas_nama }}</p>
                            </div>
                        @endforeach
                    </div>

                    <p class="text-xs font-semibold text-[#C1121F] pt-2">
                        Batas Waktu Pembayaran: {{ $order->deadline_at->format('d M Y H:i') }} WIB
                    </p>
                    <p class="text-[11px] text-gray-500">
                        Pengambilan unit suku cadang dilakukan di dealer cabang {{ $order->branch->nama }} dengan menunjukkan bukti order ini.
                    </p>
                </div>

                <div class="p-6 bg-[#FFFFFF] border border-[#E5E7EB] rounded-3xl shadow-xl flex flex-col justify-between">
                    <div>
                        <h2 class="font-bold text-lg text-[#16181D]">Unggah Bukti Bayar</h2>
                        <p class="mt-1 text-xs text-[#4B5563]">Format yang diterima: JPG, PNG, atau PDF (maksimal 2 MB).</p>

                        @auth
                            <form action="{{ route('sparepart.order.upload', $order->no_spo) }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4">
                                @csrf
                                <div>
                                    <label for="bukti" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">File Struk Pembayaran</label>
                                    <div class="mt-2 p-4 bg-[#FFFFFF] border border-[#E5E7EB] rounded-2xl">
                                        <input id="bukti" type="file" name="bukti" required accept=".jpg,.jpeg,.png,.pdf" 
                                            class="w-full text-xs text-[#4B5563] file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#C1121F] file:text-white hover:file:bg-[#9E0E19] cursor-pointer">
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->all()" class="text-[#C1121F] text-xs" />
                                <button type="submit" 
                                    class="w-full py-3.5 px-6 font-bold text-sm text-white bg-[#C1121F] hover:bg-[#9E0E19] rounded-xl shadow-lg shadow-[#C1121F]/25 transition-all flex items-center justify-center">
                                    Kirim Bukti Pembayaran
                                </button>
                            </form>
                        @else
                            <div class="mt-6 p-6 bg-[#FFFFFF] border border-[#E5E7EB] rounded-2xl text-center">
                                <p class="text-sm text-[#4B5563]">Silakan login untuk mengunggah bukti pembayaran.</p>
                                <a href="{{ route('login') }}" class="mt-4 inline-flex items-center px-5 py-2.5 text-xs font-bold text-white bg-[#C1121F] rounded-xl">
                                    Masuk Akun
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        @elseif ($order->status === 'Lunas')
            <div class="p-6 bg-emerald-500/10 border border-emerald-500/20 rounded-3xl flex items-center gap-4">
                <span class="w-10 h-10 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-700 font-bold text-lg">✓</span>
                <div>
                    <h3 class="font-bold text-[#16181D] text-base">Pembayaran Terverifikasi (Lunas)</h3>
                    <p class="text-xs text-emerald-300/80 mt-0.5">Suku cadang sudah siap diambil. Tunjukkan nomor SPO <strong class="font-mono">{{ $order->no_spo }}</strong> ke bagian kasir/gudang cabang {{ $order->branch->nama }}.</p>
                </div>
            </div>
        @else
            <div class="p-6 bg-[#FFFFFF] border border-[#E5E7EB] rounded-3xl text-center">
                <p class="text-sm text-[#4B5563]">Order ini telah dibatalkan atau kedaluwarsa. Stok barang telah dikembalikan ke katalog dealer.</p>
            </div>
        @endif
    </div>

    <x-site-footer />
</x-site-layout>
