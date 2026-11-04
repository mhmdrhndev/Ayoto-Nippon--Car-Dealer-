<x-site-layout judul="{{ $content->judul }}" deskripsi="{{ \Illuminate\Support\Str::limit(strip_tags($content->isi), 150) }}">
    <x-site-header />

    <div class="w-full px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-3xl p-6 sm:p-10 shadow-2xl shadow-black/5 w-full">
            <div class="pb-6 border-b border-[#E5E7EB]">
                <p class="text-xs font-semibold tracking-wider text-[#C1121F] uppercase">Informasi Resmi</p>
                <h1 class="mt-1 text-2xl sm:text-3xl font-extrabold text-[#16181D] tracking-tight">{{ $content->judul }}</h1>
            </div>

            <div class="mt-6 text-sm sm:text-base text-[#4B5563] leading-relaxed whitespace-pre-line">
                {{ $content->isi }}
            </div>
        </div>
    </div>

    <x-site-footer />
</x-site-layout>
