<?php

namespace App\Http\Requests\Admin\Categories;

use Illuminate\Foundation\Http\FormRequest;
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
            'name' => 'required|string',
            'slug' => [
                'required',
                'string',
                Rule::unique('categories', 'slug')->ignore(request()
                    ->route()
                    ->parameter('category')
                    ->id),
            ],
            'image' => 'string|nullable',
            'description' => 'string|nullable',
            'parent_id' => 'exists:categories,id|nullable',
            'visible' => 'boolean',
            'tags' => 'array',
            'tags.*' => 'exists:category_tags,id',
            'upsells' => 'array',
            'upsells' => 'exists:products,id',
            'start_hour' => 'date_format:H:i:s|nullable',
            'end_hour' => 'date_format:H:i:s|nullable',
        ];
    }
}
