<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use GoogleMaps;

class ExistsAddress implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $response = GoogleMaps::load('geocoding')
            ->setParamByKey('address', $value)
            ->get();
        $response = json_decode($response, true);

        if (! $response['results']) {
            $fail('Адреса не знайдена.');
        }
    }
}
