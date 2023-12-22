<?php

namespace App\Http\Resources;
use Carbon\Carbon;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoriesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {


        return [
          'product_id'                =>$this->product_id,
          'id'                        =>$this->id,
          'variation_id'              =>$this->variation_id,
          'inventory_method'          =>$this->inventory_method == 0 ? 'Do not Track Inventory':'Track Inventory',
          'stock'                     =>$this->stock,
          'max_cart_quantity'         =>$this->max_cart_quantity,
          'min_cart_quantity'         =>$this->min_cart_quantity,
          'available_date'            =>Carbon::parse($this->available_date)->format('D, M j, Y, H:i'),
          'is_available_for_pre_order'=>$this->is_available_for_pre_order == 0 ? 'Not Available' : 'Available',
          'is_enable_call_for_price'  =>$this->is_enable_call_for_price == 0 ? 'Not Enabled' : 'Enabled',
          'is_returnable'             =>$this->is_returnable == 0 ? 'Not Returnable' : 'Returnable',
          'disable_buy_button'        =>$this->disable_buy_button == 0 ? 'Not Disable' : 'Disable',
          'is_disable_wishlist_button'=>$this->is_disable_wishlist_button == 0 ? 'Not Disable' : 'Disable',
          'low_stock_alert'           =>$this->low_stock_alert == 0 ? 'Enable':'Disable',

        ];
    }



}
