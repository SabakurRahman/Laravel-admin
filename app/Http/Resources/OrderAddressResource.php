<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderAddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'street_address' => $this->street_address,
            'phone'          => $this->phone,
            'zip_code'       => $this->zip_code,
            'landmark'       => $this->landmark,
            'division'       => $this->division?->name,
            'city'           => $this->city?->name,
            'zone'           => $this->zone?->name,
        ];
    }
}
