<?php

namespace App\Models;

use App\Manager\Utility;
use Laravel\Sanctum\Guard;
use Illuminate\Http\Request;
use App\Manager\ImageUploadManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Http\Requests\StoreOurApproachCategoryRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Requests\UpdateOurApproachCategoryRequest;

class OurApproachCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 2;

    public const PHOTO_UPLOAD_PATH = 'uploads/ourapproachcategory/';
    public const PHOTO_WIDTH = 600;
    public const PHOTO_HEIGHT = 600;

    public const Banner_UPLOAD_PATH = 'uploads/ourapproachcategory/banner/';
    public const BANNER_WIDTH = 1000;
    public const BANNER_HEIGHT = 450;




    public const STATUS_LIST = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    final public function getOurApproachCategoryList(Request $request)
    {
        $paginate  = $request->input('per_page') ?? 10;
        $query = self::query();
        if ($request->input('name')){
            $query->where('name', 'like', '%'.$request->input('name').'%');
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

    final public function getOurApproachCategoryById($id)
    {
        return $this->where('id', $id)->first();
    }

    final public function getOurApproachCategoryBySlug($slug)
    {
        return $this->where('slug', $slug)->first();
    }


    final public function prepareOurApproachCategory(Request $request, OurApproachCategory|null $ourapproachcategory = null)
{
    $approach_cate = [
        'name' => $request->input('name'),
        'slug' => $request->input('slug'),
        'description' => $request->input('description'),
        'status' => $request->input('status'),
        'serial' => $request->input('serial'),
    ];

    // Upload the photo if it's provided in the request or retain the existing one
    if ($request->hasFile('photo')) {
        $approach_cate['photo'] = (new ImageUploadManager)
            ->file($request->file('photo'))
            ->name(Utility::prepare_name($request->input('slug')))
            ->path(self::PHOTO_UPLOAD_PATH)
            ->height(self::PHOTO_HEIGHT)
            ->width(self::PHOTO_WIDTH)
            ->upload();
    } elseif ($ourapproachcategory && $ourapproachcategory->photo) {
        $approach_cate['photo'] = $ourapproachcategory->photo;
    }

    return $approach_cate;
}



    final public function createNewOurApproachCategory(array $data)
    {
        return self::query()->create($data);
    }


    final public function updateOurApproachCategory(array $data,OurApproachCategory $ourapproachcategory)
    {
         $ourapproachcategory->update($data);
         return $ourapproachcategory;
    }

    final public function deleteOurApproachCategory(OurApproachCategory $ourapproachcategory)
    {
        return $ourapproachcategory->delete();
    }
    final public function activity_logs():MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }

    public function ourApprochCategoryList()
    {
        return self::query()->pluck('name', 'id');
    }

        public function ourApproach(): HasMany
    {
        return $this->hasMany(OurApproach::class, 'our_approach_category_id','id');
    }

}
