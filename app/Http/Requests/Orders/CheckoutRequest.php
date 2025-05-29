<?php

namespace App\Http\Requests\Orders;

use App\Rules\ExistsAddress;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CheckoutRequest extends FormRequest
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
                'regex:/^\([0-9]{3}\) [0-9]{3}-[0-9]{2}-[0-9]{2}$/',
                auth('web')->check() 
                    ?  Rule::unique('clients', 'phone')->ignore(Auth::guard('web')->id()) 
                    : '',
            ],
            'address' => [
                'required',
                'string',
                new ExistsAddress,
            ],
            'delivery_time' => 'date_format:H:i|nullable',
            'notes' => 'string|nullable',
            'payment_method' => 'required|in:Готівка,Карта',
            'use_bonuses' => 'sometimes|accepted',
            'callback' => 'sometimes|accepted',
        ];
    }

    public function messages()
    {
        return [
            'phone.unique' => 'Номер зайнятий.',
            'delivery_time.date_format' => 'Поле час доставки є некоректним.',
        ];
    }
}
