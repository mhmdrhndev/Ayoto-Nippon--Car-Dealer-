<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-ink leading-tight">Lead #{{ $lead->id }}</h2></x-slot>
    <div class="py-6 w-full sm:px-6 lg:px-8 space-y-4">
        @if (session('sukses'))<p class="p-3 text-sm bg-green-50 dark:bg-green-500/10 border border-green-200 dark:border-green-500/30 rounded-lg">{{ session('sukses') }}</p>@endif
        <div class="bg-surface p-5 rounded-xl shadow-sm">
            <p class="text-sm text-muted">Customer: <span class="font-semibold text-ink">{{ $lead->customer->nama ?? '-' }} ({{ $lead->customer->telp ?? '-' }})</span>@if ($lead->customer?->telp) <a href="{{ \App\Support\Wa::chat($lead->customer->telp, \App\Support\Notifikasi::followupLead($lead)) }}" target="_blank" rel="noopener" class="underline font-medium text-ink min-h-[44px] inline-flex items-center">Chat WA</a>@endif</p>
            <p class="text-sm text-muted">Sumber: {{ $lead->sumber }}, Status: <span class="font-semibold text-ink">{{ $lead->status }}</span></p>
            <p class="mt-2 text-sm">{{ $lead->kebutuhan_text }}</p>
            <form action="{{ route('admin.leads.assign', $lead) }}" method="POST" class="mt-3 flex gap-3">
                @csrf @method('PATCH')
                <select name="sales_id" class="rounded-lg border-line text-sm min-h-[44px]">
                    <option value="">Tanpa sales</option>
                    @foreach ($salesList as $sales)
                        <option value="{{ $sales->id }}" @selected($lead->sales_id === $sales->id)>{{ $sales->name }}</option>
                    @endforeach
                </select>
                <button class="px-4 py-2 text-sm font-semibold text-white bg-accent-strong rounded-lg min-h-[44px]">Tetapkan Sales</button>
            </form>
        </div>
        <div class="bg-surface p-5 rounded-xl shadow-sm">
            <h3 class="font-bold">Tambah follow-up</h3>
            @if ($lead->status === 'Lunas')
                <p class="mt-2 text-sm text-muted">Status Lunas tidak bisa diubah lagi. Catatan follow-up masih bisa ditambah.</p>
            @endif
            <form action="{{ route('admin.leads.followup', $lead) }}" method="POST" class="mt-2 space-y-3">
                @csrf
                <label for="catatan" class="block text-sm font-medium text-ink">Catatan hasil</label>
                <textarea id="catatan" name="catatan" required rows="2" placeholder="Hasil menghubungi customer" class="mt-1 w-full rounded-lg border-line text-sm"></textarea>
                <div class="flex flex-col sm:flex-row gap-3">
                    <div>
                        <label for="status" class="block text-sm font-medium text-ink">Ubah status</label>
                        <select id="status" name="status" class="mt-1 rounded-lg border-line text-sm min-h-[44px]">
                            <option value="">{{ $lead->status === 'Lunas' ? 'Lunas' : 'Jangan ubah status' }}</option>
                        @foreach (['Baru', 'Dihubungi', 'TestDrive', 'SPK', 'Deal', 'Lunas', 'Batal'] as $s)
                            @continue($lead->status === 'Lunas' && $s === 'Lunas')
                            <option value="{{ $s }}" @disabled($lead->status === 'Lunas')>{{ $s }}</option>
                        @endforeach
                    </select>
                    </div>
                    <div>
                        <label for="next_reminder" class="block text-sm font-medium text-ink">Ingatkan kembali</label>
                        <input id="next_reminder" type="datetime-local" name="next_reminder" class="mt-1 rounded-lg border-line text-sm min-h-[44px]">
                    </div>
                    <div class="flex items-end">
                        <button class="px-4 py-2 text-sm font-semibold text-white bg-accent-strong rounded-lg min-h-[44px]">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="bg-surface p-5 rounded-xl shadow-sm">
            <h3 class="font-bold">Riwayat follow-up</h3>
            @forelse ($lead->followups as $f)
                <div class="py-2 border-b last:border-0 text-sm">
                    <p>{{ $f->catatan }}</p>
                    <p class="text-muted">{{ $f->created_at->format('d M Y H:i') }}{{ $f->next_reminder ? ', ingatkan: '.$f->next_reminder->format('d M Y H:i') : '' }}</p>
                </div>
            @empty
                <p class="text-sm text-muted">Belum ada follow-up. Catat hasil menghubungi customer di atas.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
