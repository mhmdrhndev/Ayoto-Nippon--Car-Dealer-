<header x-data="{ menu: false }" @keydown.escape.window="menu = false" class="bg-white border-b border-gray-200 sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between gap-2">
        <a href="{{ route('home') }}" class="flex items-center gap-2 min-h-[44px]">
            <img src="{{ asset('images/logo-an.png') }}" alt="Logo Ayoto Nippon" class="h-10 w-10 object-contain">
            <span class="text-lg sm:text-xl font-bold text-[#16181D]">Ayoto Nippon</span>
        </a>
        <nav class="hidden lg:flex items-center gap-1" aria-label="Navigasi utama">
            @foreach ([['katalog.index', 'Katalog'], ['simulasi.form', 'Simulasi'], ['test-drive.create', 'Test Drive'], ['servis.create', 'Servis'], ['promo.index', 'Promo'], ['cabang.index', 'Cabang'], ['lacak.form', 'Lacak SPK']] as [$route, $label])
                <a href="{{ route($route) }}" class="px-3 py-2 text-sm font-medium text-[#16181D] hover:underline min-h-[44px] inline-flex items-center">{{ $label }}</a>
            @endforeach
        </nav>
        <div class="hidden lg:flex items-center gap-2">
            @auth
                <a href="{{ route('pesanan.index') }}" class="px-3 py-2 text-sm font-medium text-[#16181D] hover:underline min-h-[44px] inline-flex items-center">Pesanan Saya</a>
                <span class="text-gray-300" aria-hidden="true">|</span>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-2 py-1 rounded-lg hover:bg-gray-100 min-h-[44px]" aria-label="Dashboard {{ Auth::user()->name }}">
                    <span class="w-9 h-9 rounded-full bg-[#C1121F] text-white font-bold text-sm inline-flex items-center justify-center shrink-0" aria-hidden="true">{{ strtoupper(collect(explode(' ', Auth::user()->name ?? ''))->map(fn ($p) => mb_substr($p, 0, 1))->take(2)->implode('')) }}</span>
                    <span class="px-1 py-2 text-sm font-medium text-[#16181D]">{{ Auth::user()->name }}</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="px-3 py-2 text-sm font-medium text-[#4B5563] hover:underline min-h-[44px]">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="px-3 py-2 text-sm font-medium text-[#16181D] hover:underline min-h-[44px] inline-flex items-center">Masuk</a>
                <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px] inline-flex items-center">Daftar</a>
            @endauth
        </div>
        <button type="button" @click="menu = !menu" aria-label="Menu" :aria-expanded="menu" class="lg:hidden p-2 rounded-lg text-[#16181D] border border-gray-300 min-w-[44px] min-h-[44px] inline-flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>
    <nav x-show="menu" x-cloak class="lg:hidden absolute inset-x-0 top-full z-50 bg-white border-b border-gray-200 shadow-lg max-h-[70vh] overflow-y-auto px-4 py-2" aria-label="Navigasi seluler">
        @foreach ([['katalog.index', 'Katalog'], ['simulasi.form', 'Simulasi Kredit'], ['test-drive.create', 'Test Drive'], ['servis.create', 'Booking Servis'], ['promo.index', 'Promo'], ['cabang.index', 'Cabang'], ['lacak.form', 'Lacak SPK']] as [$route, $label])
            <a href="{{ route($route) }}" class="block px-2 py-3 text-sm font-medium text-[#16181D] border-b border-gray-100 last:border-0 min-h-[44px]">{{ $label }}</a>
        @endforeach
        @auth
            <a href="{{ route('pesanan.index') }}" class="block px-2 py-3 text-sm font-medium text-[#16181D] border-b border-gray-100 min-h-[44px]">Pesanan Saya</a>
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-2 py-2 min-h-[44px]">
                <span class="w-9 h-9 rounded-full bg-[#C1121F] text-white font-bold text-sm inline-flex items-center justify-center shrink-0" aria-hidden="true">{{ strtoupper(collect(explode(' ', Auth::user()->name ?? ''))->map(fn ($p) => mb_substr($p, 0, 1))->take(2)->implode('')) }}</span>
                <span class="text-sm font-medium text-[#16181D]">{{ Auth::user()->name }} (Dashboard)</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-left px-2 py-3 text-sm font-medium text-[#4B5563] min-h-[44px]">Keluar</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="block px-2 py-3 text-sm font-medium text-[#16181D] border-b border-gray-100 min-h-[44px]">Masuk</a>
            <a href="{{ route('register') }}" class="block px-2 py-3 text-sm font-medium text-[#16181D] min-h-[44px]">Daftar</a>
        @endauth
    </nav>
</header>
