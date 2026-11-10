<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-ink leading-tight">{{ $price->exists ? 'Ubah Harga' : 'Tambah Harga' }}</h2></x-slot>
    <div class="py-6 w-full sm:px-6 lg:px-8">
        <form action="{{ $price->exists ? route('admin.price-lists.update', $price) : route('admin.price-lists.store') }}" method="POST" class="bg-surface p-5 rounded-xl shadow-sm space-y-4">
            @csrf @if ($price->exists) @method('PUT') @endif
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="variant_id" class="block text-sm font-medium">Varian</label>
                    <select id="variant_id" name="variant_id" required class="mt-1 w-full rounded-lg border-line min-h-[44px]">
                        @foreach ($variants as $variant)
                            <option value="{{ $variant->id }}" @selected(old('variant_id', $price->variant_id) == $variant->id)>{{ $variant->carModel->brand->nama }} {{ $variant->carModel->nama }} {{ $variant->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="branch_id" class="block text-sm font-medium">Cabang</label>
                    <select id="branch_id" name="branch_id" required class="mt-1 w-full rounded-lg border-line min-h-[44px]">
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}" @selected(old('branch_id', $price->branch_id) == $branch->id)>{{ $branch->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="otr" class="block text-sm font-medium">OTR (Rp)</label>
                    <input id="otr" type="number" name="otr" value="{{ old('otr', $price->otr) }}" required min="0" class="mt-1 w-full rounded-lg border-line min-h-[44px]">
                </div>
                <div>
                    <label for="diskon" class="block text-sm font-medium">Diskon (Rp)</label>
                    <input id="diskon" type="number" name="diskon" value="{{ old('diskon', $price->diskon ?? 0) }}" min="0" class="mt-1 w-full rounded-lg border-line min-h-[44px]">
                </div>
            </div>
            <x-input-error :messages="$errors->all()" />
            <button class="w-full px-6 py-3 font-semibold text-white bg-accent-strong rounded-lg min-h-[44px]">Simpan</button>
        </form>
    </div>
</x-app-layout>
