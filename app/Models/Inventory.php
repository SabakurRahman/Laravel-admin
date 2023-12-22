<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Inventory extends Model
{
    use HasFactory;
    protected $guarded = [];

       public function updateInventory(Request $request, Product|Model $product)
    {
        return $product->inventory->update($this->prepareInventoryData($request, $product));
    }

     private function prepareInventoryData(Request $request, Product|Model $product): array
    {
        return [
            'product_id'                 => $product->id,
            'is_available_for_pre_order' => $request->input('is_available_for_pre_order'),
            'is_enable_call_for_price'   => $request->input('is_enable_call_for_price'),
            'is_returnable'              => $request->input('is_returnable'),
            'disable_buy_button'         => $request->input('disable_buy_button'),
            'is_disable_wishlist_button' => $request->input('is_disable_wishlist_button'),
            'inventory_method'           => $request->input('inventory_method'),
            'available_date'             => $request->input('available_date'),
            'max_cart_quantity'          => $request->input('max_cart_quantity'),
            'min_cart_quantity'          => $request->input('min_cart_quantity'),
            'stock'                      => $request->input('stock'),
            'low_stock_alert'            => $request->input('low_stock_alert'),
        ];
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
