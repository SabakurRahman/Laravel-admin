<?php

namespace App\Http\Resources;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'title'   => $this->title,
            'photo'   =>  !empty($this->photo) ? url(Team::PHOTO_UPLOAD_PATH.$this->photo) : url('default.webp'),

        ];
    }
}
