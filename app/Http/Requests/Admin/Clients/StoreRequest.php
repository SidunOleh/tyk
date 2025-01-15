<?php

namespace App\Http\Requests\Admin\Clients;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'full_name' => 'required|string',
            'phone' => 'required|string|regex:/^\+38\([0-9]{3}\) [0-9]{3}-[0-9]{2}-[0-9]{2}$/|unique:clients,phone',
            'addresses' => 'required|array|min:1',
            'addresses.*' => 'required|string',
        ];
    }
}
