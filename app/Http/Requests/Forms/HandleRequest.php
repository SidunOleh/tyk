<?php

namespace App\Http\Requests\Forms;

use Illuminate\Foundation\Http\FormRequest;

class HandleRequest extends FormRequest
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
            'phone' => 'required|string|regex:/^\([0-9]{3}\) [0-9]{3}-[0-9]{2}-[0-9]{2}$/',
            'email' => 'required|email',
            'message' => 'string|nullable',
        ];
    }
}
