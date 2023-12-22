<?php

namespace App\Manager;
use http\Url;
use Exception;
use Carbon\Carbon;
use JsonException;
use App\Models\Cart;
use App\Models\Product;
use App\Models\WishList;
use App\Models\Attribute;
use App\Models\Inventory;
use Illuminate\Support\Str;
use App\Models\ProductPhoto;
use App\Models\ProductPrice;
use Illuminate\Http\Request;
use App\Models\ProductAttribute;
use App\Models\ProductVariation;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\CartDetailResource;
use App\Http\Resources\OrderItemsResource;
use App\Models\ProductAttributeAssociation;
use App\Models\Attribute as ModelsAttribute;
use App\Http\Resources\ProductDetailResource;
use App\Http\Resources\WishlistDetailResource;
use App\Manager\ImageUploadManagerForVariation;
use App\Http\Resources\ProductDetailsApiResource;

class ProductVariationManager
{
    public Request $request;
    public Product $product;
    public ProductPrice $productPrice;
    public Inventory $inventory;

    /**
     * @throws JsonException
     * @throws Exception
     */
    final public function handleProductVariationStore(): void
    {
        $attribute_ids = [];
        foreach ($this->request->input('var_attribute') as $attribute_id) {
            $attribute_ids[] = $attribute_id['attribute_id'];
        }
        $product_attributes     = (new Attribute())->getProductAttributesByIds($attribute_ids);
        $product_existing_photo = ProductPhoto::query()->where('product_id', $this->product->id)->orderBy('serial')->first();
        foreach ($this->request->variations as $variations) {
            //  $variation_request_data = $variations['data'];
            $variation_request_data = json_decode($variations['data'], true, 512, JSON_THROW_ON_ERROR);
            $product_variation_data = [
                'product_id' => $this->product->id,
                'data'       => json_encode($variations['data'], JSON_THROW_ON_ERROR | true),
                'price'      => $variations['price'] ?? $this->productPrice->price,
                'stock'      => $variations['stock'] ?? $this->inventory->stock,
            ];

            $product_variation = ProductVariation::query()->create($product_variation_data);

            $variation_product_attribute_association_data = [];
            foreach ($variation_request_data as $key => $value) {
                $selected_product_attribute                     = $product_attributes->where('name', $key)->first();
                $variation_product_attribute_association_data[] = [
                    'attribute_id' => $selected_product_attribute->id,
                    'value'                => $value,
                    'product_id'           => $this->product->id,
                    'variation_id'         => $product_variation->id,
                    'created_at'           => Carbon::now(),
                    'updated_at'           => Carbon::now(),
                ];
            }
            ProductAttribute::query()->insert($variation_product_attribute_association_data);
            //single
            $variation_price_data = [
                'product_id'   => $this->product->id,
                'variation_id' => $product_variation->id,
                'price'        => $variations['price'] ?? $this->productPrice->price,
            ];
            ProductPrice::query()->create($variation_price_data);
            $variation_inventory_data = [
                'product_id'   => $this->product->id,
                'variation_id' => $product_variation->id,
                'stock'        => $variations['stock'] ?? $this->inventory->stock,
            ];
            Inventory::query()->create($variation_inventory_data);

            //single
            if (isset($variations['photo']) && !empty($variations['photo'])) {
                $variation_photo_data = [
                    'product_id'   => $this->product->id,
                    'variation_id' => $product_variation->id,
                    'alt_text'     => $this->product->slug,
                    'title'        => $this->product->name,
                    // 'photo'        => ImageUploadManager::processImageUpload(
                    'photo'        => ImageUploadManagerForVariation::processImageUpload(
                        $variations['photo'],
                        Str::slug($this->product->slug . '-' . Carbon::now()->toDayDateTimeString() . random_int(10000, 99999)),
                        ProductPhoto::PHOTO_UPLOAD_PATH,
                        ProductPhoto::PHOTO_WIDTH,
                        ProductPhoto::PHOTO_HEIGHT,
                        ProductPhoto::PHOTO_UPLOAD_PATH_THUMB,
                        ProductPhoto::PHOTO_WIDTH_THUMB,
                        ProductPhoto::PHOTO_HEIGHT_THUMB,
                        ''
                    ),
                ];
                ProductPhoto::query()->create($variation_photo_data);
            } else {

                $product_existing_photo?->replicate()->fill(
                    ['variation_id' => $product_variation->id, 'serial' => 300]
                )->save();
            }
        }
    }


    // public function processAndStorePhoto($photoData, $product, $productVariation)
    // {
    //     $photo = new ProductPhoto();
    //     $photo->product_id   = $product->id;
    //     $photo->variation_id = $productVariation->id;
    //     $photo->alt_text     = $product->slug;
    //     $photo->title        = $product->name;

    //     // Process and store the photo
    //     $photoPath = ImageUploadManager::processImageUpload(
    //         $photoData,
    //         Str::slug($product->slug . '-' . Carbon::now()->toDayDateTimeString() . random_int(10000, 99999)),
    //         ProductPhoto::PHOTO_UPLOAD_PATH,
    //         ProductPhoto::PHOTO_WIDTH,
    //         ProductPhoto::PHOTO_HEIGHT,
    //         ProductPhoto::PHOTO_UPLOAD_PATH_THUMB,
    //         ProductPhoto::PHOTO_WIDTH_THUMB,
    //         ProductPhoto::PHOTO_HEIGHT_THUMB,
    //         ''
    //     );

    //     $photo->photo = $photoPath;
    //     $photo->save();
    // }

    /**
     * @param Product|Model|ProductDetailsApiResource $product
     * @return array
     */
    final public static function getProductVariationAttributeList(Product|Model|ProductDetailResource $product)
    {
        $variations                   = ProductVariation::query()->with(['productVariationPhoto', 'variationAttributes'])->where('product_id', $product->id)->get();
        $unique_attributes            = $variations->unique('variationAttributes.attribute_id');
        $unique_attributes_name_value = [];

        if (isset($unique_attributes[0])){
            foreach ($unique_attributes[0]->variationAttributes as $unique_attribute) {
                $unique_attributes_name_value[$unique_attribute->attribute_id] = ['name' => $unique_attribute->productAttribute->name];
            }

            foreach ($variations as $variation) {
                foreach ($variation->variationAttributes as $variation_attribute) {
                    $unique_attributes_name_value[$variation_attribute->attribute_id]['value'][] = $variation_attribute->value;
                    $unique_attributes_name_value[$variation_attribute->attribute_id]['value']   = array_unique($unique_attributes_name_value[$variation_attribute->attribute_id]['value']);
                }
            }
        }

        return $unique_attributes_name_value;
    }

    /**
     * @param CartDetailResource|Cart|Model|Collection $cart
     * @param bool $is_photo_with_url
     * @return array
     */
    public static function handleCartVariationData(CartDetailResource|Cart|Model|Collection $cart, bool $is_photo_with_url = false): array
    {
        $price           = 0;
        $payable_price   = 0;
        $discount_amount = 0;
        $discount_text   = '';
        $photo           = $cart?->product?->primaryPhoto?->photo;

        if (!empty($cart->product) && $cart->product->product_type == Product::PRODUCT_TYPE_GROUPED) {
            $variation_price = PriceCalculator::priceProcessor($cart?->productVariations?->productPrice);
            $price           = $variation_price['price'];
            $discount_amount = $variation_price['discount_amount'];
            $discount_text   = $variation_price['discount_text'];
            $payable_price   = $variation_price['payable_price'];
            if (!empty($cart->productVariations->productVariationPhoto)) {
                $photo = $cart?->productVariations?->productVariationPhoto?->photo;
            }
        } else {
           // dd($cart->product->prices);
            $variation_price = PriceCalculator::priceProcessor($cart->product->prices->first());

            $price           = $variation_price['price'];
            $discount_amount = $variation_price['discount_amount'];
            $discount_text   = $variation_price['discount_text'];
            $payable_price   = $variation_price['payable_price'];
        }

        if ($is_photo_with_url){
            $photo = !empty($photo) ?  url(ProductPhoto::PHOTO_UPLOAD_PATH_THUMB. $photo) : url('images/default.webp');
        }
        return [
            'price'           => $price,
            'payable_price'   => $payable_price,
            'discount_amount' => $discount_amount,
            'discount_text'   => $discount_text,
            'photo'           => $photo,
        ];

    }

    public static function handleWishlistVariationData(WishlistDetailResource|WishList|Model|Collection $wishlist): array
    {
        $price           = 0;
        $payable_price   = 0;
        $discount_amount = 0;
        $discount_text   = '';
        $photo           = $wishlist?->product?->primaryPhoto?->photo;

        if (!empty($wishlist->product) && $wishlist->product->product_type == Product::PRODUCT_TYPE_GROUPED) {
            $variation_price = PriceCalculator::priceProcessor($wishlist->productVariations->productPrice);
            $price           = $variation_price['price'];
            $discount_amount = $variation_price['discount_amount'];
            $discount_text   = $variation_price['discount_text'];
            $payable_price   = $variation_price['payable_price'];
            if (!empty($wishlist->productVariations->productVariationPhoto)) {
                $photo = $wishlist?->productVariations?->productVariationPhoto?->photo;
            }
        } else {
            $variation_price = PriceCalculator::priceProcessor($wishlist->product->price);
            $price           = $variation_price['price'];
            $discount_amount = $variation_price['discount_amount'];
            $discount_text   = $variation_price['discount_text'];
            $payable_price   = $variation_price['payable_price'];
        }
        return [
            'price'           => $price,
            'payable_price'   => $payable_price,
            'discount_amount' => $discount_amount,
            'discount_text'   => $discount_text,
            'photo'           => $photo,
        ];

    }
    /**
     * @param CartDetailResource $cart
     * @return array
     */
    public static function handleCartProductAttributes(CartDetailResource $cart)
    {
        $product_attributes = [];
        // if (!empty($cart->product)) {
        //     if ($cart->product->product_type == Product::PRODUCT_TYPE_GROUPED) {
        //         //grouped
        //         foreach ($cart->productVariations->variationAttributes as $variation_attribute) {
        //             $product_attributes[] = [$variation_attribute->productAttribute->name => $variation_attribute->value];
        //         }
        //     } else {
        //         //single
        //         foreach ($cart->product->productAttributes as $product_attribute) {
        //             $product_attributes[] = [$product_attribute->productAttribute->name => $product_attribute->value];
        //         }
        //     }
        // }

        if (!empty($cart->product)) {
            if ($cart->product->product_type == Product::PRODUCT_TYPE_GROUPED) {
                //grouped

                foreach ($cart?->productVariations?->variationAttributes as $variation_attribute) {

                    $product_attributes[] = [
                        'id'                   => $variation_attribute?->id,
                        'name'                 => $variation_attribute?->AttributeName?->name,
                        'value'                => $variation_attribute?->value,
                    ];
                }
            } else {
                //single
                foreach ($cart->product->productAttributes as $product_attribute) {
                    $product_attributes[] = [
                        'id'                   => $product_attribute->productAttribute->id,
                        'name'                 => $product_attribute->productAttribute->name,
                        'value'                => $product_attribute->value,
                    ];
                }
            }
        }
        return $product_attributes;
    }

    // public static function handleWishlistProductAttributes(WishlistDetailResource $wishlist)
    // {
    //     $product_attributes = [];
    //     if (!empty($wishlist->product)) {
    //         if ($wishlist->product->product_type == Product::PRODUCT_TYPE_GROUPED) {
    //             //grouped
    //             foreach ($wishlist->productVariations->variationAttributes as $variation_attribute) {
    //                 $product_attributes[] = [$variation_attribute->productAttribute->name => $variation_attribute->value];
    //             }
    //         } else {
    //             //single
    //             foreach ($wishlist->product->productAttributes as $product_attribute) {
    //                 $product_attributes[] = [$product_attribute->productAttribute->name => $product_attribute->value];
    //             }
    //         }
    //     }
    //     return $product_attributes;
    // }


    public static function calculateProductStock(Product $product)
    {
        $stock = 0;
        if ($product->product_type != Product::PRODUCT_TYPE_GROUPED) {
            $stock = Inventory::query()->where('product_id', $product->id)->sum('stock');
        } else {
            $stock = $product?->inventory?->stock;
        }
        return $stock;
    }


}
