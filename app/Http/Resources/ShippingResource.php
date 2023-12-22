<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShippingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // 'id' => $this->id,
            'package_weight' => $this->package_weight,
            'height'         => $this->height,
            'width'          => $this->width,
            'length'         => $this->length,
            'product_type'   => $this->product_type == 1 ?'Residential Interior':
                             ($this->product_type == 2 ?'Commercial Interior':
                             ($this->product_type == 3 ?'Furniture':'Custom Lights'))
        ];
    }
}
