<?php

namespace App\Http\Resources;

use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'description'=> $this->description,
            'status'     =>$this->status ==1 ?'Active':($this->status==2 ?'Pending':'Blacked'),
        ];
    }
}
