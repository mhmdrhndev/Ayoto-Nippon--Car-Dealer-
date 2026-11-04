<header x-data="{ menu: false }" @keydown.escape.window="menu = false" class="bg-[#FFFFFF]/90 backdrop-blur-md border-b border-[#E5E7EB] sticky top-0 z-40 transition-colors">
    @php
        $staf = auth()->user()?->hasAnyRole(['sales', 'admin-cabang', 'service-advisor', 'mekanik', 'pimpinan', 'superadmin', 'owner']) ?? false;
    @endphp
    <div class="w-full px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between gap-4">
        <a href="{{ route('home') }}" class="flex items-center gap-3 min-h-[44px] group">
            <div class="relative">
                <img src="{{ asset('images/logo-an.png') }}" alt="Logo Ayoto Nippon" class="h-9 w-9 object-contain drop-shadow-[0_0_12px_rgba(225,29,72,0.35)] transition-transform group-hover:scale-105">
            </div>
            <div class="flex flex-col">
                <span class="text-base sm:text-lg font-bold tracking-tight text-[#16181D] group-hover:text-[#C1121F] flex items-center gap-1.5">
                    Ayoto Nippon
                    <span class="w-1.5 h-1.5 rounded-full bg-[#C1121F]"></span>
                </span>
                <span class="text-[10px] tracking-widest uppercase text-[#4B5563] font-medium -mt-0.5">Official Dealer</span>
            </div>
        </a>

        <nav class="hidden lg:flex items-center gap-1" aria-label="Navigasi utama">
            @foreach ([['katalog.index', 'Katalog'], ['simulasi.form', 'Simulasi'], ['test-drive.create', 'Test Drive'], ['servis.create', 'Servis'], ['promo.index', 'Promo'], ['cabang.index', 'Cabang'], ['lacak.form', 'Lacak SPK']] as [$route, $label])
                @php
                    $isAktif = request()->routeIs($route) || (str_contains($route, '.') && request()->routeIs(explode('.', $route)[0].'.*'));
                @endphp
                <a href="{{ route($route) }}" 
                   class="px-3.5 py-2 text-sm font-medium rounded-lg transition-all min-h-[44px] inline-flex items-center {{ $isAktif ? 'text-[#C1121F] bg-[#C1121F]/10 font-semibold' : 'text-[#4B5563] hover:text-[#C1121F] hover:bg-[#F3F4F6]' }}">
                    {{ $label }}
                </a>
            @endforeach
        </nav>

        <div class="hidden lg:flex items-center gap-3">
            @auth
                @unless ($staf)
                    <a href="{{ route('pesanan.index') }}" class="px-3 py-2 text-sm font-medium text-[#4B5563] hover:text-[#C1121F] hover:bg-[#F3F4F6] rounded-lg transition-colors min-h-[44px] inline-flex items-center">
                        Pesanan Saya
                    </a>
                    <span class="text-[#E5E7EB]" aria-hidden="true">|</span>
                @endunless
                <a href="{{ $staf ? route('dashboard') : route('pesanan.index') }}" class="flex items-center gap-2.5 px-2.5 py-1.5 rounded-xl hover:bg-[#F3F4F6] border border-transparent hover:border-[#C1121F] transition-all min-h-[44px]" aria-label="{{ $staf ? 'Dashboard' : 'Pesanan Saya' }} {{ Auth::user()->name }}">
                    <span class="w-8 h-8 rounded-full bg-gradient-to-br from-[#C1121F] to-[#9E0E19] text-white font-bold text-xs inline-flex items-center justify-center shrink-0 shadow-sm" aria-hidden="true">{{ strtoupper(collect(explode(' ', Auth::user()->name ?? ''))->map(fn ($p) => mb_substr($p, 0, 1))->take(2)->implode('')) }}</span>
                    <span class="text-sm font-medium text-[#16181D] max-w-[140px] truncate">{{ Auth::user()->name }}</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="px-3 py-2 text-sm font-medium text-[#4B5563] hover:text-[#9E0E19] rounded-lg hover:bg-[#F3F4F6] transition-colors min-h-[44px]">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="px-3.5 py-2 text-sm font-medium text-[#4B5563] hover:text-[#C1121F] hover:bg-[#F3F4F6] rounded-xl transition-colors min-h-[44px] inline-flex items-center">Masuk</a>
                <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-semibold text-white bg-[#C1121F] hover:bg-[#9E0E19] rounded-xl shadow-lg shadow-[#C1121F]/20 transition-all min-h-[44px] inline-flex items-center hover:shadow-[#C1121F]/35 active:scale-[0.98]">Daftar</a>
            @endauth
        </div>

        <button type="button" @click="menu = !menu" aria-label="Menu" :aria-expanded="menu" class="lg:hidden p-2.5 rounded-xl text-[#4B5563] hover:text-[#16181D] bg-[#FFFFFF] border border-[#E5E7EB] hover:border-[#C1121F] min-w-[44px] min-h-[44px] inline-flex items-center justify-center transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path x-show="!menu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path x-show="menu" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Mobile Drawer -->
    <nav x-show="menu" x-cloak 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="lg:hidden absolute inset-x-0 top-full z-50 bg-[#FFFFFF]/98 backdrop-blur-2xl border-b border-[#E5E7EB] shadow-2xl max-h-[80vh] overflow-y-auto px-4 py-3 divide-y divide-[#E5E7EB]" aria-label="Navigasi seluler">
        <div class="space-y-1 pb-3">
            @foreach ([['katalog.index', 'Katalog Mobil'], ['simulasi.form', 'Simulasi Kredit'], ['test-drive.create', 'Booking Test Drive'], ['servis.create', 'Jadwal Servis'], ['promo.index', 'Promo Spesial'], ['cabang.index', 'Jaringan Cabang'], ['lacak.form', 'Lacak SPK']] as [$route, $label])
                <a href="{{ route($route) }}" class="block px-3 py-2.5 text-sm font-medium text-[#16181D] hover:text-[#C1121F] hover:bg-[#F3F4F6] rounded-xl min-h-[44px] flex items-center">{{ $label }}</a>
            @endforeach
        </div>

        <div class="pt-3">
            @auth
                @unless ($staf)
                    <a href="{{ route('pesanan.index') }}" class="block px-3 py-2.5 text-sm font-medium text-[#16181D] hover:text-[#C1121F] hover:bg-[#F3F4F6] rounded-xl min-h-[44px] flex items-center">Pesanan Saya</a>
                @endunless
                <a href="{{ $staf ? route('dashboard') : route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-[#F3F4F6] min-h-[44px]">
                    <span class="w-8 h-8 rounded-full bg-gradient-to-br from-[#C1121F] to-[#9E0E19] text-white font-bold text-xs inline-flex items-center justify-center shrink-0" aria-hidden="true">{{ strtoupper(collect(explode(' ', Auth::user()->name ?? ''))->map(fn ($p) => mb_substr($p, 0, 1))->take(2)->implode('')) }}</span>
                    <span class="text-sm font-medium text-[#16181D]">{{ Auth::user()->name }} ({{ $staf ? 'Dashboard' : 'Profil' }})</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mt-1">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-2.5 text-sm font-medium text-[#9E0E19] hover:text-[#C1121F] hover:bg-[#F3F4F6] rounded-xl min-h-[44px] flex items-center">Keluar</button>
                </form>
            @else
                <div class="grid grid-cols-2 gap-2 pt-1">
                    <a href="{{ route('login') }}" class="px-3 py-2.5 text-center text-sm font-medium text-[#16181D] bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl min-h-[44px] flex items-center justify-center">Masuk</a>
                    <a href="{{ route('register') }}" class="px-3 py-2.5 text-center text-sm font-semibold text-white bg-[#C1121F] rounded-xl min-h-[44px] flex items-center justify-center shadow-lg shadow-[#C1121F]/20">Daftar</a>
                </div>
            @endauth
        </div>
    </nav>
</header>
