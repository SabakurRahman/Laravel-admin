<?php

namespace App\Models;

use App\Manager\Utility;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Manager\ImageUploadManager;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\StoreEstimateCategoryRequest;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Http\Requests\UpdateEstimateCategoryRequest;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EstimateCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const OFFICE_INTERIOR = 1;
    public const HOME_INTERIOR = 2;

    public const TYPES_LIST = [
        self::OFFICE_INTERIOR => 'Office Interior',
        self::HOME_INTERIOR   => 'Home Interior',
    ];

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 2;

    public const STATUS_LIST = [
        self::STATUS_ACTIVE   => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];


    public const PHOTO_UPLOAD_PATH = 'uploads/estimatecategory/';
    public const PHOTO_WIDTH = 800;
    public const PHOTO_HEIGHT = 800;

    public const BANNER_UPLOAD_PATH = 'uploads/estimate_category_banner/';
    public const BANNER_WIDTH = 1920;
    public const BANNER_HEIGHT = 450;

    /**
     * @param Builder $query
     * @return Builder
     */
    final public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    final public function getEstimateSubCategoryList(Request $request)
    {

        $query = self::query()->with(['user']);
        $query->whereNotNull('category_id');
        if ($request->input('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->input('slug')) {
            $query->where('slug', 'like', '%' . $request->input('slug') . '%');
        }
        if ($request->input('type')) {
            $query->where('type', $request->input('type'));
        }
        if ($request->input('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->input('serial')) {
            $query->where('serial', $request->input('serial'));
        }
        if ($request->input('sort_by') && $request->input('sort_direction')) {
            $query->orderBy($request->input('sort_by'), $request->input('sort_direction'));
        } else {
            $query->orderByDesc('id');
        }
        $paginate = $request->input('per_page') ?? 10;
        return $query->paginate($paginate);
    }


    public function getEstimateCategoryList(Request $request)
    {
        $query = self::query()->with(['user']);
        $query->whereNull('category_id');

        if ($request->input('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->input('slug')) {
            $query->where('slug', 'like', '%' . $request->input('slug') . '%');
        }
        if ($request->input('type')) {
            $query->where('type', $request->input('type'));
        }
        if ($request->input('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->input('serial')) {
            $query->where('serial', $request->input('serial'));
        }
        if ($request->input('sort_by') && $request->input('sort_direction')) {
            $query->orderBy($request->input('sort_by'), $request->input('sort_direction'));
        } else {
            $query->orderByDesc('id');
        }

        $paginate = $request->input('per_page') ?? 10;
        return $query->paginate($paginate);
    }


    public function createNewEstimateCategory(StoreEstimateCategoryRequest $request)
    {
        $EstimateCategory = self::query()->create($this->prepareNewEstimateCategoryData($request));
        $seoData          = (new Seo)->prepareSeoData($request);
        $EstimateCategory->seos()->create($seoData);

        return $EstimateCategory;
    }

    private function prepareNewEstimateCategoryData(StoreEstimateCategoryRequest $request)
    {
        $parentCategory = EstimateCategory::find($request->input('category_id'));
        $data           = [
            'name'        => $request->input('name'),
            'slug'        => $request->input('slug'),
            'serial'      => $request->input('serial'),
            'description' => $request->input('description'),
            'status'      => $request->input('status'),
            'type'        => $request->input('type'),
            'category_id' => $request->input('category_id'),
            'user_id'     => Auth::id(),
        ];
        if ($request->hasFile('photo')) {
            $photo = (new ImageUploadManager)->file($request->file('photo'))
                ->name(Utility::prepare_name($request->input('slug')))
                ->path(self::PHOTO_UPLOAD_PATH)
                ->height(self::PHOTO_HEIGHT)
                ->width(self::PHOTO_WIDTH)
                ->upload();

            $data['photo'] = $photo;
        }
        if ($request->hasFile('banner')) {
            $bannerPhoto = (new ImageUploadManager)->file($request->file('banner'))
                ->name(Utility::prepare_name($request->input('slug')))
                ->path(self::BANNER_UPLOAD_PATH)
                ->height(self::BANNER_HEIGHT)
                ->width(self::BANNER_WIDTH)
                ->upload();

            $data['banner'] = $bannerPhoto;
        }
        return $data;
    }

    public function updateEstimateCategoryInfo(UpdateEstimateCategoryRequest $request, EstimateCategory $EstimateCategory)
    {
        $updateEstimateCategoryInfoData = [
            'name'        => $request->input('name') ?? $EstimateCategory->name,
            'slug'        => $request->input('slug') ?? $EstimateCategory->slug,
            'serial'      => $request->input('serial') ?? $EstimateCategory->serial,
            'description' => $request->input('description') ?? $EstimateCategory->description,
            'status'      => $request->input('status') ?? $EstimateCategory->status,
            'type'        => $request->input('type') ?? $EstimateCategory->type,
            'category_id' => $request->input('category_id') ?? $EstimateCategory->category_id,
            'user_id'     => Auth::id(),
        ];
        $photo                          = $EstimateCategory->photo;
        if ($request->hasFile('photo')) {
            if ($photo) {
                ImageUploadManager::deletePhoto(self::PHOTO_UPLOAD_PATH, $EstimateCategory->photo);
            }
            $photo = (new ImageUploadManager)->file($request->file('photo'))
                ->name(Utility::prepare_name($request->input('slug')))
                ->path(self::PHOTO_UPLOAD_PATH)
                ->height(self::PHOTO_HEIGHT)
                ->width(self::PHOTO_WIDTH)
                ->upload();
        }

        $banner = $EstimateCategory->banner;
        if ($request->hasFile('banner')) {
            if ($banner) {
                ImageUploadManager::deletePhoto(self::BANNER_UPLOAD_PATH, $EstimateCategory->banner);
            }
            $banner = (new ImageUploadManager)->file($request->file('banner'))
                ->name(Utility::prepare_name($request->input('slug')))
                ->path(self::BANNER_UPLOAD_PATH)
                ->height(self::BANNER_HEIGHT)
                ->width(self::BANNER_WIDTH)
                ->upload();

        }
        $updateEstimateCategoryInfoData['photo']  = $photo;
        $updateEstimateCategoryInfoData['banner'] = $banner;

        $EstimateCategory->update($updateEstimateCategoryInfoData);
        if ($EstimateCategory->seos) {
            $seoData = (new Seo)->updateSeo($request, $EstimateCategory->seos);
            $EstimateCategory->seos()->update($seoData);
        } else {
            $seoData = (new Seo)->prepareSeoData($request);
            $EstimateCategory->seos()->create($seoData);
        }

        return $EstimateCategory;

    }


    // final public function getEstimateCategoryById($id)
    // {
    //     return $this->where('id', $id)->first();
    // }

    // final public function getEstimateCategoryBySlug($slug)
    // {
    //     return $this->where('slug', $slug)->first();
    // }


    // final public function getEstimateCategoryByType($type)
    // {
    //     return $this->where('type', $type)->get();
    // }
    final public function parentCategory(){
        return $this->belongsTo(EstimateCategory::class,'category_id','id', 'parent_category_id');
    }

    public function estimateSubCategory()
    {
        return $this->hasMany(__CLASS__, 'category_id')->whereNotNull('category_id');
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
    final public function activity_logs(): MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }


    /**
     * @param string $type
     * @return mixed
     */
    final public function getAssoc(string $type = 'category'):mixed
    {
        $query = self::query()->active();
        if ($type == 'category') {
            $query->whereNull('category_id');
        } elseif ($type == 'sub') {
            $query->whereNotNull('category_id');
        }
        return $query->get();
    }

}





