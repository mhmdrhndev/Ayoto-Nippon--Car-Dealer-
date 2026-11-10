<x-guest-layout judul="Lupa Kata Sandi">
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
            Bantuan
        </span>
    </div>

    <div>
        <p class="text-xs font-semibold tracking-wider text-accent uppercase">Pemulihan Akun</p>
        <h1 class="mt-1 text-2xl font-extrabold text-ink tracking-tight">Atur Ulang Kata Sandi</h1>
        <p class="mt-2 text-xs sm:text-sm text-muted leading-relaxed">
            Masukkan alamat email yang terdaftar pada akun Anda. Kami akan mengirimkan tautan untuk mengatur ulang kata sandi baru.
        </p>
    </div>

    <x-auth-session-status class="mt-4 text-emerald-700 dark:text-emerald-300 bg-emerald-500/10 border border-emerald-500/20 p-3 rounded-xl text-xs" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-muted">Alamat Email Terdaftar</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                placeholder="nama@email.com"
                class="mt-1.5 block w-full bg-surface border border-line rounded-xl text-ink placeholder-gray-500 text-sm focus:border-accent focus:ring-1 focus:ring-accent min-h-[48px] px-3.5">
            <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-accent font-medium" />
        </div>

        <button type="submit" 
            class="w-full py-3.5 px-6 text-sm font-bold text-white bg-accent-strong hover:bg-[#9E0E19] rounded-xl min-h-[48px] shadow-lg shadow-accent/25 transition-all flex items-center justify-center active:scale-[0.99]">
            Kirim Tautan Pemulihan
        </button>
    </form>

    <div class="mt-6 pt-5 border-t border-line text-xs text-center text-muted">
        <a href="{{ route('login') }}" class="font-semibold text-ink hover:text-accent underline underline-offset-2 transition-colors">
            &larr; Kembali ke halaman Masuk
        </a>
    </div>
</x-guest-layout>
