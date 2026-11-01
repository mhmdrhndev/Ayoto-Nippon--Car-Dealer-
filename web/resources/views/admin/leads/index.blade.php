<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Leads</h2></x-slot>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <form method="GET" class="mb-4 flex flex-col sm:flex-row gap-3">
            <select name="status" aria-label="Filter status" class="rounded-lg border-gray-300 min-h-[44px]">
                <option value="">Semua status</option>
                @foreach (['Baru', 'Dihubungi', 'TestDrive', 'SPK', 'Deal', 'Lunas', 'Batal'] as $s)
                    <option value="{{ $s }}" @selected(request('status') === $s)>{{ $s }}</option>
                @endforeach
            </select>
            <select name="sales" aria-label="Filter sales" class="rounded-lg border-gray-300 min-h-[44px]">
                <option value="">Semua sales</option>
                @foreach ($salesList as $sales)
                    <option value="{{ $sales->id }}" @selected((string) request('sales') === (string) $sales->id)>{{ $sales->name }}</option>
                @endforeach
            </select>
            <button class="px-4 py-2 text-sm font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Filter</button>
        </form>
        @if ($leads->isEmpty())
            <div class="bg-white p-6 rounded-xl shadow-sm"><p class="font-semibold">Belum ada leads.</p><p class="text-sm text-gray-500">Leads terbentuk otomatis dari simulasi, SPK, dan test drive.</p></div>
        @else
            <div class="bg-white rounded-xl shadow-sm overflow-x-auto">
                <table class="w-full text-sm">
                    <thead><tr class="border-b">
                        <th class="text-left px-4 py-3">ID</th><th class="text-left px-4 py-3">Customer</th>
                        <th class="text-left px-4 py-3">Sumber</th><th class="text-left px-4 py-3">Status</th>
                        <th class="text-left px-4 py-3">Sales</th><th class="text-left px-4 py-3">Kebutuhan</th>
                    </tr></thead>
                    <tbody>
                        @foreach ($leads as $lead)
                            <tr class="border-b last:border-0">
                                <td class="px-4 py-3"><a href="{{ route('admin.leads.show', $lead) }}" class="underline font-medium min-h-[44px] inline-flex items-center">#{{ $lead->id }}</a></td>
                                <td class="px-4 py-3">{{ $lead->customer->nama ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $lead->sumber }}</td>
                                <td class="px-4 py-3">{{ $lead->status }}</td>
                                <td class="px-4 py-3">{{ $lead->sales->name ?? 'Belum ditetapkan' }}</td>
                                <td class="px-4 py-3 text-gray-500">{{ \Illuminate\Support\Str::limit($lead->kebutuhan_text, 60) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $leads->links() }}</div>
        @endif
    </div>
</x-app-layout>
