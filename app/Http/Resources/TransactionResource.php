<?php

namespace App\Http\Resources;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'trx_id'         => $this->trx_id,
            'status'         => !empty($this->status) ? Transaction::STATUS_LIST[$this->status] : null,
            'amount'         => $this->amount,
            'created_at'     => $this->created_at->toDayDateTimeString(),
            'payment_method' => $this->payment_method?->name,
        ];
    }
}
