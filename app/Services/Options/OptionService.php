<?php

namespace App\Services\Options;

use App\Models\Option;

class OptionService
{
    public function get(string $name): ?string
    {
        $option = Option::where('name', $name)->first();

        return $option?->value;
    }

    public function save(string $name, string $value): void
    {
        Option::updateOrCreate([
            'name' => $name,
        ], [
            'value' => $value,
        ]);
    }
}