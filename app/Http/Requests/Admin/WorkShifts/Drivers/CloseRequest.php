<?php

namespace App\Http\Requests\Admin\WorkShifts\Drivers;

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
            'end' => 'required|date_format:Y-m-d H:i:s',
            'returned_amount' => 'required|numeric|min:0',
            'food_shipping_count' => 'required|numeric|min:0',
            'shipping_count' => 'required|numeric|min:0',
            'taxi_count' => 'required|numeric|min:0',
            'food_shipping_total' => 'required|numeric|min:0',
            'shipping_total' => 'required|numeric|min:0',
            'taxi_total' => 'required|numeric|min:0',
            'additional_costs' => 'required|numeric|min:0',
        ];
    }
}
