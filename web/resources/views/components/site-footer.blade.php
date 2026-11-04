<footer class="bg-[#FFFFFF] text-[#4B5563] border-t border-[#E5E7EB] mt-auto">
    <div class="w-full px-4 sm:px-6 lg:px-8 py-12 sm:py-16 grid grid-cols-1 md:grid-cols-4 gap-8 lg:gap-12">
        <div class="md:col-span-2 pr-0 md:pr-6">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo-an.png') }}" alt="Logo Ayoto Nippon" class="h-10 w-10 object-contain drop-shadow-[0_0_12px_rgba(225,29,72,0.35)]">
                <div class="flex flex-col">
                    <span class="text-xl font-bold tracking-tight text-[#16181D] flex items-center gap-1.5">
                        Ayoto Nippon
                        <span class="w-1.5 h-1.5 rounded-full bg-[#C1121F]"></span>
                    </span>
                    <span class="text-[10px] tracking-widest uppercase text-[#4B5563] font-medium">Authorized Automobile Partner</span>
                </div>
            </div>
            <p class="mt-4 text-sm text-[#4B5563] leading-relaxed max-w-md">
                Jaringan dealer resmi mobil baru terpercaya di Jakarta dan Bandung. Menyediakan unit siap kirim dengan transparansi harga OTR, kemudahan simulasi pembiayaan, servis berkala, dan jaminan suku cadang asli.
            </p>
            <div class="mt-6 flex flex-wrap gap-2 text-xs">
                <span class="px-3 py-1.5 rounded-full bg-[#FFFFFF] border border-[#E5E7EB] text-[#4B5563]">Cabang Jakarta & Bandung</span>
                <span class="px-3 py-1.5 rounded-full bg-[#FFFFFF] border border-[#E5E7EB] text-[#4B5563]">Unit VIN Jelas</span>
                <span class="px-3 py-1.5 rounded-full bg-[#FFFFFF] border border-[#E5E7EB] text-[#4B5563]">Layanan Resmi 3S</span>
            </div>
        </div>

        <nav aria-label="Layanan">
            <p class="text-xs font-semibold tracking-wider text-[#C1121F] uppercase">Layanan</p>
            <div class="mt-4 flex flex-col space-y-2.5 text-sm">
                @foreach ([['katalog.index', 'Katalog Mobil'], ['simulasi.form', 'Simulasi Kredit'], ['test-drive.create', 'Booking Test Drive'], ['trade-in.create', 'Trade-In Mobil'], ['servis.create', 'Jadwal Servis Berkala'], ['sparepart.index', 'Suku Cadang Asli']] as [$route, $label])
                    <a href="{{ route($route) }}" class="text-[#4B5563] hover:text-[#16181D] transition-colors py-0.5 inline-block">{{ $label }}</a>
                @endforeach
            </div>
        </nav>

        <nav aria-label="Bantuan dan Akun">
            <p class="text-xs font-semibold tracking-wider text-[#C1121F] uppercase">Bantuan & Akun</p>
            <div class="mt-4 flex flex-col space-y-2.5 text-sm">
                @foreach ([['promo.index', 'Promo Berjalan'], ['cabang.index', 'Lokasi Cabang'], ['lacak.form', 'Lacak Status SPK'], ['faq.index', 'Pertanyaan Umum'], ['login', 'Masuk Akun'], ['register', 'Pendaftaran Baru'], ['login.staf', 'Portal Staf Resmi']] as [$route, $label])
                    <a href="{{ route($route) }}" class="text-[#4B5563] hover:text-[#16181D] transition-colors py-0.5 inline-block">{{ $label }}</a>
                @endforeach
            </div>
        </nav>
    </div>

    <div class="border-t border-[#E5E7EB] bg-[#FFFFFF]">
        <div class="w-full px-4 sm:px-6 lg:px-8 py-5 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-gray-500">
            <p>&copy; {{ date('Y') }} PT Ayoto Nippon. Seluruh hak cipta dilindungi undang-undang.</p>
            <p class="text-gray-600">Standar Transaksi Aman & Otomasi Pemesanan Dealer</p>
        </div>
    </div>
</footer>
