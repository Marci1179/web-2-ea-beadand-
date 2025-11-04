@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="pagination-wrap">
        <ul class="pagination">
            {{-- Előző --}}
            @if ($paginator->onFirstPage())
                <li class="disabled" aria-disabled="true">
                    <span class="btn ghost">Előző</span>
                </li>
            @else
                <li>
                    <a class="btn primary" href="{{ $paginator->previousPageUrl() }}" rel="prev">Előző</a>
                </li>
            @endif

            {{-- Számozás --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="disabled"><span class="btn ghost">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li><span class="btn primary">{{ $page }}</span></li>
                        @else
                            <li><a class="btn ghost" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Következő --}}
            @if ($paginator->hasMorePages())
                <li><a class="btn primary" href="{{ $paginator->nextPageUrl() }}" rel="next">Következő</a></li>
            @else
                <li class="disabled" aria-disabled="true">
                    <span class="btn ghost">Következő</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
