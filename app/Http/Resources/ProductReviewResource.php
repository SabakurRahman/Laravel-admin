<?php

namespace App\Http\Resources;

use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $photoUrls = $this->photos->map(function ($photo) {
            return url(ProductReview::PHOTO_UPLOAD_PATH . $photo->photo); // Modify the path as needed
        });

        return [
            'comment'             =>  $this->comment,
            'replies'             =>  ProductCommentReplyResource::collection($this->replies),
            'customer_name'       =>  $this->user?->name,
            'like'                =>  $this->like,
            'photos'              => $photoUrls,
        ];
    }
}
