<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateNewsLetterRequest extends FormRequest
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
            // "name"        => "required|max:255|min:2",
            "email"        =>  "required",
            "max:255",
            "email",
            Rule::unique('news_letters')->ignore($this->route('news-letter')),
      
            // "email"       => "required|unique:news_letters|max:255|email",
            "ip"          => "nullable|max:255|min:2",
            "status"      => "required|numeric",
            
          
        ];
    }
}
