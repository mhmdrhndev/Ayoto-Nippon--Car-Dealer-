<x-guest-layout judul="Reset Kata Sandi">
    <div class="mb-6 pb-6 border-b border-line flex items-center justify-between">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-accent rounded-xl">
            <img src="{{ asset('images/logo-an.png') }}" alt="Logo Ayoto Nippon" class="h-11 w-11 object-contain drop-shadow-[0_0_12px_rgba(225,29,72,0.25)] transition-transform group-hover:scale-105">
            <div class="flex flex-col">
                <span class="text-lg font-extrabold tracking-tight text-ink group-hover:text-accent flex items-center gap-1.5 transition-colors">
                    Ayoto Nippon
                    <span class="w-2 h-2 rounded-full bg-accent-strong"></span>
                </span>
                <span class="text-[10px] tracking-widest uppercase text-muted font-semibold -mt-0.5">Official Dealer</span>
            </div>
        </a>
        <span class="text-[11px] font-semibold tracking-wider text-accent uppercase px-2.5 py-1 rounded-md bg-accent-strong/10 border border-accent/20">
            Keamanan
        </span>
    </div>

    <div>
        <p class="text-xs font-semibold tracking-wider text-accent uppercase">Keamanan Akun</p>
        <h1 class="mt-1 text-2xl font-extrabold text-ink tracking-tight">Buat Kata Sandi Baru</h1>
        <p class="mt-2 text-xs sm:text-sm text-muted leading-relaxed">
            Silakan tentukan kata sandi baru untuk akun Anda.
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="mt-6 space-y-4">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-muted">Email Akun</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                class="mt-1.5 block w-full bg-surface border border-line rounded-xl text-ink text-sm focus:border-accent focus:ring-1 focus:ring-accent min-h-[48px] px-3.5">
            <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-accent font-medium" />
        </div>

        <div>
            <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-muted">Kata Sandi Baru</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                placeholder="Minimal 8 karakter"
                class="mt-1.5 block w-full bg-surface border border-line rounded-xl text-ink placeholder-gray-500 text-sm focus:border-accent focus:ring-1 focus:ring-accent min-h-[48px] px-3.5">
            <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-accent font-medium" />
        </div>

        <div>
            <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-muted">Konfirmasi Kata Sandi Baru</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                placeholder="Ulangi kata sandi"
                class="mt-1.5 block w-full bg-surface border border-line rounded-xl text-ink placeholder-gray-500 text-sm focus:border-accent focus:ring-1 focus:ring-accent min-h-[48px] px-3.5">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5 text-xs text-accent font-medium" />
        </div>

        <div class="pt-2">
            <button type="submit" 
                class="w-full py-3.5 px-6 text-sm font-bold text-white bg-accent-strong hover:bg-[#9E0E19] rounded-xl min-h-[48px] shadow-lg shadow-accent/25 transition-all flex items-center justify-center active:scale-[0.99]">
                Perbarui Kata Sandi
            </button>
        </div>
    </form>
</x-guest-layout>
