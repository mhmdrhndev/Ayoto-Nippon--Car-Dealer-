<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight font-mono">{{ $service->no_svc }}</h2></x-slot>
    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">
        @if (session('sukses'))<p class="p-3 text-sm bg-green-50 border border-green-200 rounded-lg">{{ session('sukses') }}</p>@endif
        @if ($errors->any())<p class="p-3 text-sm bg-red-50 border border-red-200 rounded-lg">{{ $errors->first() }}</p>@endif
        <div class="bg-white p-5 rounded-xl shadow-sm text-sm">
            <p>Customer: <span class="font-semibold">{{ $service->customer->nama }} ({{ $service->customer->telp }})</span></p>
            <p>Nopol: <span class="font-semibold">{{ $service->nopol }}</span>, KM: {{ number_format($service->km, 0, ',', '.') }}, VIN: <span class="font-mono">{{ $service->vin ?? '-' }}</span></p>
            <p>Jadwal: {{ $service->jadwal->format('d M Y H:i') }} di {{ $service->branch->nama }}</p>
            <p>Keluhan: {{ $service->keluhan }}</p>
            <p>Status: <span class="font-semibold">{{ $service->status }}</span>, Estimasi: Rp {{ number_format($service->estimasi_biaya, 0, ',', '.') }}, Mekanik: {{ $service->mekanik->name ?? '-' }}</p>
            <form action="{{ route('admin.services.update', $service) }}" method="POST" class="mt-3 flex flex-col sm:flex-row gap-3">
                @csrf @method('PATCH')
                <select name="status" class="rounded-lg border-gray-300 text-sm min-h-[44px]">
                    @foreach (['Dikonfirmasi', 'Dikerjakan', 'Selesai', 'Batal'] as $s)
                        <option value="{{ $s }}" @selected($service->status === $s)>{{ $s }}</option>
                    @endforeach
                </select>
                <input type="number" name="estimasi_biaya" min="0" value="{{ $service->estimasi_biaya }}" placeholder="Estimasi Rp" class="rounded-lg border-gray-300 text-sm min-h-[44px]">
                <select name="mekanik_id" class="rounded-lg border-gray-300 text-sm min-h-[44px]">
                    <option value="">Tanpa mekanik</option>
                    @foreach ($mekaniks as $mekanik)
                        <option value="{{ $mekanik->id }}" @selected($service->mekanik_id === $mekanik->id)>{{ $mekanik->name }}</option>
                    @endforeach
                </select>
                <button class="px-4 py-2 text-sm font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Simpan</button>
            </form>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-sm">
            <h3 class="font-bold">Rincian pekerjaan dan sparepart (total Rp {{ number_format($service->total(), 0, ',', '.') }})</h3>
            @forelse ($service->details as $detail)
                <div class="py-2 border-b last:border-0 text-sm flex justify-between">
                    <span>[{{ $detail->jenis }}] {{ $detail->deskripsi }} x {{ $detail->qty }}</span>
                    <span class="tabular-nums">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                </div>
            @empty
                <p class="text-sm text-gray-500">Belum ada rincian. Tambahkan pekerjaan atau sparepart di bawah.</p>
            @endforelse
            <form action="{{ route('admin.services.detail', $service) }}" method="POST" class="mt-3 grid grid-cols-1 sm:grid-cols-5 gap-3">
                @csrf
                <select name="jenis" class="rounded-lg border-gray-300 text-sm min-h-[44px]">
                    <option value="Pekerjaan">Pekerjaan</option>
                    <option value="Sparepart">Sparepart</option>
                </select>
                <select name="sparepart_id" class="rounded-lg border-gray-300 text-sm min-h-[44px]">
                    <option value="">Pilih sparepart (jika jenis Sparepart)</option>
                    @foreach ($parts as $part)
                        <option value="{{ $part->id }}">{{ $part->nama }} ({{ $part->branch->nama }}, stok {{ $part->stok }})</option>
                    @endforeach
                </select>
                <input name="deskripsi" placeholder="Deskripsi pekerjaan" class="rounded-lg border-gray-300 text-sm min-h-[44px]">
                <input type="number" name="qty" value="1" min="1" class="rounded-lg border-gray-300 text-sm min-h-[44px]">
                <input type="number" name="harga_satuan" min="0" placeholder="Harga satuan (pekerjaan)" class="rounded-lg border-gray-300 text-sm min-h-[44px]">
                <button class="sm:col-span-5 px-4 py-2 text-sm font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Tambah Rincian</button>
            </form>
        </div>
    </div>
</x-app-layout>
