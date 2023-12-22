<?php

namespace App\Http\Resources;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class BlogSlugResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $photoUrls = $this->blogPhoto->map(function ($photo) {
            return  !empty($photo->photo) ? url(BlogPost::PHOTO_UPLOAD_PATH.$photo->photo) : url('default.webp');
        });

        return [
            'id'            =>$this->id,
            'title'         =>$this->title,
            'slug'          =>$this->slug,
            'read_count'    =>$this->read_count,
            'description'   =>$this->description,
            'type'          => BlogPost::BLOG_TYPE[$this->type],
            'category'      =>$this->blog_category?->slug,
            'blog_comments' => CommentResource::collection($this->blog_comments),
             'photos'        => $photoUrls
        ];
    }
}
