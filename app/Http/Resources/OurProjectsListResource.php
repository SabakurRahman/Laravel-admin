<?php

namespace App\Http\Resources;

use App\Models\OurProjects;
use App\Models\ProjectPhoto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OurProjectsListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->project_description,
            'location' => $this->project_location,
            'total_area' => $this->total_area,
            'total_cost' => $this->total_cost,
            'client_name' => $this->client_name,
            'photos' => ProjectPhotoListResource::collection($this->photos_all()?->get()),
            'primary_photo' => url(ProjectPhoto::PHOTO_UPLOAD_PATH, $this->primary_photo()?->first()?->photo),
            'category' => $this->project_category?->name,
            'created_at' => $this->created_at->toDayDateTimeString(),
            'updated_at' => $this->updated_at->toDayDateTimeString(),

        ];
    }
}
