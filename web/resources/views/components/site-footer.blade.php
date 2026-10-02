<footer class="bg-[#16181D] text-white mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grid grid-cols-1 sm:grid-cols-3 gap-8">
        <div>
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/logo-an.png') }}" alt="Logo Ayoto Nippon" class="h-10 w-10 object-contain bg-white rounded-lg">
                <span class="text-lg font-bold">Ayoto Nippon</span>
            </div>
            <p class="mt-3 text-sm text-gray-300">Dealer mobil Jakarta dan Bandung. Katalog, SPK online, trade-in, test drive, servis, dan sparepart.</p>
        </div>
        <nav aria-label="Layanan">
            <p class="font-semibold">Layanan</p>
            <div class="mt-2 flex flex-col gap-1 text-sm">
                @foreach ([['katalog.index', 'Katalog Mobil'], ['simulasi.form', 'Simulasi Kredit'], ['test-drive.create', 'Test Drive'], ['trade-in.create', 'Trade-In'], ['servis.create', 'Booking Servis'], ['sparepart.index', 'Sparepart']] as [$route, $label])
                    <a href="{{ route($route) }}" class="text-gray-300 hover:underline py-1">{{ $label }}</a>
                @endforeach
            </div>
        </nav>
        <nav aria-label="Bantuan">
            <p class="font-semibold">Bantuan</p>
            <div class="mt-2 flex flex-col gap-1 text-sm">
                @foreach ([['promo.index', 'Promo'], ['cabang.index', 'Cabang Kami'], ['lacak.form', 'Lacak SPK'], ['login', 'Masuk'], ['register', 'Daftar']] as [$route, $label])
                    <a href="{{ route($route) }}" class="text-gray-300 hover:underline py-1">{{ $label }}</a>
                @endforeach
            </div>
        </nav>
    </div>
    <div class="border-t border-gray-700">
        <p class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 text-xs text-gray-400">PT Ayoto Nippon. All rights reserved.</p>
    </div>
</footer>
