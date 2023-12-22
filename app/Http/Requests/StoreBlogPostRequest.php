<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogPostRequest extends FormRequest
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
        return [
            "title"            =>"required|max:255|min:2",
            "slug"             => "required|max:255|min:2|unique:blog_posts",
            "description"      =>"required",
            "blog_category_id" => "required",
            "status"           =>"required|numeric",
            "type"             =>"required|numeric",
        ];
    }
}
