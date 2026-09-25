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
    <div class="max-w-2xl mx-auto px-4 sm:px-6 py-8">
        @if (session('sukses'))
            <p class="p-3 text-sm font-medium text-[#16181D] bg-green-50 border border-green-200 rounded-lg">{{ session('sukses') }}</p>
        @endif
        <p class="mt-2 text-sm font-medium text-[#4B5563]">Nomor SPK: <span class="font-mono font-semibold text-[#16181D]">{{ $order->no_spk }}</span></p>
        <h1 class="mt-1 text-2xl font-bold text-[#16181D]">Status: {{ $order->status }}</h1>
        <p class="mt-1 text-sm text-[#4B5563]">{{ $order->unit->variant->carModel->brand->nama }} {{ $order->unit->variant->carModel->nama }} {{ $order->unit->variant->nama }}, {{ $order->unit->color->nama }}, VIN <span class="font-mono">{{ $order->unit->vin }}</span></p>
        @if ($order->branch->telp)
            <p class="mt-2 text-sm"><a href="{{ \App\Support\Wa::chat($order->branch->telp, 'Halo Ayoto Nippon '.$order->branch->nama.', saya bertanya mengenai SPK '.$order->no_spk.'.') }}" target="_blank" rel="noopener" class="underline font-semibold text-[#16181D] min-h-[44px] inline-flex items-center">Chat WA cabang</a></p>
        @endif

        @if ($order->status === 'MenungguBayar')
            <div class="mt-4 p-5 border border-gray-200 rounded-xl">
                <h2 class="font-bold text-[#16181D]">Instruksi transfer booking fee</h2>
                <p class="mt-2 text-2xl font-bold text-[#16181D] tabular-nums">Rp {{ number_format($order->booking_fee, 0, ',', '.') }}</p>
                @foreach ($order->branch->bankAccounts->where('aktif', true) as $rek)
                    <p class="mt-1 text-sm text-[#16181D]">{{ $rek->bank }} {{ $rek->no_rek }} a.n. {{ $rek->atas_nama }}</p>
                @endforeach
                <p class="mt-2 text-sm font-semibold text-[#C1121F]">Batas bayar: {{ $order->deadline_at->format('d M Y H:i') }}. Lewat batas, SPK otomatis Expired dan unit dilepas.</p>
            </div>
            @auth
                @if ($order->customer->user_id !== null && $order->customer->user_id !== auth()->id())
                    <p class="mt-4 p-3 text-sm text-[#16181D] bg-yellow-50 border border-yellow-200 rounded-lg">SPK ini milik akun lain. Masuk dengan akun yang membuat SPK untuk mengunggah bukti.</p>
                @else
                    <form action="{{ route('spk.upload', $order->no_spk) }}" method="POST" enctype="multipart/form-data" class="mt-4 space-y-3">
                        @csrf
                        <label for="bukti" class="block text-sm font-medium text-[#16181D]">Upload bukti transfer (JPG/PNG/PDF, maks 2 MB)</label>
                        <input id="bukti" type="file" name="bukti" required accept=".jpg,.jpeg,.png,.pdf" class="w-full min-h-[44px]">
                        <x-input-error :messages="$errors->all()" />
                        <button type="submit" class="w-full px-6 py-3 font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Upload Bukti Bayar</button>
                    </form>
                @endif
            @else
                <p class="mt-4 text-sm text-[#4B5563]"><a href="{{ route('login') }}" class="underline font-medium text-[#16181D]">Masuk</a> untuk mengunggah bukti bayar.</p>
            @endauth
        @endif

        @if ($order->status === 'MenungguVerifikasi')
            <p class="mt-4 p-3 text-sm text-[#16181D] bg-yellow-50 border border-yellow-200 rounded-lg">Bukti sudah diterima dan menunggu verifikasi admin.</p>
        @endif
        @if ($order->status === 'Deal')
            <p class="mt-4 p-3 text-sm text-[#16181D] bg-green-50 border border-green-200 rounded-lg">SPK Deal. Unit sudah menjadi milik proses Anda. Pelunasan sisa dilakukan offline di dealer.</p>
            @if ($order->invoice)
                <p class="mt-2 text-sm text-[#16181D]">Invoice: <span class="font-mono font-semibold">{{ $order->invoice->no_inv }}</span>
                @auth
                    <a href="{{ route('invoice.download', $order->invoice) }}" class="underline font-semibold">Unduh PDF</a>
                @else
                    (minta salinan PDF ke admin cabang)
                @endif
                </p>
            @endif
            @if (auth()->user()?->hasAnyRole(['admin-cabang', 'sales', 'pimpinan', 'superadmin']))
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
    </div>
</x-site-layout>
