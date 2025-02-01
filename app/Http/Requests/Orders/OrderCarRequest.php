<?php

namespace App\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;

class OrderCarRequest extends FormRequest
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
            'service' => 'required|string|in:Таксі,Кур\'єр',
            'from' => 'array|required',
            'from.address' => 'required|string',
            'from.lat' => 'required|numeric|between:-90,90',
            'from.lng' => 'required|numeric|between:-180,180',
            'to' => 'array|required',
            'to.address' => 'required|string',
            'to.lat' => 'required|numeric|between:-90,90',
            'to.lng' => 'required|numeric|between:-180,180',
            'time' => 'date_format:Y-m-d H:i:s|nullable',
            'payment_method' => 'required|in:Готівка,Карта',
        ];
    }
}
