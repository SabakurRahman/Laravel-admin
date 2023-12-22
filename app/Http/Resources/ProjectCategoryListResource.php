<?php

namespace App\Http\Resources;

use App\Models\ProjectCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectCategoryListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'slug'        => $this->slug,
            // 'status'      => ProjectCategory::STATUS_LIST[$this->status],
            // 'description' => $this->description,
            // 'serial'      => $this->serial,
            // 'banner'      => url(ProjectCategory::BANNER__UPLOAD_PATH_THUMB, $this->banner),
            // 'photo'       => url(ProjectCategory::PHOTO_UPLOAD_PATH, $this->photo),
            // 'created_at'  => $this->created_at->toDayDateTimeString(),
            // 'updated_at'  => $this->updated_at->toDayDateTimeString(),

        ];
        }
    
}
