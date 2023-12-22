<?php

namespace App\Http\Resources;

use App\Manager\ProductVariationManager;
use App\Models\ProductPhoto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                     => $this->id,
            'product_id'             => $this->product_id,
            'name'                   => $this->name,
            'slug'                   => $this?->slug,
            'sku'                    => $this->sku,
            'photo'                  => !empty($this->photo) ? url(ProductPhoto::PHOTO_UPLOAD_PATH_THUMB . $this->photo) : url('images/default.webp'),
            'quantity'               => $this->quantity,
            'unit_price'             => $this->unit_price,
            'payable_price'          => $this->payable_price,
            'discount_amount'        => $this->discount_amount,
            'total_amount'           => $this->total_amount,
            'discount_text'          => $this->discount_text,
            'order_items_attributes' => OrderItemAttributesResource::collection($this->order_items_attributes),
        ];
    }
}
