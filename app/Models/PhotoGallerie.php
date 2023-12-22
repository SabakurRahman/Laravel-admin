<?php

namespace App\Models;

use Carbon\Carbon;
use App\Manager\Utility;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Manager\ImageUploadManager;
use function Laravel\Prompts\select;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\StorePhotoGallerieRequest;
use App\Http\Requests\UpdatePhotoGallerieRequest;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PhotoGallerie extends Model
{
    use HasFactory;
    protected $guarded = [];

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 2;

    public const STATUS_LIST=[
        self::STATUS_ACTIVE   => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    public const SHOW_IN_SLIDER=1;
    public const NOT_SHOW_IN_SLIDER=2;

    public const SLIDER_LIST=[
        self::SHOW_IN_SLIDER => 'Show in slide',
        self::NOT_SHOW_IN_SLIDER => 'Not Show in slide',
    ];

    public const PHOTO_UPLOAD_PATH = 'uploads/photo_gallery/';
    public const PHOTO_UPLOAD_PATH_THUMB = 'uploads/photo_gallery/thumb/';
    public const PHOTO_WIDTH = 800;
    public const PHOTO_HEIGHT = 800;
    public const PHOTO_WIDTH_THUMB = 150;
    public const PHOTO_HEIGHT_THUMB = 150;



    public function getPhotoGalleryList(Request $request)
    {
        $paginate  = $request->input('per_page') ?? 10;
        $query     = self::query()->with(['user']);
        if ($request->input('title')){
            $query->where('title', 'like', '%'.$request->input('title').'%');
        }
        if ($request->input('status')|| $request ->input('status')===0){
            $query->where('status', $request->input('status'));
        }
        if ($request->input('is_shown_on_slider')|| $request ->input('is_shown_on_slider')===0){
            $query->where('is_shown_on_slider', $request->input('is_shown_on_slider'));
        }
        if ($request->input('sort_by') && $request->input('sort_direction')) {
            $query->orderBy($request->input('sort_by'), $request->input('sort_direction'));
        } else {
            $query->orderByDesc('id');
        }
        return $query->paginate($paginate);
    }


    public function createNewPhotoGallery(StorePhotoGallerieRequest $request)
    {
        return self::query()->create($this->prepareNewPhotoGalleryData($request));
    }

    private function prepareNewPhotoGalleryData(StorePhotoGallerieRequest $request)
    {
        return [
            'title'   => $request->input('title'),
            'status' => $request->input('status'),
            'is_shown_on_slider' => $request->input('is_shown_on_slider'),
            'user_id' => Auth::id(),
            'photo'  => (new ImageUploadManager)->file($request->file('photo'))
                ->name(Utility::prepare_name($request->input('title')))
                ->path(self::PHOTO_UPLOAD_PATH)
                ->height(self::PHOTO_HEIGHT)
                ->width(self::PHOTO_WIDTH)
                ->upload(),
        ];
    }


    // public function updatePhotoGalleryInfo(UpdatePhotoGallerieRequest $request, PhotoGallerie $photoGallerie)
    // {
    //     $updatePhotoGalleryInfoData = [
    //         'title'        => $request->input('title') ?? $photoGallerie->title,
    //         'status'      => $request->input('status') ?? $photoGallerie->status,
    //         'is_shown_on_slider' => $request->input('is_shown_on_slider')?? $photoGallerie->is_shown_on_slider,
            
    //     ];
    //     if($request->has('photo')){
    //          ImageUploadManager::deletePhoto(self::PHOTO_UPLOAD_PATH, $photoGallerie->photo);
    //         $updateCategoryInfoData['photo']   = (new ImageUploadManager)->file($request->file('photo'))
    //             ->name(Utility::prepare_name($request->input('title')))
    //             ->path(self::PHOTO_UPLOAD_PATH)
    //             ->height(self::PHOTO_HEIGHT)
    //             ->width(self::PHOTO_WIDTH)
    //             ->upload();
    //     }

    //     return $photoGallerie->update($updatePhotoGalleryInfoData);

    // }

    public function updatePhotoGalleryInfo(UpdatePhotoGallerieRequest $request, PhotoGallerie $photo_gallery)
    {
        $updatePhotoGalleryInfoData = [
            'title'        => $request->input('title') ?? $photo_gallery->title,
            'status'      => $request->input('status') ?? $photo_gallery->status,
            'is_shown_on_slider' => $request->input('is_shown_on_slider') ?? $photo_gallery->is_shown_on_slider,
            'user_id' => Auth::id()
        ];
        if($request->has('photo')){
             ImageUploadManager::deletePhoto(self::PHOTO_UPLOAD_PATH, $photo_gallery->photo);
             $updatePhotoGalleryInfoData['photo']   = (new ImageUploadManager)->file($request->file('photo'))
                ->name(Utility::prepare_name($request->input('title')))
                ->path(self::PHOTO_UPLOAD_PATH)
                ->height(self::PHOTO_HEIGHT)
                ->width(self::PHOTO_WIDTH)
                ->upload();
        }
        $photo_gallery->update($updatePhotoGalleryInfoData);

        return $photo_gallery;

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
