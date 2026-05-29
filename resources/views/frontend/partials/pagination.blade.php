@if ($paginator->hasPages())
    <nav class="site-pagination" aria-label="Pagination">
        <div class="pagination-shell">
            @if ($paginator->onFirstPage())
                <span class="page-step is-disabled" aria-disabled="true">Précédent</span>
            @else
                <a class="page-step" href="{{ $paginator->previousPageUrl() }}" rel="prev">Précédent</a>
            @endif

            <ul class="pagination-pages">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li><span class="page-dot">{{ $element }}</span></li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li><span class="page-number is-active" aria-current="page">{{ $page }}</span></li>
                            @else
                                <li><a class="page-number" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </ul>

            @if ($paginator->hasMorePages())
                <a class="page-step" href="{{ $paginator->nextPageUrl() }}" rel="next">Suivant</a>
            @else
                <span class="page-step is-disabled" aria-disabled="true">Suivant</span>
            @endif
        </div>

        <p class="pagination-summary">
            Affichage {{ $paginator->firstItem() }} à {{ $paginator->lastItem() }} sur {{ $paginator->total() }}
        </p>
    </nav>
@endif
