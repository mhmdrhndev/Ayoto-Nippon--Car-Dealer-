<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Lead #{{ $lead->id }}</h2></x-slot>
    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">
        @if (session('sukses'))<p class="p-3 text-sm bg-green-50 border border-green-200 rounded-lg">{{ session('sukses') }}</p>@endif
        <div class="bg-white p-5 rounded-xl shadow-sm">
            <p class="text-sm text-gray-500">Customer: <span class="font-semibold text-gray-800">{{ $lead->customer->nama ?? '-' }} ({{ $lead->customer->telp ?? '-' }})</span>@if ($lead->customer?->telp) <a href="{{ \App\Support\Wa::chat($lead->customer->telp, \App\Support\Notifikasi::followupLead($lead)) }}" target="_blank" rel="noopener" class="underline font-medium text-gray-800 min-h-[44px] inline-flex items-center">Chat WA</a>@endif</p>
            <p class="text-sm text-gray-500">Sumber: {{ $lead->sumber }}, Status: <span class="font-semibold text-gray-800">{{ $lead->status }}</span></p>
            <p class="mt-2 text-sm">{{ $lead->kebutuhan_text }}</p>
            <form action="{{ route('admin.leads.assign', $lead) }}" method="POST" class="mt-3 flex gap-3">
                @csrf @method('PATCH')
                <select name="sales_id" class="rounded-lg border-gray-300 text-sm min-h-[44px]">
                    <option value="">Tanpa sales</option>
                    @foreach ($salesList as $sales)
                        <option value="{{ $sales->id }}" @selected($lead->sales_id === $sales->id)>{{ $sales->name }}</option>
                    @endforeach
                </select>
                <button class="px-4 py-2 text-sm font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Tetapkan Sales</button>
            </form>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-sm">
            <h3 class="font-bold">Tambah follow-up</h3>
            @if (in_array($lead->status, ['Lunas', 'Batal'], true))
                <p class="mt-2 text-sm text-gray-500">Lead ini sudah final ({{ $lead->status }}). Status dikunci, catatan masih bisa ditambah sebagai arsip.</p>
            @endif
            <form action="{{ route('admin.leads.followup', $lead) }}" method="POST" class="mt-2 space-y-3">
                @csrf
                <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan hasil</label>
                <textarea id="catatan" name="catatan" required rows="2" placeholder="Hasil menghubungi customer" class="mt-1 w-full rounded-lg border-gray-300 text-sm"></textarea>
                <div class="flex flex-col sm:flex-row gap-3">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Ubah status</label>
                        <select id="status" name="status" @disabled(in_array($lead->status, ['Deal', 'Lunas', 'Batal'], true)) class="mt-1 rounded-lg border-gray-300 text-sm min-h-[44px] disabled:bg-gray-100">
                            <option value="">Jangan ubah status</option>
                        @foreach (['Baru', 'Dihubungi', 'TestDrive', 'SPK', 'Deal', 'Lunas', 'Batal'] as $s)
                            <option value="{{ $s }}">{{ $s }}</option>
                        @endforeach
                    </select>
                    </div>
                    <div>
                        <label for="next_reminder" class="block text-sm font-medium text-gray-700">Ingatkan kembali</label>
                        <input id="next_reminder" type="datetime-local" name="next_reminder" class="mt-1 rounded-lg border-gray-300 text-sm min-h-[44px]">
                    </div>
                    <div class="flex items-end">
                        <button class="px-4 py-2 text-sm font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-sm">
            <h3 class="font-bold">Riwayat follow-up</h3>
            @forelse ($lead->followups as $f)
                <div class="py-2 border-b last:border-0 text-sm">
                    <p>{{ $f->catatan }}</p>
                    <p class="text-gray-500">{{ $f->created_at->format('d M Y H:i') }}{{ $f->next_reminder ? ', ingatkan: '.$f->next_reminder->format('d M Y H:i') : '' }}</p>
                </div>
            @empty
                <p class="text-sm text-gray-500">Belum ada follow-up. Catat hasil menghubungi customer di atas.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
