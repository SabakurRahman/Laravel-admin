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
use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Http\Requests\StoreBannerSizeRequest;
use App\Http\Requests\UpdateBannerSizeRequest;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Banner extends Model
{
    use HasFactory;


    protected $guarded = [];

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 2;

    public const STATUS_LIST = [
        self::STATUS_ACTIVE   => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    public const TYPE_BANNER= 1;
    public const TYPE_SLIDER = 2;
    public const TYPE_ADVERTISEMENT = 3;

    public const TYPE_LIST = [
        self::TYPE_BANNER   => 'Banner',
        self::TYPE_SLIDER => 'Slider',
        self::TYPE_ADVERTISEMENT => 'Advertisement',
    ];


    public const PHOTO_UPLOAD_PATH = 'uploads/banner/';
    public const PHOTO_UPLOAD_PATH_THUMB = 'uploads/banner/thumb/';
    public const PHOTO_WIDTH = 600;
    public const PHOTO_HEIGHT = 600;
    public const PHOTO_WIDTH_THUMB = 150;
    public const PHOTO_HEIGHT_THUMB = 150;


    public function getBanner(Request $request)
    {
        $paginate  = $request->input('per_page') ?? 10;
        $bannerSize = BannerSize::find($request->input('banner_size_id'));
        $query    = self::query()->with(['user']);
        if ($request->input('title')){
            $query->where('title', 'like', '%'.$request->input('title').'%');
        }
        if ($request->input('location')){
            $query->where('location', 'like', '%'.$request->input('location').'%');
        }
        if ($request->input('type')){
            $query->where('type', $request->input('type'));
        }
        if ($request->input('serial')){
            $query->where('serial', $request->input('serial'));
        }
        if ($request->input('banner_size_id')){
            $query->where('banner_size_id', $request->input('banner_size_id'));
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

     public function createNewBanner(StoreBannerRequest $request)
    {
        // return self::query()->create($this->prepareNewBannerData($request));
        $banner =self::query()->create($this->prepareNewBannerData($request));
        $seoData = (new Seo)->prepareSeoData($request);
        $banner->seos()->create($seoData);
        return $banner;
    }

    private function prepareNewBannerData(StoreBannerRequest $request)
    {
        $bannerSize     = BannerSize::find($request->input('banner_size_id'));
        $bannerHeight   = $bannerSize ? $bannerSize->height : self::PHOTO_HEIGHT;
        $bannerWidth    = $bannerSize ? $bannerSize->width : self::PHOTO_WIDTH;
        $bannerLocation = $bannerSize ? $bannerSize->location : null;

        $data = [
            'title'   => $request->input('title'),
            'status'   => $request->input('status'),
            'type'     => $request->input('type'),
            'serial'   => $request->input('serial'),
            'banner_size_id' => $request->input('banner_size_id'),
            'location' => $bannerLocation,
            'user_id'     => Auth::id(),
        ];
         if ($request->hasFile('photo')) {
            $photo = (new ImageUploadManager)->file($request->file('photo'))
                    ->name(Utility::prepare_name($request->input('title')))
                    ->path(self::PHOTO_UPLOAD_PATH)
                    ->height($bannerHeight)
                    ->width($bannerWidth)
                    ->upload();

            $data['photo'] = $photo;
        }
        return $data;

    }


    // public function updateBannerInfo(UpdateBannerRequest $request, Banner $banner)
    public function updateBannerInfo(Request  $request, Banner $banner)
    {
        $bannerSize = BannerSize::find($request->input('banner_size_id'));
        $bannerHeight = $bannerSize ? $bannerSize->height : self::PHOTO_HEIGHT;
        $bannerWidth = $bannerSize ? $bannerSize->width : self::PHOTO_WIDTH;
        $bannerLocation = $bannerSize ? $bannerSize->location : null;
        
        // $updateBanerInfoData = [];

        // if ($request->has('photo')) {
        //     ImageUploadManager::deletePhoto(Banner::PHOTO_UPLOAD_PATH, $banner->photo);
        //     $updateBanerInfoData['photo'] = (new ImageUploadManager)->file($request->file('photo'))
        //         ->name(Utility::prepare_name($request->input('title')))
        //         ->path(self::PHOTO_UPLOAD_PATH)
        //         ->height($bannerHeight)
        //         ->width($bannerWidth)
        //         ->upload();
        // }
        $updateBannerInfoData = [
            'title'          => $request->input('title') ?? $banner->title,
            'status'         => $request->input('status') ?? $banner->status,
            'type'           => $request->input('type') ?? $banner->type,
            'serial'         => $request->input('serial') ?? $banner->serial,
            'banner_size_id' => $request->input('banner_size_id') ?? $banner->banner_size_id,
            // 'photo'          => $updateBanerInfoData['photo'] ?? $banner->photo,
            'location'       => $bannerLocation ?? $banner->location,
            'user_id'     => Auth::id(),
        ];

        $photo = $banner->photo;

        if ($request->hasFile('photo')) {
            if ($photo) {
                ImageUploadManager::deletePhoto(self::PHOTO_UPLOAD_PATH, $banner->photo);
            }
            $photo = (new ImageUploadManager)->file($request->file('photo'))
                ->name(Utility::prepare_name($request->input('title')))
                ->path(self::PHOTO_UPLOAD_PATH)
                ->height($bannerHeight)
                ->width($bannerWidth)
                ->upload();

        }
       
        $updateBannerInfoData['photo'] = $photo;

        $banner->update($updateBannerInfoData);

        if ($banner->seos) {
            $seoData = (new Seo)->updateSeo($request, $banner->seos);
            $banner->seos()->update($seoData);
        } else {
            $seoData = (new Seo)->prepareSeoData($request);
            $banner->seos()->create($seoData);
        }

        return $banner;

        // return $banner->update($updateBannerInfoData);

    }

    public function bannerSize()
    {
        return $this->belongsTo(BannerSize::class);
    }

    public function seos(){
        return $this->morphOne(Seo::class, 'seoable');
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
