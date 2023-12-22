<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WarrentyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // 'id' => $this->id,
            'warrenty_type'   => $this->warrenty_type == 1 ?'Expressed':'Implied',
            'warrenty_period' => $this->warrenty_period == 1 ?'3 month':
                                 ($this->warrenty_period == 2 ?'6 month':'1 year'),
            'warrenty_policy' => $this->warrenty_policy,
        ];
    }
}
