<?php

namespace App\Http\Requests\Admin\Users;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

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
            'phone' => 'string|regex:/^\([0-9]{3}\) [0-9]{3}-[0-9]{2}-[0-9]{2}$/|nullable',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore(request()
                    ->route()
                    ->parameter('user')
                    ->id),
            ],
            'password' => [
                Password::min(8),
                'nullable',
            ],
            'role' => 'required|string',
            'courier_id' => 'required_if:role,'.User::COURIER.'|exists:couriers,id|nullable',
            'phonet_number' => 'string|nullable',
        ];
    }
}
