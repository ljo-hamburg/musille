<?php

declare(strict_types=1);

namespace LJO\Musille;

class Filters {

    public static function init(): void {
        add_filter('excerpt_length', [Filters::class, 'excerptLength']);
        add_filter('excerpt_more', [Filters::class, 'excerptMore']);
        add_filter('widget_text', 'do_shortcode');
    }

    public static function excerptLength($length): int {
        return 40;
    }

    public static function excerptMore($more): string {
        return '…';
    }
}
