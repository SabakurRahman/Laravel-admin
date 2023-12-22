<?php

namespace App\Http\Resources;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;


class FeaturedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          =>$this->id,
            'title'       =>$this->title,
            'slug'        =>$this->slug,
            'description' =>Str::limit($this->description, 200),
            'photo'   =>  !empty($this->photo) ? url(BlogPost::PHOTO_UPLOAD_PATH.$this->photo) : url('default.webp'),
            ];
    }
}
