@if ($paginator->hasPages())
    <ul class="page-pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li><span class="next disabled"><span class="fa fa-angle-left"></span> Prev</span></li>
        @else
            <li><a class="next" href="{{ $paginator->previousPageUrl() }}" rel="prev"><span class="fa fa-angle-left"></span> Prev</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li><a class="page-numbers" href="#url">{{ $element }}</a></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li><span aria-current="page" class="page-numbers current">{{ $page }}</span></li>
                    @else
                        <li><a class="page-numbers" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a class="next" href="{{ $paginator->nextPageUrl() }}" rel="next">Next <span class="fa fa-angle-right"></span></a></li>
        @else
            <li><span class="next disabled">Next <span class="fa fa-angle-right"></span></span></li>
        @endif
    </ul>
@endif 