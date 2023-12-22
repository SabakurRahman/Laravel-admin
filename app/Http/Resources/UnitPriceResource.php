<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitPriceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'estimate_category_id' => $this->estimate_category_id,
            'estimate_sub_category_id' => $this->estimate_sub_category_id,
            // 'unit_id' => $this->unit_id,
            'type' => $this->type,
           
        ];
    }
}
