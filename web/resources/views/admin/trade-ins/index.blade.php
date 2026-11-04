<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Trade-In</h2></x-slot>
    <div class="py-6 w-full sm:px-6 lg:px-8">
        @if (session('sukses'))<p class="mb-4 p-3 text-sm bg-green-50 border border-green-200 rounded-lg">{{ session('sukses') }}</p>@endif
        @if ($trades->isEmpty())
            <div class="bg-white p-6 rounded-xl shadow-sm"><p class="font-semibold">Belum ada pengajuan.</p><p class="text-sm text-gray-500">Pengajuan dari halaman trade-in tampil di sini.</p></div>
        @else
            <div class="bg-white rounded-xl shadow-sm overflow-x-auto">
                <table class="w-full text-sm">
                    <thead><tr class="border-b">
                        <th class="text-left px-4 py-3">Customer</th><th class="text-left px-4 py-3">Mobil lama</th>
                        <th class="text-left px-4 py-3">Status</th><th class="text-left px-4 py-3">Ubah status</th>
                    </tr></thead>
                    <tbody>
                        @foreach ($trades as $trade)
                            <tr class="border-b last:border-0 align-top">
                                <td class="px-4 py-3">{{ $trade->customer->nama }}<br><span class="text-gray-500">{{ $trade->customer->telp }}</span>{{ $trade->order ? ' / SPK '.$trade->order->no_spk : '' }}</td>
                                <td class="px-4 py-3">{{ $trade->merk_tipe }}, {{ $trade->tahun }}, {{ number_format($trade->km, 0, ',', '.') }} KM<br>
                                    @if ($trade->harga_penawaran)<span class="font-semibold">Tawar: Rp {{ number_format($trade->harga_penawaran, 0, ',', '.') }}</span>@endif</td>
                                <td class="px-4 py-3">{{ $trade->status }}</td>
                                <td class="px-4 py-3">
                                    <form action="{{ route('admin.trade-ins.update', $trade) }}" method="POST" class="flex flex-col sm:flex-row gap-2">
                                        @csrf @method('PATCH')
                                        <select name="status" class="rounded-lg border-gray-300 text-sm min-h-[44px]">
                                            @foreach (['Diajukan', 'Inspeksi', 'Ditawar', 'Deal', 'Ditolak'] as $s)
                                                <option value="{{ $s }}" @selected($trade->status === $s)>{{ $s }}</option>
                                            @endforeach
                                        </select>
                                        <input name="harga_penawaran" type="number" min="0" value="{{ $trade->harga_penawaran }}" placeholder="Harga tawar Rp" class="rounded-lg border-gray-300 text-sm min-h-[44px]">
                                        <button class="px-4 py-2 text-sm font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Simpan</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $trades->links() }}</div>
        @endif
    </div>
</x-app-layout>
