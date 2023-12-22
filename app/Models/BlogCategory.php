<?php

namespace App\Models;

use App\Http\Requests\StoreBlogCategoryRequest;
use App\Http\Requests\UpdateBlogCategoryRequest;
use App\Manager\ImageUploadManager;
use App\Manager\Utility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Array_;

class BlogCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public int $count = 0;
    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 2;

    public const STATUS_LIST = [
        self::STATUS_ACTIVE   => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    public const BLOG = 1;
    public const VLOG = 2;

    public const TYPE_LIST = [
        self::BLOG => 'Blog',
        self::VLOG => 'Vlog',
    ];

    public const PHOTO_UPLOAD_PATH = 'uploads/blog_category/';
    public const PHOTO_UPLOAD_PATH_THUMB = 'uploads/blog_category/thumb/';
    public const PHOTO_WIDTH = 600;
    public const PHOTO_HEIGHT = 600;
    public const PHOTO_WIDTH_THUMB = 150;
    public const PHOTO_HEIGHT_THUMB = 150;


    public const COVER_PHOTO_UPLOAD_PATH = 'uploads/blog_category/cover_photo/';
    public const COVER_PHOTO_UPLOAD_PATH_THUMB = 'uploads/blog_category/cover_photo/thumb/';
    public const COVER_PHOTO_WIDTH = 1000;
    public const COVER_PHOTO_HEIGHT = 450;
    public const COVER_PHOTO_WIDTH_THUMB = 150;
    public const COVER_PHOTO_HEIGHT_THUMB = 150;


    public function getBlogCategoryAssoc()
    {
        return self::query()->where('status', self::STATUS_ACTIVE)->pluck('name', 'id');
    }

    public function blog_posts()
    {
        return $this->hasMany(BlogPost::class);
    }

    public function posts()
    {
        return $this->hasMany(BlogPost::class);
    }

    public function storeBlogCategory(StoreBlogCategoryRequest $request)
    {
        $blogCategory = self::query()->create($this->prepareBlogCategoryData($request));
        $seoData      = (new Seo)->prepareSeoData($request);
        $blogCategory->seos()->create($seoData);
        return $blogCategory;
    }

    private function prepareBlogCategoryData(StoreBlogCategoryRequest $request)
    {
        $data = [
            'name'    => $request->input('name'),
            'slug'    => $request->input('slug'),
            'status'  => $request->input('status'),
            'type'    => $request->input('type'),
            'user_id' => Auth::id(),
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

        if ($request->hasFile('cover_photo')) {
            $coverPhoto = (new ImageUploadManager)->file($request->file('cover_photo'))
                ->name(Utility::prepare_name($request->input('slug')))
                ->path(self::COVER_PHOTO_UPLOAD_PATH)
                ->height(self::COVER_PHOTO_HEIGHT)
                ->width(self::COVER_PHOTO_WIDTH)
                ->upload();

            $data['cover_photo'] = $coverPhoto;
        }

        return $data;
    }

    public function allBlogCategoryList(Request $request)
    {
        $paginate = $request->input('per_page') ?? 10;
        $query    = self::query()->with(['user']);
        if ($request->input('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->input('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->input('type')) {
            $query->where('type', $request->input('type'));
        }
        if ($request->input('sort_by') && $request->input('sort_direction')) {
            $query->orderBy($request->input('sort_by'), $request->input('sort_direction'));
        } else {
            $query->orderByDesc('id');
        }
        return $query->paginate($paginate);
    }

    public function updateBlogCategory(UpdateBlogCategoryRequest $request, BlogCategory $blogCategory)
    {
        $updateBlogCategoryData = [
            'name'    => $request->input('name') ?? $blogCategory->name,
            'slug'    => $request->input('slug') ?? $blogCategory->slug,
            'status'  => $request->input('status') ?? $blogCategory->status,
            'type'    => $request->input('type') ?? $blogCategory->type,
            'user_id' => Auth::id()
        ];
        $photo                  = $blogCategory->photo;

        if ($request->hasFile('photo')) {
            if ($photo) {
                ImageUploadManager::deletePhoto(self::PHOTO_UPLOAD_PATH, $blogCategory->photo);
            }
            $photo = (new ImageUploadManager)->file($request->file('photo'))
                ->name(Utility::prepare_name($request->input('slug')))
                ->path(self::PHOTO_UPLOAD_PATH)
                ->height(self::PHOTO_HEIGHT)
                ->width(self::PHOTO_WIDTH)
                ->upload();

        }

        $cover_photo = $blogCategory->cover_photo;
        if ($request->hasFile('cover_photo')) {
            if ($cover_photo) {
                ImageUploadManager::deletePhoto(self::COVER_PHOTO_UPLOAD_PATH, $blogCategory->cover_photo);
            }
            $cover_photo = (new ImageUploadManager)->file($request->file('cover_photo'))
                ->name(Utility::prepare_name($request->input('slug')))
                ->path(self::COVER_PHOTO_UPLOAD_PATH)
                ->height(self::COVER_PHOTO_HEIGHT)
                ->width(self::COVER_PHOTO_WIDTH)
                ->upload();

        }
        $updateBlogCategoryData['photo']       = $photo;
        $updateBlogCategoryData['cover_photo'] = $cover_photo;

        $blogCategory->update($updateBlogCategoryData);

        if ($blogCategory->seos) {
            $seoData = (new Seo)->updateSeo($request, $blogCategory->seos);
            $blogCategory->seos()->update($seoData);
        } else {
            $seoData = (new Seo)->prepareSeoData($request);
            $blogCategory->seos()->create($seoData);
        }

        return $blogCategory;


    }


    public function bolgCategory()
    {
        return self::query()->pluck('name', 'id');
    }

    public function getBlogCategory()
    {
        return self::all();

    }

    public function getBlogCategoryWithCount()
    {
        return self::query()->withCount('blog_posts')
            ->where('status', self::STATUS_ACTIVE)
            ->get();
    }

    public function seos()
    {
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
