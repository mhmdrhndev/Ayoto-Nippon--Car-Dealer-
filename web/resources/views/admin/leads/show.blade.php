<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Lead #{{ $lead->id }}</h2></x-slot>
    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">
        @if (session('sukses'))<p class="p-3 text-sm bg-green-50 border border-green-200 rounded-lg">{{ session('sukses') }}</p>@endif
        <div class="bg-white p-5 rounded-xl shadow-sm">
            <p class="text-sm text-gray-500">Customer: <span class="font-semibold text-gray-800">{{ $lead->customer->nama ?? '-' }} ({{ $lead->customer->telp ?? '-' }})</span></p>
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
            <form action="{{ route('admin.leads.followup', $lead) }}" method="POST" class="mt-2 space-y-3">
                @csrf
                <textarea name="catatan" required rows="2" placeholder="Hasil menghubungi customer" class="w-full rounded-lg border-gray-300 text-sm"></textarea>
                <div class="flex flex-col sm:flex-row gap-3">
                    <select name="status" class="rounded-lg border-gray-300 text-sm min-h-[44px]">
                        <option value="">Status tetap {{ $lead->status }}</option>
                        @foreach (['Baru', 'Dihubungi', 'TestDrive', 'SPK', 'Deal', 'Batal'] as $s)
                            <option value="{{ $s }}">{{ $s }}</option>
                        @endforeach
                    </select>
                    <input type="datetime-local" name="next_reminder" class="rounded-lg border-gray-300 text-sm min-h-[44px]">
                    <button class="px-4 py-2 text-sm font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Simpan</button>
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
