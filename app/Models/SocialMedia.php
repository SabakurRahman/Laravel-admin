<?php

namespace App\Models;

use App\Manager\Utility;
use Illuminate\Http\Request;
use App\Manager\ImageUploadManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\StoreSocialMediaRequest;
use App\Http\Requests\UpdateSocialMediaRequest;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SocialMedia extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 2;

    public const STATUS_LIST = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];
    public const PHOTO_UPLOAD_PATH = 'uploads/socialMedia/';
    public const PHOTO_UPLOAD_PATH_THUMB = 'uploads/socialMedia/thumb/';
    public const PHOTO_WIDTH = 128;
    public const PHOTO_HEIGHT = 128;
    public const PHOTO_WIDTH_THUMB = 150;
    public const PHOTO_HEIGHT_THUMB = 150;


    public function getSocialMediaList(Request $request) {
        
        $paginate  = $request->input('per_page') ?? 10;
        $query     = self::query()->with(['user']);
        if ($request->input('name')){
            $query->where('name', 'like', '%'.$request->input('name').'%');
        }
        if ($request->input('url')){
            $query->where('url', 'like', '%'.$request->input('url').'%');
        }
        if ($request->input('status')){
            $query->where('status', $request->input('status'));
        }
        if ($request->input('sort_by') && $request->input('sort_direction')) {
            $query->orderBy($request->input('sort_by'), $request->input('sort_direction'));
        } else {
            $query->orderByDesc('id');
        }
        return $query->paginate($paginate);
    }

     public function createNewSocialMedia(StoreSocialMediaRequest $request)
    {
        return self::query()->create($this->prepareNewSocialMediaData($request));
    }

    private function prepareNewSocialMediaData(StoreSocialMediaRequest $request)
    {
       
        $data = [
            'name'   => $request->input('name'),
            'status' => $request->input('status'),
            'url' => $request->input('url'),
            'user_id' => Auth::id(),
            
        ];
        if ($request->hasFile('photo')) {
             
            $photo = (new ImageUploadManager)->file($request->file('photo'))
                ->name(Utility::prepare_name($request->input('name')))
                ->path(self::PHOTO_UPLOAD_PATH)
                ->height(self::PHOTO_HEIGHT)
                ->width(self::PHOTO_WIDTH)
                ->upload();

            $data['photo'] = $photo;

        }
        // dd($data);
        return $data;
    }

    public function updateSocialMediaInfo(UpdateSocialMediaRequest $request, SocialMedia $socialMedia)
    {
        $updateSocialMediaInfoData = [
            'name'   => $request->input('name')   ?? $socialMedia->name,
            'status' => $request->input('status') ?? $socialMedia->status,
            'url'    => $request->input('url') ?? $socialMedia->url,
            'user_id' => Auth::id(),
        ];
        $photo   = $socialMedia->photo;
        if ($request->hasFile('photo')) {
            if ($photo) {
                ImageUploadManager::deletePhoto(self::PHOTO_UPLOAD_PATH, $socialMedia->photo);
            }
            $photo = (new ImageUploadManager)->file($request->file('photo'))
                ->name(Utility::prepare_name($request->input('name')))
                ->path(self::PHOTO_UPLOAD_PATH)
                ->height(self::PHOTO_HEIGHT)
                ->width(self::PHOTO_WIDTH)
                ->upload();

        }
        $updateSocialMediaInfoData['photo']  = $photo;
        $socialMedia->update($updateSocialMediaInfoData);

        return $socialMedia;

        //   return $socialMedia->update($updateSocialMediaInfoData);

    }
          public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return MorphMany
     */
    final public function activity_logs():MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }
}
