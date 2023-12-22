<?php

namespace App\Http\Resources;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;



class BlogPostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

                $this->name   => BlogPostModifyResource::collection($this->blog_posts)


        ];
    }
}
