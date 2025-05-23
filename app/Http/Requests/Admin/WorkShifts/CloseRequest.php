<?php

namespace App\Http\Requests\Admin\WorkShifts;

use Illuminate\Foundation\Http\FormRequest;

class CloseRequest extends FormRequest
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
            'food_shipping_count' => 'required|numeric|min:0',
            'food_shipping_bonuses' => 'required|numeric|min:0',
            'food_shipping_total' => 'required|numeric|min:0',
            'shipping_count' => 'required|numeric|min:0',
            'shipping_bonuses' => 'required|numeric|min:0',
            'shipping_total' => 'required|numeric|min:0',
            'taxi_count' => 'required|numeric|min:0',
            'taxi_bonuses' => 'required|numeric|min:0',
            'taxi_total' => 'required|numeric|min:0',
        ];
    }
}
