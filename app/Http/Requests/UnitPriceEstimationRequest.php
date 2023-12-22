<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitPriceEstimationRequest extends FormRequest
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
            'estimate_data'                            => ['required', 'array'],
            'estimate_data.*.estimate_category_id'     => ['required', 'numeric', 'exists:estimate_categories,id'],
            'estimate_data.*.estimate_sub_category_id' => ['required', 'numeric', 'exists:estimate_categories,id'],
            'estimate_data.*.type'                     => ['required', 'numeric'],
            'estimate_data.*.quantity'                 => ['required', 'numeric'],
            'user_data'                                => ['required', 'array'],
            'user_data.name'                           => ['required', 'string', 'max:255'],
            'user_data.email'                          => ['required', 'email'],
            'user_data.phone'                          => ['required', 'numeric', 'digits:11'],
        ];
    }
}
