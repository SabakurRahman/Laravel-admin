<?php

namespace App\Models;

use App\Manager\ProductVariationManager;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function storeOrderItems(Collection|array $carts, Model|Builder $order)
    {
        foreach ($carts as $cart) {
            $prices           = ProductVariationManager::handleCartVariationData($cart);
            $order_items_data = [
                'order_id'            => $order->id,
                'product_id'          => $cart->product_id,
                'variation_id'        => $cart->variation_id,
                'cost'                => $cart?->product?->price?->cost,
                'name'                => $cart->product->title,
                'slug'                => $cart->product->slug,
                'sku'                 => $cart->product->sku,
                'photo'               => $prices['photo'],
                'quantity'            => $cart->quantity,
                'discount_fixed'      => $cart?->product?->price?->discount_fixed,
                'discount_percent'    => $cart?->product?->price?->discount_percent,
                'discount_start'      => $cart?->product?->price?->discount_start,
                'discount_end'        => $cart?->product?->price?->discount_end,
                'previous_unit_price' => $cart?->product?->price?->price,
                'discount_text'       => $prices['discount_text'],
                'unit_price'          => $prices['price'],
                'total_amount'        => $prices['price'] * $cart->quantity,
                'discount_amount'     => $prices['discount_amount'] * $cart->quantity,
                'payable_price'       => $prices['payable_price'] * $cart->quantity,
                'created_at'          => Carbon::now(),
                'updated_at'          => Carbon::now(),
            ];
            $order_item       = self::query()->create($order_items_data);
            (new Product())->updateSold($cart->product_id, $cart->quantity);
            if ($cart->product->product_type == Product::PRODUCT_TYPE_GROUPED) {
                //grouped
                if (count($cart?->productVariations->variationAttributes) > 0) {
                    foreach ($cart?->productVariations->variationAttributes as $cart_variation) {
                      $order_item_attribute_data = [
                            'order_item_id' => $order_item->id,
                            'name'          => $cart_variation?->AttributeName?->name,
                            'value'         => $cart_variation?->value,
                        ];
                        OrderItemAttribute::query()->create($order_item_attribute_data);
                    }
                }
                $inventory = Inventory::query()
                    ->where('product_id', $cart->product_id)
                    ->where('variation_id', $cart->variation_id)
                    ->first();
                if ($inventory) {
                    $inventory_data = [
                        'stock' => $inventory->stock - $cart->quantity
                    ];
                    $inventory->update($inventory_data);
                }

            } else {
                if (count($cart->product->productAttributes) > 0) {
                    foreach ($cart->product->productAttributes as $product_attributes) {
                        $order_item_attribute_data = [
                            'order_item_id' => $order_item->id,
                            'name'          => $product_attributes?->productAttribute?->name,
                            'value'         => $product_attributes?->value,
                        ];
                        OrderItemAttribute::query()->create($order_item_attribute_data);
                    }
                }
                $cart_inventory = Inventory::query()
                    ->where('product_id', $cart->product_id)
                    ->whereNull('variation_id')->first();
                if ($cart_inventory){
                    $cart_inventory_data = [
                        'stock' => $cart_inventory->stock - $cart->quantity
                    ];
                    $cart_inventory->update($cart_inventory_data);
                }
            }
            $cart->delete();
        }
    }


    public function storeOrderItemsByAdmin(mixed $selectedProducts, Model|Builder $order)
    {

        foreach ($selectedProducts as $products) {
            $order_items_data = [
                'order_id'            => $order->id,
                'product_id'          => $products->id,
                'name'                => $products->name,
                'quantity'            => $products->quantity,
                'unit_price'          => $products->unit_price,
                'total_amount'        => $products->amount,
                'created_at'          => Carbon::now(),
                'updated_at'          => Carbon::now(),
            ];
            self::query()->create($order_items_data);

        }


    }

    public function updateOrderItemsByAdmin(mixed $selectedProduct, Order $order)
    {

        $order_items_data = [
            'order_id'            => $order->id,
            'product_id'          => $selectedProduct->id,
            'name'                => $selectedProduct->name,
            'quantity'            => $selectedProduct->quantity,
            'unit_price'          => $selectedProduct->unit_price,
            'total_amount'        => $selectedProduct->amount,
            'created_at'          => Carbon::now(),
            'updated_at'          => Carbon::now(),
        ];
        self::query()->create($order_items_data);


    }




    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }


    public function order_items_attributes()
    {
        return $this->hasMany(OrderItemAttribute::class);
    }


}
