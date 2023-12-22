<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Seo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return[
          'id'           =>$this->id,
          'title'        =>$this->title,
          'keywords'     =>$this->keywords,
          'description'  =>$this->description,
          'og_image'     =>url(Seo::Seo_PHOTO_UPLOAD_PATH.$this->og_image),
          
        ];
    }
}




