<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-ink leading-tight">Test Drive</h2></x-slot>
    <div class="py-6 w-full sm:px-6 lg:px-8">
        @if (session('sukses'))<p class="mb-4 p-3 text-sm bg-green-50 dark:bg-green-500/10 border border-green-200 dark:border-green-500/30 rounded-lg">{{ session('sukses') }}</p>@endif
        @if ($drives->isEmpty())
            <div class="bg-surface p-6 rounded-xl shadow-sm"><p class="font-semibold">Belum ada pengajuan.</p><p class="text-sm text-muted">Pengajuan dari halaman test drive tampil di sini.</p></div>
        @else
            <div class="bg-surface rounded-xl shadow-sm overflow-x-auto">
                <table class="w-full text-sm">
                    <thead><tr class="border-b">
                        <th class="text-left px-4 py-3">Customer</th><th class="text-left px-4 py-3">Varian</th>
                        <th class="text-left px-4 py-3">Jadwal</th><th class="text-left px-4 py-3">Status</th><th class="px-4 py-3"></th>
                    </tr></thead>
                    <tbody>
                        @foreach ($drives as $drive)
                            <tr class="border-b last:border-0">
                                <td class="px-4 py-3">{{ $drive->customer->nama }}<br><span class="text-muted">{{ $drive->customer->telp }}</span></td>
                                <td class="px-4 py-3">{{ $drive->variant ? $drive->variant->carModel->nama.' '.$drive->variant->nama : '-' }}<br><span class="text-muted">{{ $drive->color->nama ?? 'Warna bebas' }}</span></td>
                                <td class="px-4 py-3">{{ $drive->jadwal->format('d M Y H:i') }}<br><span class="text-muted">{{ $drive->branch->nama }}</span></td>
                                <td class="px-4 py-3">{{ $drive->status }}</td>
                                <td class="px-4 py-3">
                                    <form action="{{ route('admin.test-drives.update', $drive) }}" method="POST" class="flex gap-2">
                                        @csrf @method('PATCH')
                                        <select name="status" class="rounded-lg border-line text-sm min-h-[44px]">
                                            @foreach (['Menunggu', 'Dikonfirmasi', 'Hadir', 'Batal'] as $s)
                                                <option value="{{ $s }}" @selected($drive->status === $s)>{{ $s }}</option>
                                            @endforeach
                                        </select>
                                        <button class="px-3 py-2 text-xs font-semibold text-white bg-accent-strong rounded-lg min-h-[44px]">Simpan</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $drives->links() }}</div>
        @endif
    </div>
</x-app-layout>
