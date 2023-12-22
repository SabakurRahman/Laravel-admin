<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
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
            'phone'          => 'required|numeric|digits:11',
            'division_id'    => 'required|numeric|exists:divisions,id',
            'city_id'        => 'required|numeric|exists:cities,id',
            'zone_id'        => 'required|numeric|exists:zones,id',
            'address_type'   => 'required|numeric',
            'is_default'     => 'required|numeric',
            'street_address' => 'required',
        ];
    }
}
