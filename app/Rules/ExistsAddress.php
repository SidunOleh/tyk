<?php

namespace App\Rules;

use App\Services\Google\MapsService;
use Closure;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;

class ExistsAddress implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $response = (new MapsService)->geocoding($value);

            if (! $response) {
                $fail('Адреса не знайдена.');
            }
        } catch (Exception $e) {
            $fail('Адреса не знайдена.');
        }
    }
}
