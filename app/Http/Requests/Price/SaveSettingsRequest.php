<?php

namespace App\Http\Requests\Price;

use Illuminate\Foundation\Http\FormRequest;

class SaveSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'call' => 'required|numeric|min:0',
            'stop' => 'required|numeric|min:0',
            'courier_services' => 'required|array',
            'courier_services.*' => 'array',
            'courier_services.*.service' => 'string',
            'courier_services.*.price' => 'numeric|min:0',
        ];
    }
}
