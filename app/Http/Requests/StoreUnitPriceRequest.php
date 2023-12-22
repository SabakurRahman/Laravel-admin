<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UniqueUnitPriceCombination;

class StoreUnitPriceRequest extends FormRequest
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

    public function rules()
    {
        return [
            'type'                     => ['required', 'numeric'],
            'estimate_category_id'     => ['required', 'numeric', 'exists:estimate_categories,id'],
            'estimate_sub_category_id' => ['required', 'numeric', 'exists:estimate_categories,id'],
            'package'                  => ['required', 'array'],
            'package.*.unit_id'        => ['required', 'exists:units,id'],
            'package.*.price'          => ['required', 'numeric'],
            'package.*.max_size'       => ['required', 'numeric'],
            'package.*.min_size'       => ['required', 'numeric'],
        ];
    }
}
