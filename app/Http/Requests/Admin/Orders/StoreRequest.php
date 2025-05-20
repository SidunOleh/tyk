<?php

namespace App\Http\Requests\Admin\Orders;

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
            'service' => 'required|string',
            'shipping_price' => 'numeric|min:0',
            'additional_costs' => 'numeric|min:0',
            'time' => 'date_format:Y-m-d H:i:s|nullable',
            'duration' => 'required|integer|min:1',
            'notes' => 'string|nullable',
            'client_id' => 'required|exists:clients,id',
            'paid' => 'required|boolean',
            'payment_method' => 'required_if:paid,true|string|nullable',
            'created_at' => 'date_format:Y-m-d H:i:s|nullable',
            'use_bonuses' => 'required|boolean',
            
            'details' => 'required|array',

            'details.food_to' => 'required_if:service,Доставка їжі|array|min:1',
            'details.food_to.*' => 'array',
            'details.food_to.*.address' => 'required_if:service,Доставка їжі|string',
            'details.food_to.*.lat' => 'required_if:service,Доставка їжі|numeric|between:-90,90',
            'details.food_to.*.lng' => 'required_if:service,Доставка їжі|numeric|between:-180,180',
            'details.cooking_time' => 'date_format:Y-m-d H:i:s|nullable',
            'order_items' => 'required_if:service,Доставка їжі|array|min:1',
            'order_items.*.name' => 'required_if:service,Доставка їжі|string',
            'order_items.*.amount' => 'required_if:service,Доставка їжі|numeric|min:0',
            'order_items.*.quantity' => 'required_if:service,Доставка їжі|integer|min:1',
            'order_items.*.product_id' => 'required_if:service,Доставка їжі|exists:products,id',

            'details.shipping_type' => 'required_if:service,Кур\'єр|string',
            'details.shipping_from' => 'required_if:service,Кур\'єр|array',
            'details.shipping_from.address' => 'required_if:service,Кур\'єр|string',
            'details.shipping_from.lat' => 'required_if:service,Кур\'єр|numeric|between:-90,90',
            'details.shipping_from.lng' => 'required_if:service,Кур\'єр|numeric|between:-180,180',
            'details.shipping_to' => 'required_if:service,Кур\'єр|array|min:1',
            'details.shipping_to.*' => 'array',
            'details.shipping_to.*.address' => 'required_if:service,Кур\'єр|string',
            'details.shipping_to.*.lat' => 'required_if:service,Кур\'єр|numeric|between:-90,90',
            'details.shipping_to.*.lng' => 'required_if:service,Кур\'єр|numeric|between:-180,180',

            'details.taxi_from' => 'required_if:service,Таксі|array',
            'details.taxi_from.address' => 'required_if:service,Таксі|string',
            'details.taxi_from.lat' => 'required_if:service,Таксі|numeric|between:-90,90',
            'details.taxi_from.lng' => 'required_if:service,Таксі|numeric|between:-180,180',
            'details.taxi_to' => 'required_if:service,Таксі|array|min:1',
            'details.taxi_to.*' => 'array',
            'details.taxi_to.*.address' => 'required_if:service,Таксі|string',
            'details.taxi_to.*.lat' => 'required_if:service,Таксі|numeric|between:-90,90',
            'details.taxi_to.*.lng' => 'required_if:service,Таксі|numeric|between:-180,180',
        ];
    }

    public function messages()
    {
        return [
            'payment_method.required_if' => 'Поле метод оплати є обов\'язковим, коли оплачено.',
            'details.order_items.min' => 'Замовлення повинно містити хоча б 1 елементів.',
            'details.order_items.required_if' => 'Замовлення є обов\'язковим, коли сервіс Доставка їжі.',
        ];
    }
}
