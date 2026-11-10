<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-ink leading-tight">Leasing</h2></x-slot>
    <div class="py-6 w-full sm:px-6 lg:px-8">
        @if (session('sukses'))<p class="mb-4 p-3 text-sm bg-green-50 dark:bg-green-500/10 border border-green-200 dark:border-green-500/30 rounded-lg">{{ session('sukses') }}</p>@endif
        <a href="{{ route('admin.leasings.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-accent-strong rounded-lg min-h-[44px]">Tambah Leasing</a>
        <div class="mt-4 bg-surface rounded-xl shadow-sm overflow-x-auto">
            <table class="w-full text-sm">
                <thead><tr class="border-b"><th class="text-left px-4 py-3">Nama</th><th class="text-left px-4 py-3">DP min</th><th class="text-left px-4 py-3">Tenor</th><th class="px-4 py-3"></th></tr></thead>
                <tbody>
                    @forelse ($leasings as $leasing)
                        <tr class="border-b last:border-0">
                            <td class="px-4 py-3 font-medium">{{ $leasing->nama }}</td>
                            <td class="px-4 py-3">{{ $leasing->dp_min_persen }}%</td>
                            <td class="px-4 py-3">{{ $leasing->tenor_list }}</td>
                            <td class="px-4 py-3"><a href="{{ route('admin.leasings.edit', $leasing) }}" class="underline min-h-[44px] inline-flex items-center">Ubah</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-4 py-6 text-muted">Belum ada leasing.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $leasings->links() }}</div>
    </div>
</x-app-layout>
