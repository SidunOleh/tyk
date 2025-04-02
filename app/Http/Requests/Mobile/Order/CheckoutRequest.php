<?php

namespace App\Http\Requests\Mobile\Order;

use App\Rules\ExistsAddress;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'full_name' => 'required|string',
            'phone' => [
                'required',
                'regex:/^\([0-9]{3}\) [0-9]{3}-[0-9]{2}-[0-9]{2}$/',
                Auth::check() 
                    ?  Rule::unique('clients', 'phone')->ignore(Auth::id()) 
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
            'use_bonuses' => 'required|boolean',
            'cart_items' => 'required|array|min:1',
            'cart_items.*.product_id' => 'required|exists:products,id',
            'cart_items.*.quantity' => 'required|integer|min:1',
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
