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
            'schedule' => 'array|nullable',
            'schedule.0.start' => 'required_unless:schedule.0.end,null|date_format:H:i|nullable',
            'schedule.1.start' => 'required_unless:schedule.1.end,null|date_format:H:i|nullable',
            'schedule.2.start' => 'required_unless:schedule.2.end,null|date_format:H:i|nullable',
            'schedule.3.start' => 'required_unless:schedule.3.end,null|date_format:H:i|nullable',
            'schedule.4.start' => 'required_unless:schedule.4.end,null|date_format:H:i|nullable',
            'schedule.5.start' => 'required_unless:schedule.5.end,null|date_format:H:i|nullable',
            'schedule.6.start' => 'required_unless:schedule.6.end,null|date_format:H:i|nullable',
            'schedule.0.end' => 'required_unless:schedule.0.start,null|date_format:H:i|nullable',
            'schedule.1.end' => 'required_unless:schedule.1.start,null|date_format:H:i|nullable',
            'schedule.2.end' => 'required_unless:schedule.2.start,null|date_format:H:i|nullable',
            'schedule.3.end' => 'required_unless:schedule.3.start,null|date_format:H:i|nullable',
            'schedule.4.end' => 'required_unless:schedule.4.start,null|date_format:H:i|nullable',
            'schedule.5.end' => 'required_unless:schedule.5.start,null|date_format:H:i|nullable',
            'schedule.6.end' => 'required_unless:schedule.6.start,null|date_format:H:i|nullable',
        ];
    }
}
