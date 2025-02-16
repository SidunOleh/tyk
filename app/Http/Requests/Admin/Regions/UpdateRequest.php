<?php

namespace App\Http\Requests\Admin\Regions;

use Illuminate\Foundation\Http\FormRequest;

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
            'points' => 'required|array|min:3',
            'points.*' => 'array|size:2',
            'points.*.lat' => 'numeric|between:-90,90',
            'points.*.lng' => 'numeric|between:-180,180',
            'tariff_id' => 'required|exists:tariffs,id',
        ];
    }
}
