<?php

namespace App\Models;

use App\Http\Requests\StoreUserProfileRequest;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Manager\ImageUploadManager;
use App\Manager\Utility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserProfile extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const PHOTO_UPLOAD_PATH = 'uploads/user_profile/';
    public const PHOTO_UPLOAD_PATH_THUMB = 'uploads/user_profile/thumb/';
    public const PHOTO_WIDTH = 600;
    public const PHOTO_HEIGHT = 600;
    public const PHOTO_WIDTH_THUMB = 150;
    public const PHOTO_HEIGHT_THUMB = 150;


    public const NATIONAL_ID_PHOTO_UPLOAD_PATH = 'uploads/national_id/';
    public const NATIONAL_ID_PHOTO_UPLOAD_PATH_THUMB = 'uploads/national_id/thumb/';
    public const NATIONAL_ID_PHOTO_WIDTH = 1000;
    public const NATIONAL_ID_PHOTO_HEIGHT = 450;
    public const NATIONAL_ID_PHOTO_WIDTH_THUMB = 150;
    public const NATIONAL_ID_PHOTO_HEIGHT_THUMB = 150;

    public function storeUserProfile(StoreUserProfileRequest $request, User|Model $user)
    {
        if ($user->profile) {
            return $user->profile()->update($this->prepareUserProfileData($request));
        }
        return $user->profile()->create($this->prepareUserProfileData($request));
    }

    private function prepareUserProfileData(StoreUserProfileRequest $request)
    {
        $updateUserProfileData = [
            'date_of_birth'        => $request->input('date_of_birth'),
            'user_id'              => Auth::id(),
            'national_id_card_no'  => $request->input('national_id_card_no'),
            'emergency_contact_no' => $request->input('emergency_contact_no'),
        ];

        $userProfile = self::query()->where('user_id', Auth::id())->first();

        if ($userProfile != null) {
            if ($request->hasFile('profile_photo')) {
                if ($userProfile->profile_photo) {
                    ImageUploadManager::deletePhoto(self::PHOTO_UPLOAD_PATH, $userProfile->profile_photo);
                }
                $photo                                  = (new ImageUploadManager)->file($request->file('profile_photo'))
                    ->name(Utility::prepare_name($request->input('name')))
                    ->path(self::PHOTO_UPLOAD_PATH)
                    ->height(self::PHOTO_HEIGHT)
                    ->width(self::PHOTO_WIDTH)
                    ->upload();
                $updateUserProfileData['profile_photo'] = $photo;
            }


            if ($request->hasFile('national_id_photo')) {
                if ($userProfile->national_id_photo) {
                    ImageUploadManager::deletePhoto(self::NATIONAL_ID_PHOTO_UPLOAD_PATH, $userProfile->national_id_photo);
                }
                $national_id_photo                          = (new ImageUploadManager)->file($request->file('national_id_photo'))
                    ->name(Utility::prepare_name($request->input('name')))
                    ->path(self::NATIONAL_ID_PHOTO_UPLOAD_PATH)
                    ->height(self::NATIONAL_ID_PHOTO_HEIGHT)
                    ->width(self::NATIONAL_ID_PHOTO_WIDTH)
                    ->upload();
                $updateUserProfileData['national_id_photo'] = $national_id_photo;
            }


            return $updateUserProfileData;

        }

        if ($request->has('profile_photo')) {
            $profilePhoto  = (new ImageUploadManager)->file($request->file('profile_photo'))
                ->name(Utility::prepare_name($request->input('name')))
                ->path(self::PHOTO_UPLOAD_PATH)
                ->height(self::PHOTO_HEIGHT)
                ->width(self::PHOTO_WIDTH)
                ->upload();
            $updateUserProfileData['profile_photo'] = $profilePhoto;
        }
        if ($request->has('profile_photo')) {
            $national_id_photo   = (new ImageUploadManager)->file($request->file('national_id_photo'))
                ->name(Utility::prepare_name($request->input('name')))
                ->path(self::NATIONAL_ID_PHOTO_UPLOAD_PATH)
                ->height(self::NATIONAL_ID_PHOTO_HEIGHT)
                ->width(self::NATIONAL_ID_PHOTO_WIDTH)
                ->upload();
            $updateUserProfileData['national_id_photo'] = $national_id_photo;
        }


        return $updateUserProfileData;
    }


  
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }


}
