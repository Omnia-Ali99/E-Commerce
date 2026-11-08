@props([
    'categories',
    'level' => 0,
    'showImages' => false,
])

<ul class="customer-category-tree customer-category-tree--level-{{ $level }}">
    @foreach ($categories as $category)
        @php
            $children = $category->activeChildren ?? collect();
        @endphp

        <li class="customer-category-tree__item">
            <a href="{{ route('website.categories.products', $category->slug) }}" class="customer-category-tree__link">
                @if ($showImages && $level === 0)
                    <span class="customer-category-tree__image">
                        <img src="{{ asset($category->icon ?: 'assets/website/assets/images/homepage-one/empty-wishlist.webp') }}"
                            alt="{{ $category->name }}">
                    </span>
                @endif

                <span class="customer-category-tree__name">{{ $category->name }}</span>

                @if ($children->isNotEmpty())
                    <span class="customer-category-tree__count">{{ $children->count() }}</span>
                @endif
            </a>

            @if ($children->isNotEmpty())
                @include('website.partials.category-tree', [
                    'categories' => $children,
                    'level' => $level + 1,
                    'showImages' => false,
                ])
            @endif
        </li>
    @endforeach
</ul>