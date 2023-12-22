<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBlogCategoryRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        //dd($this);
        return [
            "name"   =>"required|max:255|min:2",
            "slug" => [
                "required",
                "max:255",
                "min:2",
                Rule::unique('blog_categories')->ignore($this->route('blog_category')),
            ],
            "status" => "required|numeric",
            "type"   =>"required|numeric"
        ];
    }
}
