<?php

namespace App\Http\Resources;

use App\Manager\Constants\GlobalConstants;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    final public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'order_no'        => $this->invoice_no,
            'order_status'    => Order::ORDER_STATUS_LIST[$this->order_status] ?? null,
            'payment_status'  => Order::PAYMENT_STATUS_LIST[$this->payment_status] ?? null,
            'shipping_status' => Order::SHIPPING_STATUS_LIST[$this->shipping_status] ?? null,
            'customer_name'   => $this->user?->name,
            'created_at'      => $this->created_at->toDayDateTimeString(),
            'order_total'     => $this->total_payable_amount,
        ];
    }
}
