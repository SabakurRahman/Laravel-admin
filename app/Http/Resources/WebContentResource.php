<?php


namespace App\Http\Resources;

use App\Models\WebContent;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WebContentResource extends JsonResource
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
          'title'               => $this->title,
          'location'            => $this->location == 1 ? 'Homepage' : 'Product Page',
          'content'             => $this->content,


        ];
    }
}
