<?php

namespace App\Http\Resources;

use App\Models\OurApproachCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OurApproachCategorylistResource extends JsonResource
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
            'name'       =>$this->name,
            'slug'        =>$this->slug,
            // 'description' =>$this->description,
            'photo'       =>url(OurApproachCategory::PHOTO_UPLOAD_PATH, $this->photo),
            'status'      =>OurApproachCategory::STATUS_LIST[$this->status],
            'serial'      =>$this->serial,
            // 'created_at'  =>$this->created_at->toDayDateTimeString(),
            // 'updated_at'  =>$this->updated_at->toDayDateTimeString(),
            ];
    }
}
