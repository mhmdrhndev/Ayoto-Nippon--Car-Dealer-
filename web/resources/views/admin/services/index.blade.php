<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Booking Servis</h2></x-slot>
    <div class="py-6 w-full sm:px-6 lg:px-8">
        @if (session('sukses'))<p class="mb-4 p-3 text-sm bg-green-50 border border-green-200 rounded-lg">{{ session('sukses') }}</p>@endif
        @if (auth()->user()->hasRole('mekanik'))
            <p class="mb-4 p-3 text-sm text-[#16181D] bg-blue-50 border border-blue-200 rounded-lg">Menampilkan tugas servis Anda.</p>
        @endif
        <form method="GET" class="mb-4 flex gap-3">
            <select name="status" class="rounded-lg border-gray-300 min-h-[44px]">
                <option value="">Semua status</option>
                @foreach (['Menunggu', 'Dikonfirmasi', 'Dikerjakan', 'Selesai', 'Batal'] as $s)
                    <option value="{{ $s }}" @selected(request('status') === $s)>{{ $s }}</option>
                @endforeach
            </select>
            <button class="px-4 py-2 text-sm font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Filter</button>
        </form>
        @if ($bookings->isEmpty())
            <div class="bg-white p-6 rounded-xl shadow-sm"><p class="font-semibold">Belum ada booking.</p><p class="text-sm text-gray-500">Booking dari halaman servis tampil di sini.</p></div>
        @else
            <div class="bg-white rounded-xl shadow-sm overflow-x-auto">
                <table class="w-full text-sm">
                    <thead><tr class="border-b">
                        <th class="text-left px-4 py-3">No. Servis</th><th class="text-left px-4 py-3">Customer</th>
                        <th class="text-left px-4 py-3">Jadwal</th><th class="text-left px-4 py-3">Status</th>
                    </tr></thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                            <tr class="border-b last:border-0">
                                <td class="px-4 py-3"><a href="{{ route('admin.services.show', $booking) }}" class="underline font-mono font-medium min-h-[44px] inline-flex items-center">{{ $booking->no_svc }}</a></td>
                                <td class="px-4 py-3">{{ $booking->customer->nama }} ({{ $booking->nopol }})@if ($booking->customer?->telp) <a href="{{ \App\Support\Wa::chat($booking->customer->telp, \App\Support\Notifikasi::servisChat($booking)) }}" target="_blank" rel="noopener" class="underline font-medium min-h-[44px] inline-flex items-center ms-1">Chat WA</a>@endif</td>
                                <td class="px-4 py-3">{{ $booking->jadwal->format('d M Y H:i') }}<br><span class="text-gray-500">{{ $booking->branch->nama }}</span></td>
                                <td class="px-4 py-3">{{ $booking->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $bookings->links() }}</div>
        @endif
    </div>
</x-app-layout>
