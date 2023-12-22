<?php

namespace App\Http\Resources;

use App\Manager\ImageUploadManager;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $email
 * @property mixed $photo
 * @property mixed $status
 * @property mixed $phone
 */
class UserDetailsResponseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    final public function toArray(Request $request): array
    {
        $roles    = [];
        $roles_id = [];
        if (!empty($this->roles)) {
            foreach ($this->roles as $role) {
                $roles[]    = $role->name;
                $roles_id[] = $role->id;
            }
        }

        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'email'   => $this->email,
            'phone'   => $this->phone,
            'status'  => User::STATUS_LIST[$this->status] ?? null,
            'photo'   => ImageUploadManager::prepareImageUrl(User::PROFILE_PHOTO_PATH_THUMB, $this->photo),
            'role'    => $roles,
            'role_id' => $roles_id
        ];
    }
}
