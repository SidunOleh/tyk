<?php

namespace App\Http\Requests\Admin\Tariffs;

use App\Models\Tariff;
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
            'name' => 'required|string',
            'type' => 'required|in:'.Tariff::FIXED.','.Tariff::MIXED.','.Tariff::PER_KM,
            'fixed_price' => 'required_if:type,'.Tariff::FIXED.','.Tariff::MIXED.'|numeric|min:0|nullable',
            'fixed_up_to_km' => 'required_if:type,'.Tariff::MIXED.'|numeric|min:0|nullable',
            'per_km' => 'required_if:type,'.Tariff::PER_KM.','.Tariff::MIXED.'|numeric|min:0|nullable',
            'color' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'fixed_price.required_if' => 'Поле фіксована ціна є обов\'язковим, коли тариф фіксований, змішаний.',
            'fixed_up_to_km.required_if' => 'Поле фіксована до км є обов\'язковим, коли тариф змішаний.',
            'per_km.required_if' => 'Поле ціна за км є обов\'язковим, коли тариф за км, змішаний.',
        ];
    }
}
