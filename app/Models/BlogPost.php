<?php

namespace App\Models;

use App\Manager\Utility;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Manager\ImageUploadManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\StoreBlogPostRequest;
use App\Http\Requests\UpdateBlogPostRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;


class BlogPost extends Model
{
    use HasFactory;

    protected $guarded = [];
    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 2;



    public const IS_FEATURED = 1;

    public const NOT_FEATURED = 2;

    public const  FEATURED_LIST = [
        self::IS_FEATURED  => 'featured',
        self::NOT_FEATURED => 'not_featured'
    ];

    public const STATUS_LIST = [
        self::STATUS_ACTIVE   => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    public const BLOG = 1;
    public const VLOG = 2;

    public const BLOG_TYPE = [
        self::BLOG => 'blog',
        self::VLOG => 'vlog',
    ];


    public const PHOTO_UPLOAD_PATH = 'uploads/blog-post/';
    public const PHOTO_UPLOAD_PATH_THUMB = 'uploads/blog-post/thumb/';
    public const PHOTO_WIDTH = 600;
    public const PHOTO_HEIGHT = 450;
    public const PHOTO_WIDTH_THUMB = 150;
    public const PHOTO_HEIGHT_THUMB = 150;

    public function blog_category()
    {
        return $this->belongsTo(BlogCategory::class);
    }

    public function blog_comments()
    {
        return $this->hasMany(BlogComment::class, 'blog_id')->whereNull('blog_comment_id');
    }



    private function prepareBlogPostData(StoreBlogPostRequest $request):array
    {
        $data=[];
        $data= [
            'user_id'          => Auth::id(),
            'title'            => $request->input('title'),
            'slug'             => $request->input('slug'),
            'description'      => $request->input('description'),
            'status'           => $request->input('status'),
            'type'             => $request->input('type'),
            'video_url'        => $request->input('video'),
            'created_by'       => Auth::id(),
            'blog_category_id' => $request->input('blog_category_id')
        ];


        if($request->has('video')){
         $url = $request->input('video');

            $videoId = '';
            if (preg_match('/[?&]v=([-_a-zA-Z0-9]+)/', $url, $matches)) {
                $videoId = $matches[1];
            }
            $data['video_url'] = 'https://www.youtube.com/embed/'.$videoId;
        }

        return $data;

    }

    public function storeBlogPost(StoreBlogPostRequest $request)
    {
        $post    = self::query()->create($this->prepareBlogPostData($request));// Prepare SEO data from the request
        $seoData = (new Seo)->prepareSeoData($request);
        $post->seos()->create($seoData);


        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $imageUpload = (new ImageUploadManager)
                    ->file($photo)
                    ->name(Utility::prepare_name($request->input('slug'))) // Use 'comment' instead of 'comments' for input field
                    ->path(self::PHOTO_UPLOAD_PATH)
                    ->height(self::PHOTO_HEIGHT)
                    ->width(self::PHOTO_WIDTH)
                    ->upload();
                if ($imageUpload) {
                    $post->blogPhoto()->create([
                        'photo' => $imageUpload
                    ]);
                }
            }
        }

        return $post;
    }


    /**
     * @return LengthAwarePaginator
     */
    final public function allBlogPostList(Request $request): LengthAwarePaginator
    {
        $paginate = $request->input('per_page') ?? 20;
        $query    = self::query();
        if ($request->input('title')) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        }
        if ($request->input('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->input('type')) {
            $query->where('type', $request->input('type'));
        }
        if ($request->input('type')) {
            $query->where('type', $request->input('type'));
        }
        if ($request->input('category_id')) {
            $query->where('blog_category_id', $request->input('category_id'));
        }
        if ($request->input('sort_by') && $request->input('sort_direction')) {
            $query->orderBy($request->input('sort_by'), $request->input('sort_direction'));
        } else {
            $query->orderByDesc('id');
        }

        return $query->with(['blog_category', 'user'])->paginate($paginate);
    }

    public function updateBlogPost(UpdateBlogPostRequest $request, BlogPost $blogPost)
    {

        $updateBlogPostData = [
            'title'            => $request->input('title') ?? $blogPost->title,
            'slug'             => $request->input('slug') ?? $blogPost->slug,
            'description'      => $request->input('description') ?? $blogPost->description,
            'status'           => $request->input('status') ?? $blogPost->status,
            'type'             => $request->input('type') ?? $blogPost->type,
            'created_by'       => Auth::id(),
            'blog_category_id' => $request->input('blog_category_id') ?? $blogPost->blog_category_id,
        ];

        if($request->has('video')){
            $url = $request->input('video');

               $videoId = '';
               if (preg_match('/[?&]v=([-_a-zA-Z0-9]+)/', $url, $matches)) {
                   $videoId = $matches[1];
               }
               $updateBlogPostData['video_url'] = 'https://www.youtube.com/embed/'.$videoId?? $blogPost->video_url;
           }
        $blogPost->update($updateBlogPostData);
    if($request->hasFile('photos'))
    {
        if($blogPost?->blogPhoto)
        {
            foreach ($blogPost->blogPhoto as $photo)
            {
                ImageUploadManager::deletePhoto(self::PHOTO_UPLOAD_PATH, $photo->photo);
                $photo->delete();
            }

        }

        foreach ($request->file('photos') as $photo) {
            $imageUpload = (new ImageUploadManager)
                ->file($photo)
                ->name(Utility::prepare_name($request->input('slug'))) // Use 'comment' instead of 'comments' for input field
                ->path(self::PHOTO_UPLOAD_PATH)
                ->height(self::PHOTO_HEIGHT)
                ->width(self::PHOTO_WIDTH)
                ->upload();
            if ($imageUpload) {
                $blogPost->blogPhoto()->create([
                    'photo' => $imageUpload
                ]);
            }
        }

    }

        if ($blogPost->seos) {
            $seoData = (new Seo)->updateSeo($request, $blogPost->seos);
            $blogPost->seos()->update($seoData);
        } else {
            $seoData = (new Seo)->prepareSeoData($request);
            $blogPost->seos()->create($seoData);
        }
        return $blogPost;
    }

    public function getBlogPost(Request $request)
    {
        $paginate   = $request->input('per_page') ?? 10;
        $all_posts  = self::query()->with('blog_category')
            ->select(['id', 'title', 'slug', 'description', 'type', 'photo', 'blog_category_id'])
            ->get();
        $post_data  = [];
        $categories = BlogCategory::query()->where('status', BlogCategory::STATUS_ACTIVE)->pluck('name', 'id');
        foreach ($categories as $key => $value) {
            $posts = $all_posts->where('blog_category_id', $key)->sortByDesc('id')->take($paginate);
            foreach ($posts as $post) {
                $photo = null;
                if (!empty($post->photo)){
                    $photo = Utility::is_url($post->photo) ?  $post->photo :  url(self::PHOTO_UPLOAD_PATH . $post->photo);
                }else{
                    $photo =  url('uploads/default.webp');
                }
                $post_data[$value][] = [
                    'id'          => $post->id,
                    'title'       => $post->title,
                    'slug'        => $post->slug,
                    'description' => Str::limit($post->description, 200),
                    'type'        => $post->type,
                    'photo'       => $photo,
                    'video'       => $post->video_url,
                ];
            }
        }
        return $post_data;
    }



    final public function getBlogforFrontend(Request $request){
        $limitation = $request->input('limit') ?? 10;
        $vloglimit = $request->input('vloglimit') ?? 3;
        $query = self::query()->orderBy('id', 'desc')
            ->where('status', self::STATUS_ACTIVE)
            ->with('blog_category')
            ->get();

        $category = BlogCategory::query()->where('status', BlogCategory::STATUS_ACTIVE)->pluck('name', 'id');
        $post_data = [];
        foreach ($category as $key => $value) {
            $posts = $query->where('blog_category_id', $key)->sortByDesc('id');
             $vlogcount =0;
             $blogcount = 0;
            foreach ($posts as $post) {
                $photo = null;
                if (!empty($post->photo)){
                    $photo = Utility::is_url($post->photo) ?  $post->photo :  url(self::PHOTO_UPLOAD_PATH . $post->photo);
                }else{
                    $photo =  url('uploads/default.webp');
                }


                if ($post->type == self::BLOG && $blogcount < $limitation){
                    $blogcount++;
                    $post_data[$value]['blog'][] = [
                        'id'          => $post->id,
                        'title'       => $post->title,
                        'slug'        => $post->slug,
                        'description' => Str::limit($post->description, 200),
                        'type'        => $post->type,
                        'photo'       => $photo,
                    ];
                }
            elseif( ($post->type == self::VLOG) && $vlogcount < $vloglimit  ){
                $vlogcount++;

                $post_data[$value]['vlog'][] = [
                    'id'          => $post->id,
                    'title'       => $post->title,
                    'slug'        => $post->slug,
                    'description' => Str::limit($post->description, 200),
                    'type'        => $post->type,
                    'photo'       => $photo,
                    'video'       => $post->video_url,
                    'count'       => $vlogcount,

                ];

            }
        }

        }
            return $post_data;

    }





    public function getBlogPostBySlug($request,$slug)
    {
        $blogPost = self::query()->orderBy('id', 'desc')
            ->with('blog_comments','blogPhoto', 'blog_comments.replies')
            ->where('slug', $slug)
            ->where('status', self::STATUS_ACTIVE)->first();

        $ip = $request->ip();
        $cacheKey = "blog_post_{$blogPost->id}_ip_{$ip}";

        // Check if this cache key exists (i.e., the same IP viewed the same blog post within the last 5 minutes).
        if (!Cache::has($cacheKey)) {
            // Increment the read_count in the database.
            $blogPost->increment('read_count');

            // Set the cache key to prevent multiple counts within 5 minutes.
            Cache::put($cacheKey, true, now()->addMinutes(1));
        }

        // You can return the blog post data as needed.
        return $blogPost;

    }

    public function getFeaturedPost()
    {
        return self::query()->orderBy('id', 'desc')
            ->where('status', self::STATUS_ACTIVE)
            ->where('is_featured', self::IS_FEATURED)
            ->take (3)
            ->get();

    }

    public function getRelatedPost($slug)
    {
        $query = self::query()->where('slug', $slug)->first();

        return self::query()->where('type', $query->type)
            ->where('id', '!=', $query->id)
            ->take (3)
            ->get();

    }

    public function getBlogPostWithCategory(Request $request)
    {

        $blogCategory = BlogCategory::query()->where('slug', $request->input('slug'))->first();
        return $BlogWithCategory = self::query()->where('blog_category_id', $blogCategory->id)
            ->where('type', $request->input('type') == 'blog' ? self::BLOG : self::VLOG)
            ->where('status', self::STATUS_ACTIVE)->paginate(18);

    }

    public function getRelatedPostWithTypeAndSlug(Request $request)
    {
        $blogCategory = BlogCategory::query()->where('slug', $request->input('slug'))->first();
        return self::query()->where('blog_category_id', $blogCategory->id)
            ->where('type', $request->input('type') == 'blog' ? self::BLOG : self::VLOG)
            ->where('status', self::STATUS_ACTIVE)->get();

    }

   public function blogPhoto()
   {
       return $this->hasMany(BlogPhoto::class,'blog_id');

   }

    public function seos()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
