@section('styles')
    <style>
        .pagination .page-item .page-link {
            cursor: pointer;
        }

        .pagination .page-item:not(.active) .page-link:hover {
            --bs-bg-opacity: .2;
            background-color: rgba(var(--bs-primary-rgb), var(--bs-bg-opacity)) !important;
        }
    </style>
@endsection

@if ($paginator->hasPages())
    <nav aria-label="Pagination">
        <ul class="pagination">
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link bg-dark text-light bg-opacity-75" aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link bg-dark text-light bg-opacity-75" href="{{ $paginator->previousPageUrl() }}"
                       aria-label="@lang('pagination.previous')">
                        <span aria-hidden="true">&lsaquo;</span>
                    </a>
                </li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span
                            class="page-link bg-dark text-light bg-opacity-75">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span
                                    class="page-link bg-primary border-light text-light bg-opacity-75">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item"><a class="page-link bg-dark text-light bg-opacity-75"
                                                     href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link bg-dark text-light bg-opacity-75" href="{{ $paginator->nextPageUrl() }}"
                       rel="next"
                       aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link bg-dark text-light bg-opacity-75" aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
