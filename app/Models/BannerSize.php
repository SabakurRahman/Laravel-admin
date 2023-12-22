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
use App\Http\Requests\StoreBannerSizeRequest;
use App\Http\Requests\UpdateBannerSizeRequest;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BannerSize extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 2;

    public const STATUS_LIST = [
        self::STATUS_ACTIVE   => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    public function getBannerSizeList(Request $request)
    {
        $paginate  = $request->input('per_page') ?? 10;
        $query     = self::query()->with(['user']);
        if ($request->input('banner_name')){
            $query->where('banner_name', 'like', '%'.$request->input('banner_name').'%');
        }
        if ($request->input('location')){
            $query->where('location', 'like', '%'.$request->input('location').'%');
        }
        if ($request->input('width')){
            $query->where('width', $request->input('width'));
        }
        if ($request->input('height')){
            $query->where('height', $request->input('height'));
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

    public function createNewBannerSizeInfo(StoreBannerSizeRequest $request)
    {
        return self::query()->create($this->prepareNewBannerSizeData($request));
    }

    private function prepareNewBannerSizeData(StoreBannerSizeRequest $request)
    {
        return [
            'banner_name'   => $request->input('banner_name'),
            'height'        => $request->input('height'),
            'width'         => $request->input('width'),
            'location'      => $request->input('location'),
            'user_id'       => Auth::id(),
            
        ];
    }
    // )
     public function updateBannerSizeInfo(UpdateBannerSizeRequest $request, BannerSize $bannerSize)
    {
        $updateBannerSizeInfoData = [

            'banner_name'=> $request->input('banner_name')?? $bannerSize->banner_name,
            'height'     => $request->input('height')?? $bannerSize->height,
            'width'      => $request->input('width')?? $bannerSize->width,
            'location'   => $request->input('location')?? $bannerSize->location,
            'user_id'    => Auth::id()
 
        ];
        $bannerSize->update($updateBannerSizeInfoData);

        return $bannerSize;


    }


    // public function getBannerSize()
    // {
    //     return BannerSize::select('id', 'height', 'width')->get();
    // }
    
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
