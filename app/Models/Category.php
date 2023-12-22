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
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use PhpParser\Node\Expr\Array_;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    public const STATUS_LIST = [
        self::STATUS_ACTIVE   => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    public const PHOTO_UPLOAD_PATH = 'uploads/category/';
    public const PHOTO_UPLOAD_PATH_THUMB = 'uploads/category/thumb/';
    public const PHOTO_WIDTH =53;
    public const PHOTO_HEIGHT = 53;
    public const PHOTO_WIDTH_THUMB = 150;
    public const PHOTO_HEIGHT_THUMB = 150;


    public const BANNER_UPLOAD_PATH = 'uploads/category_banner/';
    public const BANNER_UPLOAD_PATH_THUMB = 'uploads/category_banner/thumb/';
    public const BANNER_WIDTH = 350;
    public const BANNER_HEIGHT = 350;
    public const BANNER_WIDTH_THUMB = 150;
    public const BANNER_HEIGHT_THUMB = 150;

    public function getCategoryList(Request $request)
    {
        $paginate  = $request->input('per_page') ?? 10;
        $query    = self::query()->with(['user']);
        if ($request->input('name')){
            $query->where('name', 'like', '%'.$request->input('name').'%');
        }
        if ($request->input('slug')){
            $query->where('slug', 'like', '%'.$request->input('slug').'%');
        }
        if ($request->input('description')){
            $query->where('description', 'like', '%'.$request->input('description').'%');
        }
         if ($request->input('status')){
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


    public function createNewCategory(StoreCategoryRequest $request)
    {
        $category=self::query()->create($this->prepareNewCategoryData($request));
        $seoData = (new Seo)->prepareSeoData($request);
        $category->seos()->create($seoData);

        return $category;


    }

    private function prepareNewCategoryData(StoreCategoryRequest $request)
    {
        $parentCategory   = Category::find($request->input('category_id'));
        $data = [
            'name'        => $request->input('name'),
            'slug'        => $request->input('slug'),
            'serial'      => $request->input('serial'),
            'description' => $request->input('description'),
            'status'      => $request->input('status'),
            'category_id' => $request->input('category_id'),
            'user_id'     => Auth::id(),
            // 'photo'  => (new ImageUploadManager)->file($request->file('photo'))
            //     ->name(Utility::prepare_name($request->input('slug')))
            //     ->path(self::PHOTO_UPLOAD_PATH)
            //     ->height(self::PHOTO_HEIGHT)
            //     ->width(self::PHOTO_WIDTH)
            //     ->upload(),
            // 'banner'  => (new ImageUploadManager)->file($request->file('banner'))
            //     ->name(Utility::prepare_name($request->input('slug')))
            //     ->path(self::BANNER_UPLOAD_PATH)
            //     ->height(self::BANNER_HEIGHT)
            //     ->width(self::BANNER_WIDTH)
            //     ->upload(),
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


    public function updateCategoryInfo(UpdateCategoryRequest $request, Category $category)
    {
        $updateCategoryInfoData = [
            'name'        => $request->input('name') ?? $category->name,
            'slug'        => $request->input('slug') ?? $category->slug,
            'serial'      => $request->input('serial') ?? $category->serial,
            'status'      => $request->input('status') ?? $category->status,
            'description' => $request->input('description') ?? $category->description,
            'category_id' => $request->input('category_id') ?? $category->category_id,
            'user_id'     => Auth::id()
        ];
        // if($request->has('photo')){
        //      ImageUploadManager::deletePhoto(self::PHOTO_UPLOAD_PATH, $category->photo);
        //     $updateCategoryInfoData['photo' ]   = (new ImageUploadManager)->file($request->file('photo'))
        //         ->name(Utility::prepare_name($request->input('slug')))
        //         ->path(self::PHOTO_UPLOAD_PATH)
        //         ->height(self::PHOTO_HEIGHT)
        //         ->width(self::PHOTO_WIDTH)
        //         ->upload();
        // }
        $photo   = $category->photo;
        if ($request->hasFile('photo')) {
            if ($photo) {
                ImageUploadManager::deletePhoto(self::PHOTO_UPLOAD_PATH, $category->photo);
            }
            $photo = (new ImageUploadManager)->file($request->file('photo'))
                ->name(Utility::prepare_name($request->input('slug')))
                ->path(self::PHOTO_UPLOAD_PATH)
                ->height(self::PHOTO_HEIGHT)
                ->width(self::PHOTO_WIDTH)
                ->upload();

        }

        $banner = $category->banner;
        if ($request->hasFile('banner')) {
            if ($banner) {
                ImageUploadManager::deletePhoto(self::BANNER_UPLOAD_PATH, $category->banner);
            }
            $banner = (new ImageUploadManager)->file($request->file('banner'))
                ->name(Utility::prepare_name($request->input('slug')))
                ->path(self::BANNER_UPLOAD_PATH)
                ->height(self::BANNER_HEIGHT)
                ->width(self::BANNER_WIDTH)
                ->upload();

        }
        $updateCategoryInfoData['photo']  = $photo;
        $updateCategoryInfoData['banner'] = $banner;

        // if($request->has('banner')){

        // ImageUploadManager::deletePhoto(self::BANNER_UPLOAD_PATH, $category->banner);
        //     $updateCategoryInfoData['banner']   = (new ImageUploadManager)->file($request->file('banner'))
        //         ->name(Utility::prepare_name($request->input('slug')))
        //         ->path(self::BANNER_UPLOAD_PATH)
        //         ->height(self::BANNER_HEIGHT)
        //         ->width(self::BANNER_WIDTH)
        //         ->upload();
        // }

         $category->update($updateCategoryInfoData);
        if ($category->seos) {
            $seoData = (new Seo)->updateSeo($request, $category->seos);
            $category->seos()->update($seoData);
        } else {
            $seoData = (new Seo)->prepareSeoData($request);
            $category->seos()->create($seoData);
        }

        return $category;

    }
    // public function getFullHierarchyAttribute()
    // {
    //     $hierarchy = $this->name;
    //     $parent = $this->parentCategory;

    //     while ($parent) {
    //         if ($parent->name) {
    //             $hierarchy = $parent->name . ' >> ' . $hierarchy;
    //             $parent = $parent->parentCategory;
    //         } else {
    //             break;  // Break the loop if the parent category doesn't have a name
    //         }
    //     }
    //     return $hierarchy;
    // }

    public function getFullHierarchyAttribute()
    {
        $hierarchy = $this->name;
        $parent    = $this->parentCategory;
        while ($parent) {
            $hierarchy = $parent->name . ' >> ' . $hierarchy;
            $parent = $parent->parentCategory;
        }

        return $hierarchy;
    }

    public function getCategory()
    {
        return self::query()->whereNull('category_id')->get();

    }

    //  public function products(): BelongsToMany
    // {
    //     return $this->belongsToMany(Product::class);
    // }
      public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product', 'category_id', 'product_id');
    }
    public function parentCategory(){
        return $this->belongsTo(Category::class,'category_id','id', 'parent_category_id');
    }
    final public function getSubCategories()
    {
        return $this->hasMany(Category::class, 'category_id');
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

    public function getCategoryBySlug(string $slug)
    {
        return self::query()->where('slug', $slug)->first();
    }


    public function sub_category()
    {
        return $this->belongsTo(self::class);
    }

}


