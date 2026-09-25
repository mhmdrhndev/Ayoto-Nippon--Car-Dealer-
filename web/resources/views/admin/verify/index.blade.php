<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Antrean Verifikasi SPK</h2></x-slot>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if (session('sukses'))<p class="mb-4 p-3 text-sm bg-green-50 border border-green-200 rounded-lg">{{ session('sukses') }}</p>@endif
        @if ($orders->isEmpty())
            <div class="bg-white p-6 rounded-xl shadow-sm"><p class="font-semibold">Antrean kosong.</p><p class="text-sm text-gray-500">Tidak ada SPK yang menunggu verifikasi.</p></div>
        @else
            <div class="bg-white rounded-xl shadow-sm overflow-x-auto">
                <table class="w-full text-sm">
                    <thead><tr class="border-b">
                        <th class="text-left px-4 py-3">No. SPK</th><th class="text-left px-4 py-3">Customer</th>
                        <th class="text-left px-4 py-3">Unit</th><th class="text-left px-4 py-3">Cabang</th><th class="text-left px-4 py-3">Dokumen</th><th class="text-left px-4 py-3">Keputusan</th>
                    </tr></thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr class="border-b last:border-0 align-top">
                                <td class="px-4 py-3 font-mono">{{ $order->no_spk }}</td>
                                <td class="px-4 py-3">{{ $order->customer->nama }}<br><span class="text-gray-500">{{ $order->customer->telp }}</span><br><a href="{{ \App\Support\Wa::chat($order->customer->telp, 'Halo, saya dari Ayoto Nippon mengenai SPK '.$order->no_spk.'.') }}" target="_blank" rel="noopener" class="underline font-medium min-h-[44px] inline-flex items-center">Chat WA</a></td>
                                <td class="px-4 py-3">{{ $order->unit->variant->carModel->nama }} {{ $order->unit->variant->nama }}<br><span class="font-mono text-gray-500">{{ $order->unit->vin }}</span></td>
                                <td class="px-4 py-3">{{ $order->branch->nama }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if ($order->customer->ktp_path)
                                        <a href="{{ route('admin.verify.file', [$order, 'ktp']) }}" target="_blank" rel="noopener" class="underline font-medium min-h-[44px] inline-flex items-center mr-2">KTP</a>
                                    @endif
                                    @if ($order->customer->kk_path)
                                        <a href="{{ route('admin.verify.file', [$order, 'kk']) }}" target="_blank" rel="noopener" class="underline font-medium min-h-[44px] inline-flex items-center mr-2">KK</a>
                                    @endif
                                    @if ($order->bukti_path)
                                        <a href="{{ route('admin.verify.file', [$order, 'bukti']) }}" target="_blank" rel="noopener" class="underline font-medium min-h-[44px] inline-flex items-center">Bukti</a>
                                    @else
                                        <span class="text-gray-400">Tanpa bukti</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <form action="{{ route('admin.verify.update', $order) }}" method="POST" class="space-y-2 min-w-56">
                                        @csrf @method('PATCH')
                                        <label class="flex items-center gap-2"><input type="radio" name="keputusan" value="terima" checked class="min-w-[20px] min-h-[20px]"> Terima (Deal)</label>
                                        <label class="flex items-center gap-2"><input type="radio" name="keputusan" value="tolak" class="min-w-[20px] min-h-[20px]"> Tolak</label>
                                        <select name="tolak_aksi" class="w-full rounded-lg border-gray-300 text-sm min-h-[44px]">
                                            <option value="perpanjang">Tolak, beri deadline baru</option>
                                            <option value="batal">Tolak dan batalkan</option>
                                        </select>
                                        <input name="tolak_alasan" placeholder="Alasan penolakan (wajib jika tolak)" class="w-full rounded-lg border-gray-300 text-sm min-h-[44px]">
                                        <button class="w-full px-4 py-2 text-sm font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Simpan Verifikasi</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $orders->links() }}</div>
        @endif
    </div>
</x-app-layout>
