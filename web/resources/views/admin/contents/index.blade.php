<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-ink leading-tight">Konten</h2></x-slot>
    <div class="py-6 w-full sm:px-6 lg:px-8">
        @if (session('sukses'))<p class="mb-4 p-3 text-sm bg-green-50 dark:bg-green-500/10 border border-green-200 dark:border-green-500/30 rounded-lg">{{ session('sukses') }}</p>@endif
        <a href="{{ route('admin.contents.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-accent-strong rounded-lg min-h-[44px]">Tambah Konten</a>
        <div class="mt-4 bg-surface rounded-xl shadow-sm overflow-x-auto">
            <table class="w-full text-sm">
                <thead><tr class="border-b">
                    <th class="text-left px-4 py-3">Judul</th><th class="text-left px-4 py-3">Tipe</th>
                    <th class="text-left px-4 py-3">Slug</th><th class="text-left px-4 py-3">Aktif</th><th class="px-4 py-3"></th>
                </tr></thead>
                <tbody>
                    @forelse ($contents as $content)
                        <tr class="border-b last:border-0">
                            <td class="px-4 py-3">{{ $content->judul }}</td>
                            <td class="px-4 py-3">{{ $content->tipe }}</td>
                            <td class="px-4 py-3 font-mono">{{ $content->slug }}</td>
                            <td class="px-4 py-3">{{ $content->aktif ? 'Ya' : 'Tidak' }}</td>
                            <td class="px-4 py-3"><a href="{{ route('admin.contents.edit', $content) }}" class="underline min-h-[44px] inline-flex items-center">Ubah</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-6 text-muted">Belum ada konten. Tambahkan halaman atau berita lewat tombol di atas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $contents->links() }}</div>
    </div>
</x-app-layout>
