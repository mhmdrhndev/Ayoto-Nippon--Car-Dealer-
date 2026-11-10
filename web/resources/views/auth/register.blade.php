<x-guest-layout judul="Daftar Akun Baru">
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
            Pendaftaran
        </span>
    </div>

    <div>
        <p class="text-xs font-semibold tracking-wider text-accent uppercase">Pendaftaran Pelanggan</p>
        <h1 class="mt-1 text-2xl sm:text-3xl font-extrabold text-ink tracking-tight">Buat Akun Baru</h1>
        <p class="mt-2 text-xs sm:text-sm text-muted leading-relaxed">
            Daftarkan akun untuk mengajukan pemesanan Surat Pesanan Kendaraan (SPK), jadwal uji kemudi test drive, dan pemantauan servis berkala.
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-muted">Nama Lengkap Sesuai KTP</label>
            <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                placeholder="Contoh: Budi Santoso"
                class="mt-1.5 block w-full bg-surface border border-line rounded-xl text-ink placeholder-gray-500 text-sm focus:border-accent focus:ring-1 focus:ring-accent min-h-[48px] px-3.5">
            <x-input-error :messages="$errors->get('name')" class="mt-1.5 text-xs text-accent" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-muted">Alamat Email Aktif</label>
            <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                placeholder="nama@email.com"
                class="mt-1.5 block w-full bg-surface border border-line rounded-xl text-ink placeholder-gray-500 text-sm focus:border-accent focus:ring-1 focus:ring-accent min-h-[48px] px-3.5">
            <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-accent" />
        </div>

        <!-- Password Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-muted">Kata Sandi</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    placeholder="Minimal 8 karakter"
                    class="mt-1.5 block w-full bg-surface border border-line rounded-xl text-ink placeholder-gray-500 text-sm focus:border-accent focus:ring-1 focus:ring-accent min-h-[48px] px-3.5">
                <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-accent" />
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-muted">Konfirmasi Kata Sandi</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                    placeholder="Ulangi kata sandi"
                    class="mt-1.5 block w-full bg-surface border border-line rounded-xl text-ink placeholder-gray-500 text-sm focus:border-accent focus:ring-1 focus:ring-accent min-h-[48px] px-3.5">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5 text-xs text-accent" />
            </div>
        </div>

        <div class="pt-2">
            <button type="submit" 
                class="w-full py-3.5 px-6 text-sm font-bold text-white bg-accent-strong hover:bg-[#9E0E19] rounded-xl min-h-[48px] shadow-lg shadow-accent/25 transition-all flex items-center justify-center active:scale-[0.99]">
                Daftar Sekarang
            </button>
        </div>
    </form>

    <div class="mt-8 pt-5 border-t border-line text-xs text-muted text-center">
        <span>Sudah memiliki akun terdaftar?</span>
        <a class="ms-1.5 font-semibold text-ink hover:text-accent underline underline-offset-2 transition-colors" href="{{ route('login') }}">
            Masuk di sini
        </a>
    </div>
</x-guest-layout>
