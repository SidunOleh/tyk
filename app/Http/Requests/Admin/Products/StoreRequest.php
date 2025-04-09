<?php

namespace App\Http\Requests\Admin\Products;

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
            'slug' => 'required|string|unique:products,slug',
            'price' => 'required|numeric|min:0',
            'image' => 'string|nullable',
            'description' => 'string|nullable',
            'ingredients' => 'string|nullable',
            'weight' => 'string|nullable',
            'categories' => 'array',
            'categories.*' => 'required|exists:categories,id',
            'packaging' => 'array',
            'packaging.*' => 'required|exists:products,id',
        ];
    }
}
