<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $account->exists ? 'Ubah Rekening' : 'Tambah Rekening' }}</h2></x-slot>
    <div class="py-6 w-full sm:px-6 lg:px-8">
        <form action="{{ $account->exists ? route('admin.bank-accounts.update', $account) : route('admin.bank-accounts.store') }}" method="POST" class="bg-white p-5 rounded-xl shadow-sm space-y-4">
            @csrf @if ($account->exists) @method('PUT') @endif
            <div>
                <label for="branch_id" class="block text-sm font-medium">Cabang</label>
                <select id="branch_id" name="branch_id" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}" @selected(old('branch_id', $account->branch_id) == $branch->id)>{{ $branch->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="bank" class="block text-sm font-medium">Bank</label>
                    <input id="bank" name="bank" value="{{ old('bank', $account->bank) }}" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                </div>
                <div>
                    <label for="no_rek" class="block text-sm font-medium">No. rekening</label>
                    <input id="no_rek" name="no_rek" value="{{ old('no_rek', $account->no_rek) }}" required class="mt-1 w-full rounded-lg border-gray-300 font-mono min-h-[44px]">
                </div>
            </div>
            <div>
                <label for="atas_nama" class="block text-sm font-medium">Atas nama</label>
                <input id="atas_nama" name="atas_nama" value="{{ old('atas_nama', $account->atas_nama) }}" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
            </div>
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="aktif" value="1" @checked(old('aktif', $account->aktif ?? true)) class="min-w-[20px] min-h-[20px]"> Aktif</label>
            <x-input-error :messages="$errors->all()" />
            <button class="w-full px-6 py-3 font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Simpan</button>
        </form>
    </div>
</x-app-layout>
