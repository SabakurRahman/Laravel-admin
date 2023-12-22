<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                      => $this->id,
            'product_variation_photo' => new ProductPhotoResource($this->productVariationPhoto),
            'variation_attributes'    => ProductVariationAttributeResource::collection($this->variationAttributes),
            'variation_price'         => new ProductPriceResource($this->productPrice),
            'variation_inventory'     => new InventoriesResource($this->productInventory),
        ];
    }
}
