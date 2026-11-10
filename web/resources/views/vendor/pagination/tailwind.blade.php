@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi halaman" class="flex items-center justify-between gap-3">
        <p class="text-sm text-muted">
            Halaman {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }}
        </p>
        <div class="flex items-center gap-1 flex-wrap justify-end">
            @if ($paginator->onFirstPage())
                <span class="px-3 py-2 text-sm text-muted border border-line rounded-lg min-h-[44px] inline-flex items-center">Sebelumnya</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="px-3 py-2 text-sm font-medium text-ink border border-line rounded-lg hover:border-ink min-h-[44px] inline-flex items-center">Sebelumnya</a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-2 py-2 text-sm text-muted min-h-[44px] inline-flex items-center">...</span>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page" class="px-3 py-2 text-sm font-bold text-white bg-accent-strong rounded-lg min-h-[44px] inline-flex items-center">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-3 py-2 text-sm font-medium text-ink border border-line rounded-lg hover:border-ink min-h-[44px] inline-flex items-center">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="px-3 py-2 text-sm font-medium text-ink border border-line rounded-lg min-h-[44px] inline-flex items-center">Berikutnya</a>
            @else
                <span class="px-3 py-2 text-sm text-muted border border-line rounded-lg min-h-[44px] inline-flex items-center">Berikutnya</span>
            @endif
        </div>
    </nav>
@endif
