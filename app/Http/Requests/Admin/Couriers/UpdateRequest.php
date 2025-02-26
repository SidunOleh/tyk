<?php

namespace App\Http\Requests\Admin\Couriers;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string|regex:/^\([0-9]{3}\) [0-9]{3}-[0-9]{2}-[0-9]{2}$/',
            'tg' => 'string|nullable',
            'vehicles' => 'required|array',
            'vehicles.*' => 'required|string',
        ];
    }
}
