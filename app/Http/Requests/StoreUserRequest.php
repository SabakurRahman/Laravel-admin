<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    final public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    final public function rules(): array
    {
        return [
            'name'     => 'required|max:255|min:3',
            'email'    => 'required|max:255|min:3|email|unique:users',
            'phone'    => 'required|digits:11|numeric|unique:users',
            'password' => 'required', 'string', 'min:8', 'confirmed',
        ];
    }
}
