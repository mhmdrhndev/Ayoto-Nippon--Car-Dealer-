<x-site-layout judul="Lacak SPK" robots="noindex, nofollow" deskripsi="Pantau status surat pemesanan kendaraan Anda di Ayoto Nippon.">
    <x-site-header />

    <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-8 sm:py-12">
        <div class="mb-8">
            <nav class="flex items-center gap-2 text-xs text-muted mb-2">
                <a href="{{ route('home') }}" class="hover:text-accent transition-colors">Beranda</a>
                <span>/</span>
                <span class="text-ink font-medium">Lacak SPK</span>
            </nav>
            <h1 class="text-2xl sm:text-4xl font-extrabold text-ink tracking-tight">Lacak Status Pemesanan SPK</h1>
            <p class="mt-2 text-sm sm:text-base text-muted max-w-3xl leading-relaxed">
                Pantau proses verifikasi pembayaran tanda jadi, alokasi nomor rangka kendaraan, penerbitan faktur, dan jadwal serah terima mobil baru Anda.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Form Column -->
            <div class="lg:col-span-7 xl:col-span-8 bg-surface border border-line rounded-3xl p-6 sm:p-10 shadow-xl shadow-black/5 relative overflow-hidden">
                <div class="absolute -top-20 -right-20 w-44 h-44 bg-accent-strong/10 rounded-full blur-2xl pointer-events-none"></div>

                <div class="relative pb-6 border-b border-line flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <p class="text-xs font-semibold tracking-wider text-accent uppercase">Pencarian Dokumen</p>
                        <h2 class="mt-1 text-xl sm:text-2xl font-bold text-ink">Masukkan Nomor Registrasi</h2>
                    </div>
                    <span class="inline-flex items-center gap-1.5 text-xs font-medium text-emerald-800 dark:text-emerald-300 bg-emerald-500/10 border border-emerald-500/20 px-3 py-1.5 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-700 animate-pulse"></span>
                        Sistem Online Real-Time
                    </span>
                </div>

                <form action="{{ route('lacak.cek') }}" method="POST" class="mt-8 space-y-6">
                    @csrf

                    <div>
                        <label for="no_spk" class="block text-xs font-semibold uppercase tracking-wider text-muted">Nomor Registrasi SPK</label>
                        <input id="no_spk" name="no_spk" value="{{ old('no_spk') }}" required 
                            placeholder="Contoh: SPK-2026-0001"
                            class="mt-1.5 w-full bg-surface border border-line rounded-xl text-ink placeholder-gray-500 font-mono text-base tracking-wider focus:border-accent focus:ring-1 focus:ring-accent min-h-[52px] px-4 uppercase">
                        <p class="mt-2 text-xs text-muted">Nomor SPK diawali dengan format SPK- diikuti tahun dan digit unik.</p>
                    </div>

                    <x-input-error :messages="$errors->all()" class="text-accent text-xs" />

                    <button type="submit" 
                        class="w-full py-4 px-6 font-bold text-sm text-white bg-accent-strong hover:bg-[#9E0E19] rounded-xl min-h-[48px] shadow-lg shadow-accent/25 transition-all flex items-center justify-center gap-2 active:scale-[0.99]">
                        <span>Lacak Dokumen Sekarang</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </form>

                <div class="mt-8 pt-5 border-t border-line text-xs text-muted text-center">
                    <span>Sudah memiliki akun pelanggan? Buka </span>
                    <a href="{{ route('pesanan.index') }}" class="font-semibold text-ink hover:text-accent underline underline-offset-2 transition-colors">Menu Pesanan Saya</a>
                    <span> untuk melihat riwayat lengkap.</span>
                </div>
            </div>

            <!-- Sidebar Guidance Column -->
            <div class="lg:col-span-5 xl:col-span-4 space-y-6 lg:sticky lg:top-24">
                <div class="bg-surface border border-line rounded-3xl p-6 sm:p-8 shadow-xl shadow-black/5">
                    <h3 class="font-bold text-base text-ink pb-4 border-b border-line">Di Mana Menemukan Nomor SPK?</h3>
                    <ul class="mt-5 space-y-4 text-xs text-muted leading-relaxed">
                        <li class="flex items-start gap-3">
                            <span class="text-accent mt-0.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 7l9 6 9-6"/></svg></span>
                            <div>
                                <strong class="text-ink block">Email Konfirmasi Pemesanan</strong>
                                Cek inbox atau folder spam email Anda dengan pengirim resmi PT Ayoto Nippon.
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-accent mt-0.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 12a8 8 0 01-8 8H8l-4 1 1-4a8 8 0 1116-5z"/></svg></span>
                            <div>
                                <strong class="text-ink block">WhatsApp Notifikasi</strong>
                                Nomor SPK otomatis dikirim ke nomor WhatsApp yang didaftarkan saat pemesanan.
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-accent mt-0.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 3H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V8l-5-5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 3v5h5"/></svg></span>
                            <div>
                                <strong class="text-ink block">Lembar Fisik SPK Dealer</strong>
                                Tertera di pojok kanan atas lembar cetak Surat Pesanan Kendaraan dari sales consultant.
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="bg-surface border border-line rounded-3xl p-6 shadow-xl shadow-black/5">
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-muted mb-2">Lupa Nomor SPK?</h4>
                    <p class="text-xs text-muted leading-relaxed">
                        Hubungi customer service dealer kami dengan menyebutkan nama lengkap pemesan dan nomor KTP untuk pencarian manual.
                    </p>
                    <a href="{{ route('cabang.index') }}" class="mt-4 inline-flex items-center justify-center w-full py-2.5 px-4 rounded-xl bg-surface-2 border border-line text-ink font-bold text-xs hover:border-accent transition-colors">
                        Hubungi Layanan Pelanggan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <x-site-footer />
</x-site-layout>
