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
        ];
    }
}
