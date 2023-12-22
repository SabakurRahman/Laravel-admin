<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
      {
          return [
              'id' => $this->id,
              'name' => $this->name,
              'slug' => $this->slug,
              'description' => $this->description,
              'status' => $this->status == 1 ? 'Active' : 'Inactive',
              'serial' => $this->serial,
              'photo' => url(Category::BANNER_UPLOAD_PATH . $this->banner),
              'icon' => url(Category::PHOTO_UPLOAD_PATH . $this->photo),
          ];
      }
}




