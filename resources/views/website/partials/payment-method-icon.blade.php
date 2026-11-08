@props(['method' => 'cards'])

@switch($method)
    @case('wallets')
    @case('vodafone_cash')
    @case('orange_cash')
    @case('etisalat_cash')
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
            aria-hidden="true">
            <path d="M6 7.5H18C19.1 7.5 20 8.4 20 9.5V17C20 18.1 19.1 19 18 19H6C4.9 19 4 18.1 4 17V7C4 5.9 4.9 5 6 5H17"
                stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M16 13H20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
            <path d="M16.5 13H16.51" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
        </svg>
        @break

    @case('link')
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
            aria-hidden="true">
            <path d="M9.5 14.5L14.5 9.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
            <path d="M10.8 7.2L12.1 5.9C13.8 4.2 16.6 4.2 18.3 5.9C20 7.6 20 10.4 18.3 12.1L17 13.4"
                stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M13.2 16.8L11.9 18.1C10.2 19.8 7.4 19.8 5.7 18.1C4 16.4 4 13.6 5.7 11.9L7 10.6"
                stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        @break

    @case('fawry')
    @case('aman')
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
            aria-hidden="true">
            <path d="M5 7H19V17H5V7Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
            <path d="M8 11H16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
            <path d="M8 14H13" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
            <path d="M7 4H17" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
            <path d="M7 20H17" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
        </svg>
        @break

    @case('valu')
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
            aria-hidden="true">
            <path d="M4 8.5H20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
            <path d="M7 15.5H17" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
            <path d="M6 5H18C19.1 5 20 5.9 20 7V17C20 18.1 19.1 19 18 19H6C4.9 19 4 18.1 4 17V7C4 5.9 4.9 5 6 5Z"
                stroke="currentColor" stroke-width="1.8" />
        </svg>
        @break

    @default
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
            aria-hidden="true">
            <rect x="3" y="5" width="18" height="14" rx="3" stroke="currentColor" stroke-width="1.8" />
            <path d="M3 10H21" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
            <path d="M7 15H10" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
        </svg>
@endswitch