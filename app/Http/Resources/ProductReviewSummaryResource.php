<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductReviewSummaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'score'       => $this->score,
            'stars'       => $this->stars,
            'like_count'  => $this->like_count,
            'reviews' => ProductReviewResource::collection($this->reviews)

        ];
    }
}
