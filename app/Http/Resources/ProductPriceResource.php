<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductPriceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
            'id'                        =>$this->id,
            'variation_id'              =>$this->variation_id,
            'product_id'                =>$this->product_id,
            'sub_total'                 =>$this->cost,
            'discount_amount'           =>$this->discount_info,
            'discount_percent'          =>$this->discount_percent,
            'grand_total'               =>$this->price,
            
            // 'discount_type'             =>$this->discount_type === 0 ? 'Manual' : ($this->discount_type === 1 ? 'Automatic': 'None'),
            // 'discount_info'             =>$this->discount_info,
            // 'old_price'                 =>$this->old_price,
            // 'discount_fixed'            =>$this->discount_fixed,
            // 'discount_percent'          =>$this->discount_percent,
            // 'discount_start'            =>Carbon::parse($this->discount_start)->format('D, M j, Y, H:i'),
            // 'discount_end'              =>Carbon::parse($this->discount_end)->format('D, M j, Y, H:i'),
            

        ];
    }
}
