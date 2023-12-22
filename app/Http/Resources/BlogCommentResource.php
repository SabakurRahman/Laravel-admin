<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogCommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id'        => $this->id,
            'comment'   => $this->comment,
            'user_name' => $this->user?->name,
            'user_photo'=>$this->user?->profile?->profile_photo,
            'replies'     => CommentReplyResource::collection($this->replies)
        ];
    }
}
