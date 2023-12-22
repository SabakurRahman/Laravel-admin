<?php

namespace App\Http\Resources;

use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SocialMediaResource extends JsonResource
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
          'url'       =>$this->url,
          'photo'      =>url(SocialMedia::PHOTO_UPLOAD_PATH.$this->photo),
          'status'    => $this->status == 1 ? 'Active' : 'Inactive',
  ];
    }
}
