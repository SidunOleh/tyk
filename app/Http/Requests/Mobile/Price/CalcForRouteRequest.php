<?php

namespace App\Http\Requests\Mobile\Price;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class CalcForRouteRequest extends FormRequest
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
            'service' => 'required|in:' . Order::TAXI . ',' . Order::SHIPPING . ',' . Order::FOOD_SHIPPING,
            'courier_service' => 'string|nullable',
            'route' => 'required|array|min:2',
            'route.*' => 'array',
            'route.*.lat' => 'numeric|between:-90,90', 
            'route.*.lng' => 'numeric|between:-180,180',
        ];
    }
}
