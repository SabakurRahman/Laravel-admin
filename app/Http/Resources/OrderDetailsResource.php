<?php

namespace App\Http\Resources;

use App\Manager\Constants\GlobalConstants;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                    => $this->id,
            'order_no'              => $this->invoice_no,
            'customer_name'         => $this?->user?->name,
            'location'              => $this?->location,
            'location_text'         => Order::SHIPPING_LOCATION_LIST[$this?->location] ?? null,
            'total_quantity'        => $this->total_quantity,
            'total_amount'          => $this->total_amount,
            'total_discount_amount' => $this->total_discount_amount,
            'total_payable_amount'  => $this->total_payable_amount,
            'payment_status'        => Order::PAYMENT_STATUS_LIST[$this->payment_status] ?? null,
            'shipping_status'       => Order::SHIPPING_STATUS_LIST[$this->shipping_status] ?? null,
            'order_status'          => Order::ORDER_STATUS_LIST[$this->order_status] ?? null,
            'created_at'            => $this->created_at->toDayDateTimeString(),
            'shipping_charge'       => $this->shipping_charge,
            'order_items'           => OrderItemsResource::collection($this->order_items),
            'shipping_address'      => new OrderAddressResource($this->shipping_address),
            'billing_address'       => new OrderAddressResource($this->billing_address),
            'transactions'          => TransactionResource::collection($this->transactions),


        ];
    }
}
