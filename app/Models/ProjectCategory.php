<?php

namespace App\Models;

use App\Manager\Utility;
use Illuminate\Http\Request;
use App\Manager\ImageUploadManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\StoreProjectCategoryRequest;
use App\Http\Requests\UpdateProjectCategoryRequest;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProjectCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const PHOTO_UPLOAD_PATH = 'uploads/project_category/';
    public const PHOTO_WIDTH = 600;
    public const PHOTO_HEIGHT = 600;
    public const PHOTO_WIDTH_THUMB = 150;
    public const PHOTO_HEIGHT_THUMB = 150;

    public const BANNER__UPLOAD_PATH_THUMB = 'uploads/category_banner/thumb/';
    public const BANNER_WIDTH = 1000;
    public const BANNER_HEIGHT = 450;
    public const BANNER_WIDTH_THUMB = 150;
    public const BANNER_HEIGHT_THUMB = 150;


    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 2;

    public const STATUS_LIST = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];


    final public function getProjectCategoryList(Request $request)
    {
        $paginate  = $request->input('per_page') ?? 10;
        $query     = self::query()->with(['user']);
        if ($request->input('name')){
            $query->where('name', 'like', '%'.$request->input('name').'%');
        }
        if ($request->input('slug')){
            $query->where('slug', 'like', '%'.$request->input('slug').'%');
        }
        if ($request->input('description')){
            $query->where('description', 'like', '%'.$request->input('description').'%');
        }
         if ($request->input('status') || $request->input('status') === 0){
            $query->where('status', $request->input('status'));
        }
        if ($request->input('serial')){
            $query->where('serial', $request->input('serial'));
        }
        if ($request->input('sort_by') && $request->input('sort_direction')) {
            $query->orderBy($request->input('sort_by'), $request->input('sort_direction'));
        } else {
            $query->orderByDesc('id');
        }
        return $query->paginate($paginate);
    }

       public function createProjectCategory(StoreProjectCategoryRequest $request)
    {
        $projectCategory=self::query()->create($this->prepareNewProjectCategoryData($request));
        $seoData = (new Seo)->prepareSeoData($request);
        $projectCategory->seos()->create($seoData);

        return $projectCategory;

              
    }
        private function prepareNewProjectCategoryData(StoreProjectCategoryRequest $request)
    {
        $data = [
            'name'        => $request->input('name'),
            'slug'        => $request->input('slug'),
            'serial'      => $request->input('serial'),
            'description' => $request->input('description'),
            'status'      => $request->input('status'),
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
                ->path(self::BANNER__UPLOAD_PATH_THUMB)
                ->height(self::BANNER_HEIGHT)
                ->width(self::BANNER_WIDTH)
                ->upload();

            $data['banner'] = $bannerPhoto;
        }
        return $data;
    }

       public function updateProjectCategoryInfo(UpdateProjectCategoryRequest $request, ProjectCategory $projectCategory)
    {
        $updateProjectCategoryInfoData = [
            'name'        => $request->input('name') ?? $projectCategory->name,
            'slug'        => $request->input('slug') ?? $projectCategory->slug,
            'serial'      => $request->input('serial') ?? $projectCategory->serial,
            'status'      => $request->input('status') ?? $projectCategory->status,
            'description' => $request->input('description') ?? $projectCategory->description,
            'user_id'     => Auth::id()
        ];
        $photo   = $projectCategory->photo;
        if ($request->hasFile('photo')) {
            if ($photo) {
                ImageUploadManager::deletePhoto(self::PHOTO_UPLOAD_PATH, $projectCategory->photo);
            }
            $photo = (new ImageUploadManager)->file($request->file('photo'))
                ->name(Utility::prepare_name($request->input('slug')))
                ->path(self::PHOTO_UPLOAD_PATH)
                ->height(self::PHOTO_HEIGHT)
                ->width(self::PHOTO_WIDTH)
                ->upload();

        }
        $banner = $projectCategory->banner;
        if ($request->hasFile('banner')) {
            if ($banner) {
                ImageUploadManager::deletePhoto(self::BANNER__UPLOAD_PATH_THUMB, $projectCategory->banner);
            }
            $banner = (new ImageUploadManager)->file($request->file('banner'))
                ->name(Utility::prepare_name($request->input('slug')))
                ->path(self::BANNER__UPLOAD_PATH_THUMB)
                ->height(self::BANNER_HEIGHT)
                ->width(self::BANNER_WIDTH)
                ->upload();

        }
        $updateProjectCategoryInfoData['photo']  = $photo;
        $updateProjectCategoryInfoData['banner'] = $banner;

     

         $projectCategory->update($updateProjectCategoryInfoData);
        if ($projectCategory->seos) {
            $seoData = (new Seo)->updateSeo($request, $projectCategory->seos);
            $projectCategory->seos()->update($seoData);
        } else {
            $seoData = (new Seo)->prepareSeoData($request);
            $projectCategory->seos()->create($seoData);
        }

        return $projectCategory;

    }
    final public function getProjectCategoryListapi()
    {
        return self::query()->orderBy('id', 'desc')->get();
    }

    final public function getProjectCategoryById(ProjectCategory $projectCategory): ProjectCategory
    {
        return self::query()->findOrFail($projectCategory);
    }

    final public function deleteProjectCategoryById(ProjectCategory $projectCategory): bool
    {
        return self::query()->where('id', $projectCategory->id)->delete();
    }


    public function address()
    {
        return $this->morphMany(Address::class, 'addressable');
    }
    //     public function address_type()
    // {
    //     return $this->belongsTo(Address::class);
    // }
    public function projects(): HasMany
    {
        return $this->hasMany(OurProject::class, 'project_category_id');
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
