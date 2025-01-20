<?php

namespace App\Http\Requests\Admin\Promotions;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
            'image' => 'required|string',
            'title' => 'required|string',
            'slug' => [
                'required',
                'string',
                Rule::unique('promotions', 'slug')->ignore(request()
                    ->route()
                    ->parameter('promotion')
                    ->id),
            ],
            'subtitle' => 'required|string',
            'text' => 'required|string',
        ];
    }
}
