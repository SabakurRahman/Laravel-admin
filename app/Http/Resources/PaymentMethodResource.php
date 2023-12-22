<?php

namespace App\Http\Resources;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentMethodResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [         
          'id'        =>$this->id,
          'name'      =>$this->name,
          'account_no'=>$this->account_no,
          'status'    => $this->status == 1 ? 'Active' : 'Inactive',
        ];
    }
}
