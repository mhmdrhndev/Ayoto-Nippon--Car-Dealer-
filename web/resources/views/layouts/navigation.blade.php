<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex flex-1 min-w-0">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex flex-1 items-stretch justify-center">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    @hasanyrole('sales|admin-cabang|pimpinan|superadmin|owner')
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 {{ request()->routeIs('admin.verify.*', 'admin.leads.*', 'admin.units.*', 'admin.test-drives.*', 'admin.trade-ins.*') ? 'border-indigo-400 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} focus:outline-none transition duration-150 ease-in-out">
                                    <div>Penjualan</div>
                                    <div class="ms-1"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('admin.verify.index')">Verifikasi SPK</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.leads.index')">Leads</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.units.index')">Stok Unit</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.test-drives.index')">Test Drive</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.trade-ins.index')">Trade-In</x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    @endhasanyrole
                    @hasanyrole('service-advisor|mekanik|admin-cabang|pimpinan|superadmin|owner')
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 {{ request()->routeIs('admin.services.*', 'admin.spareparts.*', 'admin.sparepart-orders.*') ? 'border-indigo-400 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} focus:outline-none transition duration-150 ease-in-out">
                                    <div>Bengkel</div>
                                    <div class="ms-1"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('admin.services.index')">Servis</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.spareparts.index')">Sparepart</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.sparepart-orders.index')">Order Part</x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    @endhasanyrole
                    @hasanyrole('superadmin|pimpinan|admin-cabang|owner')
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 {{ request()->routeIs('admin.brands.*', 'admin.models.*', 'admin.variants.*', 'admin.colors.*', 'admin.leasings.*', 'admin.branches.*', 'admin.promos.*', 'admin.contents.*', 'admin.hero-slides.*', 'admin.laporan.*', 'admin.users.*') ? 'border-indigo-400 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} focus:outline-none transition duration-150 ease-in-out">
                                    <div>Kelola</div>
                                    <div class="ms-1"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('admin.brands.index')">Brand</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.models.index')">Model</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.variants.index')">Varian</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.colors.index')">Warna</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.leasings.index')">Leasing</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.branches.index')">Cabang</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.promos.index')">Promo</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.contents.index')">Konten</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.hero-slides.index')">Hero</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.laporan.index')">Laporan</x-dropdown-link>
                                @hasanyrole('superadmin|owner')
                                    <x-dropdown-link :href="route('admin.users.index')">Users</x-dropdown-link>
                                @endhasanyrole
                            </x-slot>
                        </x-dropdown>
                    @endhasanyrole
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @hasanyrole('sales|admin-cabang|pimpinan|superadmin|owner')
                <x-responsive-nav-link :href="route('admin.verify.index')" :active="request()->routeIs('admin.verify.*')">Verifikasi</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.leads.index')" :active="request()->routeIs('admin.leads.*')">Leads</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.units.index')" :active="request()->routeIs('admin.units.*')">Stok</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.test-drives.index')" :active="request()->routeIs('admin.test-drives.*')">Test Drive</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.trade-ins.index')" :active="request()->routeIs('admin.trade-ins.*')">Trade-In</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.spareparts.index')" :active="request()->routeIs('admin.spareparts.*')">Sparepart</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.sparepart-orders.index')" :active="request()->routeIs('admin.sparepart-orders.*')">Order Part</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.promos.index')" :active="request()->routeIs('admin.promos.*')">Promo</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.contents.index')" :active="request()->routeIs('admin.contents.*')">Konten</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.hero-slides.index')" :active="request()->routeIs('admin.hero-slides.*')">Hero</x-responsive-nav-link>
            @endhasanyrole
            @hasanyrole('superadmin|pimpinan|admin-cabang|owner')
                <x-responsive-nav-link :href="route('admin.brands.index')" :active="request()->routeIs('admin.brands.*')">Brand</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.models.index')" :active="request()->routeIs('admin.models.*')">Model</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.variants.index')" :active="request()->routeIs('admin.variants.*')">Varian</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.colors.index')" :active="request()->routeIs('admin.colors.*')">Warna</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.leasings.index')" :active="request()->routeIs('admin.leasings.*')">Leasing</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.branches.index')" :active="request()->routeIs('admin.branches.*')">Cabang</x-responsive-nav-link>
            @endhasanyrole
            @hasanyrole('superadmin|owner')
                <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">Users</x-responsive-nav-link>
            @endhasanyrole
            @hasanyrole('service-advisor|mekanik|admin-cabang|pimpinan|superadmin|owner')
                <x-responsive-nav-link :href="route('admin.services.index')" :active="request()->routeIs('admin.services.*')">Servis</x-responsive-nav-link>
            @endhasanyrole
            @hasanyrole('pimpinan|superadmin|owner|admin-cabang')
                <x-responsive-nav-link :href="route('admin.laporan.index')" :active="request()->routeIs('admin.laporan.*')">Laporan</x-responsive-nav-link>
            @endhasanyrole
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
