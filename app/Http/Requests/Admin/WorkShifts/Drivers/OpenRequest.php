<?php

namespace App\Http\Requests\Admin\WorkShifts\Drivers;

use Illuminate\Foundation\Http\FormRequest;

class OpenRequest extends FormRequest
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
            'courier_id' => 'required|exists:couriers,id',
            'car_id' => 'required|exists:cars,id',
            'start' => 'required|date_format:Y-m-d H:i:s',
            'approximate_end' => 'date_format:Y-m-d H:i:s|nullable',
            'exchange_office' => 'required|numeric|min:0',
        ];
    }
}
