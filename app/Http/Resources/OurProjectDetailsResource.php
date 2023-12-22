<?php

namespace App\Http\Resources;

use App\Models\ProjectPhoto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OurProjectDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                  => $this->id,
            'name'                => $this->name,
            'description'         => strip_tags($this->project_description),
            'type'                => $this->type ==1 ? "Office Interior" : "Home Interior",
            'category'            => $this->project_category?->name,
            'client_name'         => $this->client_name,
            'total_area'          => $this->total_area,
            'total_cost'          => $this->total_cost,
            'location'            => $this->project_location,
            'is_show_on_home_page'=> $this->is_show_on_home_page ==1 ? "Yes" : "NO",
            'status'              => $this->status ==1? "Active":"Inactive",
            // 'tags'                => $this->tags()->pluck('name')->toArray(),
            'tags'                => $this->tags?->pluck('name'),
            'photos'              => $this->formatPhotosUrls($this->photos_all()->get()),
            // 'photos'              => ProjectPhotoListResource::collection($this->photos_all()->get()),
            'cover_photo'         => url(ProjectPhoto::PHOTO_UPLOAD_PATH,$this->primary_photo()?->first()?->photo),


            // 'created_at' => $this->created_at->toDayDateTimeString(),
            // 'updated_at' => $this->updated_at->toDayDateTimeString(),
        ];
    }

    protected function formatPhotosUrls($photos)
    {
        return $photos->map(function ($photo) {
            return url(ProjectPhoto::PHOTO_UPLOAD_PATH, $photo->photo);
        });
    }
}
