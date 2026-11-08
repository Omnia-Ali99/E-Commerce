@if ($paginator->hasPages())
    <nav class="customer-pagination-nav" role="navigation" aria-label="Pagination Navigation">
        <div class="customer-pagination-summary">
            {{ __('website.showing') }}
            <strong>{{ $paginator->firstItem() }}</strong>
            -
            <strong>{{ $paginator->lastItem() }}</strong>
            {{ __('website.of') }}
            <strong>{{ $paginator->total() }}</strong>
        </div>

        <ul class="customer-pagination-list">
            @if ($paginator->onFirstPage())
                <li><span class="customer-page-link is-disabled" aria-disabled="true">@lang('pagination.previous')</span></li>
            @else
                <li><a class="customer-page-link customer-page-link--nav" href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('pagination.previous')</a></li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li><span class="customer-page-link is-disabled">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li><span class="customer-page-link is-active" aria-current="page">{{ $page }}</span></li>
                        @else
                            <li><a class="customer-page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li><a class="customer-page-link customer-page-link--nav" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('pagination.next')</a></li>
            @else
                <li><span class="customer-page-link is-disabled" aria-disabled="true">@lang('pagination.next')</span></li>
            @endif
        </ul>
    </nav>
@endif