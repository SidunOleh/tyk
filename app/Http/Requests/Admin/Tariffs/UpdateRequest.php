<?php

namespace App\Http\Requests\Admin\Tariffs;

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
            'name' => 'required|string',
            'fixed' => 'required|boolean',
            'fixed_price' => 'required_if:fixed,true|numeric|min:0|nullable',
            'per_km' => 'required_if:fixed,false|numeric|min:0|nullable',
            'color' => 'required|string',
        ];
    }
}
