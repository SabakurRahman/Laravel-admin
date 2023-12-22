<?php

namespace App\Http\Resources;

use App\Manager\ProductVariationManager;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    final public function toArray(Request $request): array
    {
        $variation_data = ProductVariationManager::handleCartVariationData($this, true);
        return [
            'id'                 => $this->id,
            'product_id'         => $this->product->id,
            'product_name'       => $this->product->title,
            'slug'               => $this->product->slug,
            'quantity'           => $this->quantity,
            'variation_id'       => $this->variation_id,
            'photo'              => $variation_data['photo'],
            'discount_amount'    => $variation_data['discount_amount'] * $this->quantity,
            'discount_text'      => $variation_data['discount_text'],
            'unit_price'         => $this->product->price->price,
            'sub_total'          => $variation_data['price'] * $this->quantity,
            'payable_price'      => $variation_data['payable_price'] * $this->quantity,
            'created_at'         => $this->created_at->toDayDateTimeString(),
            'product_attributes' => ProductVariationManager::handleCartProductAttributes($this),

        ];
    }
}
