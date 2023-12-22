<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoryListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
      $subCategories = $this->getSubCategories;

      return [
        'id'           => $this->id,
        'name'         => $this->name,
        'slug'         => $this->slug,
        'photo'        => url(Category::BANNER_UPLOAD_PATH . $this->banner),
        'icon'         => url(Category::PHOTO_UPLOAD_PATH . $this->photo),
        'sub_category' => $subCategories->map(function ($sub) {
                            return [
                              'id'       => $sub->id,
                              'name'     => $sub->name,
                              'slug'     => $sub->slug,
                              'photo'    => url(Category::BANNER_UPLOAD_PATH . $sub->banner),
                              'icon'     => url(Category::PHOTO_UPLOAD_PATH . $sub->photo),
                            ];
        }),
      ];
    }
}




