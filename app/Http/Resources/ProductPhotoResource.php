<?php

namespace App\Http\Resources;

use App\Models\ProductPhoto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductPhotoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'variation_id' => $this->variation_id,
            'photo'    => url(ProductPhoto::PHOTO_UPLOAD_PATH.$this->photo),
            'serial'   => $this->serial,
            'title'    => $this->title,
            'alt_text' => $this->alt_text,
        ];
    }
}
