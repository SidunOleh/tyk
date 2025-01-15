<?php

namespace App\Http\Requests\Admin\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'string|regex:/^\+38\([0-9]{3}\) [0-9]{3}-[0-9]{2}-[0-9]{2}$/|nullable',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                Password::min(8),
            ],
            'role' => 'required|string',
        ];
    }
}
