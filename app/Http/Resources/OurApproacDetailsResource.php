<?php

namespace App\Http\Resources;

use App\Models\OurApproach;
use Illuminate\Http\Request;
use App\Manager\ImageUploadManager;
use Illuminate\Http\Resources\Json\JsonResource;

class OurApproacDetailsResource extends JsonResource
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
            'name' => $this->name??'',
            'category_name' => $this->ourApproachCategory?->name??'',
            'description' => $this->description??'',
            // 'short_description' => $this->short_description,
            'Banner' => url(OurApproach::BANNER_UPLOAD_PATH, $this->banner)??'',
            'status' => OurApproach::STATUS_LIST[$this->status]??'',
            'created_at' => $this->created_at->toDayDateTimeString(),
            'updated_at' => $this->updated_at->toDayDateTimeString(),

        ];
    }
}
