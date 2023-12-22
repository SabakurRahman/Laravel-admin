<?php

namespace App\Http\Resources;

use App\Models\ClientLogo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientLogoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
          'id'        =>$this->id,
          'title'      =>$this->title,
          'status'     => $this->status == 1 ? 'Active' : 'Inactive',
          'photo'     =>url(ClientLogo::PHOTO_UPLOAD_PATH.$this->photo),
    ];
    }
}
