<?php

namespace App\Http\Requests\Admin\Clients;

use App\Rules\ExistsAddress;
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
            'full_name' => 'required|string',
            'phone' => [
                'required',
                'string',
                'regex:/^\([0-9]{3}\) [0-9]{3}-[0-9]{2}-[0-9]{2}$/',
                Rule::unique('clients')->ignore(request()
                    ->route()
                    ->parameter('client')
                    ->id),
            ],
            'addresses' => 'array',
            'addresses.*' => [
                'required',
                'string',
                new ExistsAddress,
            ],
            'description' => 'string|nullable',
        ];
    }
}
