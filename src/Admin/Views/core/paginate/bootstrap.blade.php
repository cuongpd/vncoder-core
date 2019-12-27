@if ($paginator->hasPages())
<nav aria-label="Page Navigation">
    <ul class="pagination justify-content-end">
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><a class="page-link" href="javascript:void(0)">&laquo;</a></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif
        @foreach ($elements as $element)
            @if (is_string($element))
                    <li class="page-item disabled"><a class="page-link" href="javascript:void(0)">{{ $element }}</a></li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item current active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="page-item disabled"><a class="page-link" href="javascript:void(0)">&raquo;</a></li>
        @endif
    </ul>
</nav>
@endif
