<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $user->exists ? 'Ubah User' : 'Tambah User' }}</h2></x-slot>
    <div class="py-6 w-full sm:px-6 lg:px-8">
        <form action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}" method="POST" class="bg-white p-5 rounded-xl shadow-sm space-y-4">
            @csrf @if ($user->exists) @method('PUT') @endif
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-sm font-medium">Nama</label>
                    <input id="name" name="name" value="{{ old('name', $user->name) }}" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium">Password {{ $user->exists ? '(kosongkan jika tidak diganti)' : '' }}</label>
                    <input id="password" type="password" name="password" @unless($user->exists) required @endunless class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                </div>
                <div>
                    <label for="telp" class="block text-sm font-medium">Telepon</label>
                    <input id="telp" name="telp" value="{{ old('telp', $user->telp) }}" class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                </div>
                <div>
                    <label for="role" class="block text-sm font-medium">Role</label>
                    <select id="role" name="role" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}" @selected(old('role', $user->roles->first()?->name) === $role->name)>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="branch_id" class="block text-sm font-medium">Cabang (opsional)</label>
                    <select id="branch_id" name="branch_id" class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                        <option value="">Tanpa cabang</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}" @selected(old('branch_id', $user->branch_id) == $branch->id)>{{ $branch->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <x-input-error :messages="$errors->all()" />
            <button class="w-full px-6 py-3 font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Simpan</button>
        </form>
    </div>
</x-app-layout>
