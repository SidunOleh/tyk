<?php

namespace App\Http\Requests\Admin\Clients;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'phone' => [
                'required',
                'string',
                Rule::unique('clients')->ignore(request()
                    ->route()
                    ->parameter('client')
                    ->id),
            ],
            'addresses' => 'required|array|min:1',
            'addresses.*' => 'required|string',
        ];
    }
}