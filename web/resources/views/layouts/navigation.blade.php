<div x-show="open" @click="open = false" x-cloak class="fixed inset-0 z-40 bg-black/50 lg:hidden" aria-hidden="true"></div>
<aside :class="(rail ? 'w-20 ' : 'w-72 ') + (!open ? '-translate-x-full lg:translate-x-0' : '')" style="background:#000" class="sidebar-shell fixed lg:sticky lg:top-0 z-50 h-screen shrink-0 bg-black text-gray-200 flex flex-col transition-all overflow-hidden" aria-label="Navigasi admin">
    <div class="px-3 py-3 flex items-center gap-2 border-b border-white/10">
        <div class="flex items-center gap-2 min-w-0">
            <x-application-logo class="block h-9 w-auto bg-white rounded-lg shrink-0" />
            <span x-show="!rail" class="font-bold text-[#16181D] truncate" x-cloak>Ayoto Nippon</span>
        </div>
    </div>
    <nav class="sidebar-track flex-1 overflow-y-auto px-3 py-4 space-y-5 text-sm">
        <a href="{{ route('dashboard') }}" title="Dashboard" aria-current="{{ request()->routeIs('dashboard') ? 'page' : 'false' }}" class="relative flex items-center gap-3 px-3 py-2.5 rounded-lg min-h-[44px] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/60 {{ request()->routeIs('dashboard') ? 'bg-white/10 font-semibold text-white' : 'hover:bg-white/10 hover:text-white' }}">
            @if (request()->routeIs('dashboard'))
                <span class="absolute left-0 top-2 bottom-2 w-1 rounded-full bg-[#C1121F]"></span>
            @endif
            <x-nav-icon name="grid" />
            <span x-show="!rail" x-cloak>Dashboard</span>
        </a>
        @hasanyrole('sales|admin-cabang|pimpinan|superadmin|owner')
            <div x-data="{ buka: true }">
                <button type="button" @click="buka = !buka" :aria-expanded="buka" class="w-full flex items-center justify-between px-3 mb-1 min-h-[44px] rounded-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/60">
                    <span x-show="!rail" class="text-[11px] font-semibold tracking-widest text-gray-400" x-cloak>PENJUALAN</span>
                    <x-nav-icon name="chevron" class="w-4 h-4 transition-transform" ::class="{ 'rotate-180': buka }" />
                </button>
                <div x-show="buka" class="space-y-0.5">
                    @foreach ([['admin.verify.index', 'admin.verify.*', 'Verifikasi SPK', 'check'], ['admin.leads.index', 'admin.leads.*', 'Leads', 'users'], ['admin.units.index', 'admin.units.*', 'Stok Unit', 'box'], ['admin.test-drives.index', 'admin.test-drives.*', 'Test Drive', 'car'], ['admin.trade-ins.index', 'admin.trade-ins.*', 'Trade-In', 'swap']] as [$route, $pola, $label, $ikon])
                        <a href="{{ route($route) }}" title="{{ $label }}" aria-current="{{ request()->routeIs($pola) ? 'page' : 'false' }}" class="relative flex items-center gap-3 px-3 py-2.5 rounded-lg min-h-[44px] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/60 {{ request()->routeIs($pola) ? 'bg-white/10 font-semibold text-white' : 'hover:bg-white/10 hover:text-white' }}">
                            @if (request()->routeIs($pola))
                                <span class="absolute left-0 top-2 bottom-2 w-1 rounded-full bg-[#C1121F]"></span>
                            @endif
                            <x-nav-icon :name="$ikon" />
                            <span x-show="!rail" x-cloak>{{ $label }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endhasanyrole
        @hasanyrole('service-advisor|mekanik|admin-cabang|pimpinan|superadmin|owner')
            <div x-data="{ buka: true }">
                <button type="button" @click="buka = !buka" :aria-expanded="buka" class="w-full flex items-center justify-between px-3 mb-1 min-h-[44px] rounded-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/60">
                    <span x-show="!rail" class="text-[11px] font-semibold tracking-widest text-gray-400" x-cloak>BENGKEL</span>
                    <x-nav-icon name="chevron" class="w-4 h-4 transition-transform" ::class="{ 'rotate-180': buka }" />
                </button>
                <div x-show="buka" class="space-y-0.5">
                    @foreach ([['admin.services.index', 'admin.services.*', 'Servis', 'wrench'], ['admin.spareparts.index', 'admin.spareparts.*', 'Sparepart', 'box'], ['admin.sparepart-orders.index', 'admin.sparepart-orders.*', 'Order Part', 'clipboard']] as [$route, $pola, $label, $ikon])
                        <a href="{{ route($route) }}" title="{{ $label }}" aria-current="{{ request()->routeIs($pola) ? 'page' : 'false' }}" class="relative flex items-center gap-3 px-3 py-2.5 rounded-lg min-h-[44px] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/60 {{ request()->routeIs($pola) ? 'bg-white/10 font-semibold text-white' : 'hover:bg-white/10 hover:text-white' }}">
                            @if (request()->routeIs($pola))
                                <span class="absolute left-0 top-2 bottom-2 w-1 rounded-full bg-[#C1121F]"></span>
                            @endif
                            <x-nav-icon :name="$ikon" />
                            <span x-show="!rail" x-cloak>{{ $label }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endhasanyrole
        @hasanyrole('superadmin|pimpinan|admin-cabang|owner')
            <div x-data="{ buka: true }">
                <button type="button" @click="buka = !buka" :aria-expanded="buka" class="w-full flex items-center justify-between px-3 mb-1 min-h-[44px] rounded-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/60">
                    <span x-show="!rail" class="text-[11px] font-semibold tracking-widest text-gray-400" x-cloak>KELOLA</span>
                    <x-nav-icon name="chevron" class="w-4 h-4 transition-transform" ::class="{ 'rotate-180': buka }" />
                </button>
                <div x-show="buka" class="space-y-0.5">
                    @foreach ([['admin.brands.index', 'admin.brands.*', 'Brand', 'tag'], ['admin.models.index', 'admin.models.*', 'Model', 'car'], ['admin.variants.index', 'admin.variants.*', 'Varian', 'layers'], ['admin.colors.index', 'admin.colors.*', 'Warna', 'drop'], ['admin.leasings.index', 'admin.leasings.*', 'Leasing', 'bank'], ['admin.branches.index', 'admin.branches.*', 'Cabang', 'pin'], ['admin.promos.index', 'admin.promos.*', 'Promo', 'percent'], ['admin.contents.index', 'admin.contents.*', 'Konten', 'doc'], ['admin.hero-slides.index', 'admin.hero-slides.*', 'Hero', 'image'], ['admin.laporan.index', 'admin.laporan.*', 'Laporan', 'chart']] as [$route, $pola, $label, $ikon])
                        <a href="{{ route($route) }}" title="{{ $label }}" aria-current="{{ request()->routeIs($pola) ? 'page' : 'false' }}" class="relative flex items-center gap-3 px-3 py-2.5 rounded-lg min-h-[44px] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/60 {{ request()->routeIs($pola) ? 'bg-white/10 font-semibold text-white' : 'hover:bg-white/10 hover:text-white' }}">
                            @if (request()->routeIs($pola))
                                <span class="absolute left-0 top-2 bottom-2 w-1 rounded-full bg-[#C1121F]"></span>
                            @endif
                            <x-nav-icon :name="$ikon" />
                            <span x-show="!rail" x-cloak>{{ $label }}</span>
                        </a>
                    @endforeach
                    @hasanyrole('superadmin|owner')
                        <a href="{{ route('admin.users.index') }}" title="Users" aria-current="{{ request()->routeIs('admin.users.*') ? 'page' : 'false' }}" class="relative flex items-center gap-3 px-3 py-2.5 rounded-lg min-h-[44px] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/60 {{ request()->routeIs('admin.users.*') ? 'bg-white/10 font-semibold text-white' : 'hover:bg-white/10 hover:text-white' }}">
                            @if (request()->routeIs('admin.users.*'))
                                <span class="absolute left-0 top-2 bottom-2 w-1 rounded-full bg-[#C1121F]"></span>
                            @endif
                            <x-nav-icon name="user" />
                            <span x-show="!rail" x-cloak>Users</span>
                        </a>
                    @endhasanyrole
                </div>
            </div>
        @endhasanyrole
    </nav>
    <div class="px-3 py-3 border-t border-white/10 flex items-center gap-3">
        <a href="{{ route('profile.edit') }}" title="Profil" class="flex items-center gap-3 flex-1 min-w-0 rounded-lg min-h-[44px]">
            <span class="w-10 h-10 rounded-full bg-[#C1121F] text-white font-bold text-sm inline-flex items-center justify-center shrink-0" aria-hidden="true">{{ strtoupper(collect(explode(' ', Auth::user()->name ?? ''))->map(fn ($p) => mb_substr($p, 0, 1))->take(2)->implode('')) }}</span>
            <span x-show="!rail" class="flex-1 min-w-0" x-cloak>
                <span class="block font-medium text-[#16181D] truncate">{{ Auth::user()->name }}</span>
                <span class="block text-xs text-gray-400 capitalize">{{ Auth::user()?->getRoleNames()->first() ?? '-' }}</span>
            </span>
        </a>
        <form method="POST" action="{{ route('logout') }}" x-show="!rail" x-cloak class="shrink-0">
            @csrf
            <button type="submit" title="Keluar" aria-label="Keluar" class="p-2 rounded-lg text-gray-300 hover:text-white hover:bg-white/10 min-w-[44px] min-h-[44px] inline-flex items-center justify-center">
                <svg class="w-5 h-5 shrink-0" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path d="M14 4H5v16h9M11 8l4 4-4 4M15 12H3" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
        </form>
    </div>
</aside>
