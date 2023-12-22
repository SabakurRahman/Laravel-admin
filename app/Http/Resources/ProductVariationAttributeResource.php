<?php

namespace App\Http\Resources;

use App\Models\ProductAttribute;
use App\Http\Resources\AttributeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use PHPUnit\Event\TestSuite\Loaded;

class ProductVariationAttributeResource extends JsonResource
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
            'attribute_name' => $this->AttributeName->name,
            'value'          => $this->value,
        ];
    }
}

