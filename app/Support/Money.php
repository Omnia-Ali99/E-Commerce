<?php

namespace App\Support;

use Illuminate\Support\HtmlString;

class Money
{
    public static function format(int|float|string|null $amount): string
    {
        if ($amount === null || $amount === '') {
            return '';
        }

        if (! is_numeric($amount)) {
            return (string) $amount;
        }

        return rtrim(rtrim(number_format((float) $amount, 2, '.', ''), '0'), '.');
    }

    public static function render(int|float|string|null $amount, string $class = 'customer-money'): HtmlString
    {
        return new HtmlString(sprintf(
            '<span class="%s"><span class="customer-money__amount">%s</span> <span class="customer-money__currency">%s</span></span>',
            e($class),
            e(self::format($amount)),
            e(__('website.egp'))
        ));
    }
}