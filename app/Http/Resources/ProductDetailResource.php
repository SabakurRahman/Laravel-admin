<?php

namespace App\Http\Resources;
use Carbon\Carbon;
use App\Models\Seo;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $productAttributesGrouped = $this->productAttributesAll->groupBy('AttributeName.name');
        $productVariationsAttributeList = $productAttributesGrouped->map(function ($attributes, $attributeName) {
            $uniqueValues = $attributes->pluck('value')->unique()->values()->toArray();
            return [
                'name' => $attributeName,
                'value' => $uniqueValues,
            ];
        })->values();

        return [
            'id'                    => $this->id,
            'title'                 => $this->title,
            'slug'                  => $this->slug,
            'photo'                 => ProductPhotoResource::collection($this->ProductPhotos->where('variation_id', null)),
            'seo'                   => $this->seos ? new SeoResource($this->seos) : null,
            'price'                 => $this->product_price ? new ProductPriceResource($this->product_price) : null,
            'inventory'             => $this->inventories ? new InventoriesResource($this->inventories) : null,
            'sku'                   => $this->sku,
            'model'                 => $this->model,
            'product_type'          => $this->product_type,
            'product_type_text'     => $this->product_type == 1 ? 'Simple':'Grouped With Variation',
            'is_published'          => $this->is_published == 1? 'Pending' : ($this->is_published == 2? 'Published' : ' Not Published'),
            'is_show_on_home_page'  => $this->is_show_on_home_page == 1 ?'Yes' : 'No',
            'is_allow_review'       => $this->is_allow_review == 1 ? 'Allowed' : 'Not Allowed',
            'is_new'                => $this->is_new == 1 ? 'New' : 'Not New',
            'is_prime'              => $this->is_prime == 1 ? 'Prime' : 'Not Prime',
            'sort_order'            => $this->sort_order,
            'description'           => strip_tags(html_entity_decode($this->description)),
            'short_description'     => $this->short_description,
            'comment'               => $this->comment,
            'country'               => $this->country?->name,
            'manufacturer'          => $this->manufacture?->name,
            'vendor'                => $this->vendor?->name,
            'warehouse'             => WarehouseResource::collection($this->warehouses),
            'payment_method'        => PaymentMethodResource::collection($this->paymentMethods),
            'categories'            => CategoryListResource::collection($this->categories),
            'specification'         => SpecificationResource::collection($this->specifications),
            'shipping'              => $this->shipping ? new ShippingResource($this->shipping) : null,
            'warrenty'              => $this->warrenty ? new WarrentyResource($this->warrenty) : null,
            'faqs'                  => FaqResource::collection($this->faqs),
            'related_products'      => ProductResource::collection($this->relatedProducts),
            'product_variations'    => ProductVariationResource::collection($this->productVariations),
            'product_variations_attribute_list' => $productVariationsAttributeList,
            // 'product_variations_attribute_list'    => ProductVariationsAttributeListResource::collection($this->productAttributesListForApi),
        
        ];


 
    }
}








