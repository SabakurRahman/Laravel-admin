<?php

namespace App\Http\Resources;

use App\Models\ProjectPhoto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectPhotoListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            
            'photo' => url(ProjectPhoto::PHOTO_UPLOAD_PATH.$this->photo),
            
        ];
    }
}
