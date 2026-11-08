@php
    if (! isset($scrollTo)) {
        $scrollTo = 'body';
    }

    $scrollIntoViewJsSnippet = ($scrollTo !== false)
        ? <<<JS
           (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
        JS
        : '';
@endphp

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
                <li>
                    <button type="button" class="customer-page-link customer-page-link--nav"
                        wire:click="previousPage('{{ $paginator->getPageName() }}')"
                        x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled">
                        @lang('pagination.previous')
                    </button>
                </li>
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
                            <li>
                                <button type="button" class="customer-page-link"
                                    wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                    x-on:click="{{ $scrollIntoViewJsSnippet }}">
                                    {{ $page }}
                                </button>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li>
                    <button type="button" class="customer-page-link customer-page-link--nav"
                        wire:click="nextPage('{{ $paginator->getPageName() }}')"
                        x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled">
                        @lang('pagination.next')
                    </button>
                </li>
            @else
                <li><span class="customer-page-link is-disabled" aria-disabled="true">@lang('pagination.next')</span></li>
            @endif
        </ul>
    </nav>
@endif