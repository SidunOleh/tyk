<?php

use App\Services\Options\OptionService;

function get_content_value(string $name, mixed $default = null): mixed {
    static $content;

    if (! $content) {
        $content = (new OptionService)->get('content');
        $content = json_decode($content, true);
    }

    $value = $content[$name] ?? $default;

    return $value;
}