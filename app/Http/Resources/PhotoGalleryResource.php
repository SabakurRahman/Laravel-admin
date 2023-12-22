<?php

namespace App\Http\Resources;
use App\Models\PhotoGallerie;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PhotoGalleryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
          'id'                  =>$this->id,
          'title'               =>$this->title,
          'photo'               =>url(PhotoGallerie::PHOTO_UPLOAD_PATH.$this->photo),
          'status'              => $this->status == 1 ? 'Active' : 'Inactive',
          'is_shown_on_slider'  => $this->is_shown_on_slider == 1 ? 'Show In Slider' : 'Not Show In Slider',
        ];
    }
}
