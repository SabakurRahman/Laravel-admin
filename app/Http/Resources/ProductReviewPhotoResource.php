<?php

namespace App\Http\Resources;

use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductReviewPhotoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
           "photo" => !empty($this->photo) ? url(ProductReview::PHOTO_UPLOAD_PATH . $this->photo) : url('default.webp'),
        ];
    }
}
