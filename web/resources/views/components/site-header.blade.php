<header x-data="{ menu: false }" class="bg-white border-b border-gray-200 sticky top-0 z-40">
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
                <a href="{{ route('dashboard') }}" class="px-3 py-2 text-sm font-medium text-[#16181D] hover:underline min-h-[44px] inline-flex items-center">{{ Auth::user()->name }}</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="px-3 py-2 text-sm font-medium text-[#4B5563] hover:underline min-h-[44px]">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="px-3 py-2 text-sm font-medium text-[#16181D] hover:underline min-h-[44px] inline-flex items-center">Masuk</a>
                <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px] inline-flex items-center">Daftar</a>
            @endauth
        </div>
        <button @click="menu = !menu" :aria-expanded="menu" class="lg:hidden px-3 py-2 text-sm font-semibold text-[#16181D] border border-gray-300 rounded-lg min-h-[44px]">Menu</button>
    </div>
    <nav x-show="menu" x-cloak class="lg:hidden border-t border-gray-200 px-4 py-2" aria-label="Navigasi seluler">
        @foreach ([['katalog.index', 'Katalog'], ['simulasi.form', 'Simulasi Kredit'], ['test-drive.create', 'Test Drive'], ['servis.create', 'Booking Servis'], ['promo.index', 'Promo'], ['cabang.index', 'Cabang'], ['lacak.form', 'Lacak SPK']] as [$route, $label])
            <a href="{{ route($route) }}" class="block px-2 py-3 text-sm font-medium text-[#16181D] border-b border-gray-100 last:border-0 min-h-[44px]">{{ $label }}</a>
        @endforeach
        @auth
            <a href="{{ route('dashboard') }}" class="block px-2 py-3 text-sm font-medium text-[#16181D] border-b border-gray-100 min-h-[44px]">{{ Auth::user()->name }} (Dashboard)</a>
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
