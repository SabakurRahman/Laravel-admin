<?php

namespace App\Http\Resources;
use App\Models\NewsLetter;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsletterResource extends JsonResource
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
          'email'     =>$this->email,
          'ip'        =>$this->ip,
          'status'    => $this->status == 1 ? 'Active' : 'Inactive',
  ];
    }
}
