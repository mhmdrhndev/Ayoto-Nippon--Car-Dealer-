<x-site-layout>
    <x-site-header />
    <div class="max-w-2xl mx-auto px-4 sm:px-6 py-8">
        @if (session('sukses'))
            <p class="p-3 text-sm font-medium text-[#16181D] bg-green-50 border border-green-200 rounded-lg">{{ session('sukses') }}</p>
        @endif
        <p class="mt-2 text-sm font-medium text-[#4B5563]">Nomor order: <span class="font-mono font-semibold text-[#16181D]">{{ $order->no_spo }}</span></p>
        <h1 class="mt-1 text-2xl font-bold text-[#16181D]">Status: {{ $order->status }}</h1>
        <div class="mt-4 border border-gray-200 rounded-xl overflow-x-auto">
            <table class="w-full text-sm">
                <thead><tr class="border-b border-gray-200">
                    <th class="text-left px-4 py-3 text-[#16181D]">Sparepart</th>
                    <th class="text-right px-4 py-3 text-[#16181D]">Qty</th>
                    <th class="text-right px-4 py-3 text-[#16181D]">Subtotal</th>
                </tr></thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr class="border-b border-gray-100 last:border-0">
                            <td class="px-4 py-3 text-[#16181D]">{{ $item->sparepart->nama }}</td>
                            <td class="px-4 py-3 text-right text-[#16181D]">{{ $item->qty }}</td>
                            <td class="px-4 py-3 text-right font-semibold text-[#16181D] tabular-nums">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="2" class="px-4 py-3 font-bold text-[#16181D]">Total</td>
                        <td class="px-4 py-3 text-right font-bold text-[#16181D] tabular-nums">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        @if ($order->status === 'MenungguBayar')
            <div class="mt-4 p-5 border border-gray-200 rounded-xl">
                <h2 class="font-bold text-[#16181D]">Instruksi transfer (ambil di {{ $order->branch->nama }})</h2>
                @foreach ($order->branch->bankAccounts->where('aktif', true) as $rek)
                    <p class="mt-1 text-sm text-[#16181D]">{{ $rek->bank }} {{ $rek->no_rek }} a.n. {{ $rek->atas_nama }}</p>
                @endforeach
                <p class="mt-2 text-sm font-semibold text-[#C1121F]">Batas bayar: {{ $order->deadline_at->format('d M Y H:i') }}.</p>
            </div>
            @auth
                <form action="{{ route('sparepart.order.upload', $order->no_spo) }}" method="POST" enctype="multipart/form-data" class="mt-4 space-y-3">
                    @csrf
                    <label for="bukti" class="block text-sm font-medium text-[#16181D]">Upload bukti transfer (JPG/PNG/PDF, maks 2 MB)</label>
                    <input id="bukti" type="file" name="bukti" required accept=".jpg,.jpeg,.png,.pdf" class="w-full min-h-[44px]">
                    <x-input-error :messages="$errors->all()" />
                    <button type="submit" class="w-full px-6 py-3 font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Upload Bukti Bayar</button>
                </form>
            @else
                <p class="mt-4 text-sm text-[#4B5563]"><a href="{{ route('login') }}" class="underline font-medium text-[#16181D]">Masuk</a> untuk mengunggah bukti bayar.</p>
            @endauth
        @elseif ($order->status === 'Lunas')
            <p class="mt-4 p-3 text-sm text-[#16181D] bg-green-50 border border-green-200 rounded-lg">Sudah lunas. Tunjukkan nomor order ini saat pengambilan di cabang.</p>
        @else
            <p class="mt-4 p-3 text-sm text-[#4B5563] bg-gray-50 border border-gray-200 rounded-lg">Order dibatalkan dan stok dikembalikan.</p>
        @endif
    </div>
    <x-site-footer />
</x-site-layout>
