<?php

namespace App\Models;

use App\Manager\Utility;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Request;
use Laravel\Sanctum\Guard;
use App\Manager\ImageUploadManager;
use App\Models\OurApproachCategory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\StoreourApproachRequest;
use App\Http\Requests\UpdateourApproachRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class OurApproach extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 2;

    public const STATUS_LIST = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    public const BANNER_UPLOAD_PATH = 'uploads/ourapproach/banner/';
    public const BANNER_WIDTH = 1000;
    public const BANNER_HEIGHT = 450;





    final public function getOurApproachList(Request $request)
    {
        $paginate  = $request->input('per_page') ?? 10;
        $query = self::query();
        if ($request->input('name')){
            $query->where('name', 'like', '%'.$request->input('name').'%');
        }
        if ($request->input('status')){
            $query->where('status', $request->input('status'));
        }
        if ($request->input('our_approach_category_id')){
            $query->where('our_approach_category_id', $request->input('our_approach_category_id'));
        }

        if ($request->input('sort_by') && $request->input('sort_direction')) {
            $query->orderBy($request->input('sort_by'), $request->input('sort_direction'));
        } else {
            $query->orderByDesc('id');
        }
        return $query->paginate($paginate);
    }
    final public function getOurApproachListforFrontend()
    {
        return $this->get();
    }

    final public function getOurApproachById($id)
    {
        return $this->where('id', $id)->first();
    }

    final public function getOurApproachBySlug($slug)
    {
        return $this->where('slug', $slug)->first();
    }


    final public function prepareApporachData(StoreourApproachRequest|UpdateourApproachRequest $request, OurApproach|null $ourapproach = null)
{
    $data = [
        'name'   => $request->input('name') ?? ($ourapproach ? $ourapproach->name : null),
        'slug'   => $request->input('slug') ?? ($ourapproach ? $ourapproach->slug : null),
        'status' => $request->input('status') ?? ($ourapproach ? $ourapproach->status : null),
        'serial' => $request->input('serial') ?? ($ourapproach ? $ourapproach->serial : null),
        'description' => $request->input('description') ?? ($ourapproach ? $ourapproach->description : null),
        'short_description' => $request->input('short_description'),
        'our_approach_category_id' => $request->input('our_approach_category_id') ?? ($ourapproach ? $ourapproach->our_approach_category_id : null),
    ];

    // Upload the banner image if it's provided in the request
    if ($request->hasFile('banner')) {
        $data['banner'] = (new ImageUploadManager)
            ->file($request->file('banner'))
            ->name(Utility::prepare_name('banner' . $request->input('slug')))
            ->path(self::BANNER_UPLOAD_PATH)
            ->height(self::BANNER_HEIGHT)
            ->width(self::BANNER_WIDTH)
            ->upload();
    } elseif ($ourapproach && $ourapproach->banner) {
        // If no new banner image is provided, retain the existing one
        $data['banner'] = $ourapproach->banner;
    }

    return $data;
}





    final public function storeOurApproach($ourapproach)
    {
        return $this->create($ourapproach);
    }


   final public function updateOurApproach(OurApproach $ourapproach, $ourapproach_data)
    {
         $ourapproach->update($ourapproach_data);
         return $ourapproach;
    }


    final public function deleteOurApproach($id)
    {
        return $this->where('id', $id)->delete();
    }



    public function ourApproachCategory()
    {
        return $this->belongsTo(OurApproachCategory::class);
    }


    final public function getOurApproachDetails($slug)
    {
        return self::query()->whereHas('ourApproachCategory', function ($q) use ($slug){
            $q->where('slug', $slug);
        })->first();
    }


    public function seos(){
        return $this->morphMany(Seo::class, 'seoable');
    }


    final public function activity_logs():MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }




}
