<?php

namespace App\Http\Resources;
use App\Models\Product;
use App\Models\ProductPhoto;
use App\Models\Shipping;
// use App\Http\Resources\InventoriesResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         $status = '';

        if ($this->is_published === Product::STATUS_PENDING) {
            $status = 'Pending';
        } elseif ($this->is_published === Product::STATUS_PUBLISHED) {
            $status = 'Published';
        } else {
            $status = 'Not Published';
        }
        $inventoryData = null;
        if ($this->inventories) {
            $inventoryData = new InventoriesResource($this->inventoriesForApi->first());
        }


        return [
            'id'                   => $this->id,
            'title'                => $this->title,
            'slug'                 => $this->slug,
            'product_type'         => $this->product_type,
            'product_type_text'    => $this->product_type == 1 ?'Simple':'Grouped By Variation',
            'photo'                => $this->ProductPhotos->isEmpty() ? null : url(ProductPhoto::PHOTO_UPLOAD_PATH . $this->ProductPhotos->first()->photo),
            'price'                => $this->product_price->price,
            // 'photo_alt'            => $this->ProductPhotos->isEmpty() ? null : $this->ProductPhotos->first()->alt_text,
            // 'product_type'         => $this->product_type,
            // 'product_type_text'    => $this->product_type == 1 ? 'Simple':'Grouped With Variation',
            'category'             => $this->categories->pluck('slug')->implode(', '),

            // 'Price'                => $this->prices->map(function ($price) {
            //                             return [
            //                                 'id' => $price->id,
            //                                 'variation_id'=> $price->variation_id,
            //                                 'price' => $price->price,
            //                                 'payable_price'=>0,
            //                                 'discount_text'=>null,
            //                                 'discount' => 0,
            //                             ];

            //                         })->toArray(),

            // 'Price'                => $this->product_price ? new ProductPriceResource($this->product_price) : null,
            // 'price'                => new ProductPriceResource($this->product_price),
            // 'inventory'            => new InventoriesResource($this->inventories),

            // 'inventory'            => $this->inventories ? new InventoriesResource($this->inventories) : null,





            // 'inventory'             =>$this->inventoriesForApi->map(function($inventory){
            //                                 return[
            //                                     'variation_id'=> $inventory->variation_id,
            //                                     'stock' => $inventory->stock,
            //                                 ];
            //                             })->toArray(),
            // 'Specification'         => $this->specifications->map(function($specification){
            //                                 return[
            //                                     'name' => $specification->name,
            //                                     'value' => $specification->value,
            //                                 ];
            //                             })->toArray(),
            // 'shipping'              => $this->shipping ? new ShippingResource($this->shipping) : null,
            // 'warrenty'              => $this->warrenty ? new WarrentyResource($this->warrenty) : null,

            // 'Faqs'                 =>$this->faqs->map(function($faq){
            //                                 return[
            //                                     // 'faq id'=>$faq->faqable_id,
            //                                     'question_title' => $faq->question_title,
            //                                     'description'    => $faq->description,
            //                                     'status'         =>$faq->status==1 ? 'Active':'Inactive',
            //                                 ];
            //                             })->toArray(),
            // 'disable_by_button'    => $this->inventories->disable_buy_button ?? 0,
            // 'is_new'               => $this->is_new == 1 ? 'New' : 'Not New',
            // 'is_allow_review'      => $this->is_allow_review == 1 ? 'Allowed' : 'Not Allowed',
            // 'is_returnable'        => $this->inventories->is_returnable ?? 0,

            // for photo array / multile photo
            //   'photo' => $this->ProductPhotos->map(fn ($photo) => url(ProductPhoto::PHOTO_UPLOAD_PATH . $photo->photo))->toArray(),

        ];
    }

}


