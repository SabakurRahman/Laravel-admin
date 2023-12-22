<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UniqueUnitPriceCombination;

class UpdateUnitPriceRequest extends FormRequest
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
                // 'type' => [
                //     'required',
                //     new UniqueUnitPriceCombination(
                //         $this->input('estimate_category_id'),
                //         $this->input('estimate_sub_category_id')
                //     ),
                // ],

            ];
    }
}
