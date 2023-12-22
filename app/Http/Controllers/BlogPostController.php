<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlogCategoryResource;
use App\Http\Resources\BlogPostCountResource;
use App\Http\Resources\BlogPostResource;
use App\Http\Resources\BlogSlugResource;
use App\Http\Resources\FeaturedResource;
use App\Manager\CommonResponse;
use App\Manager\ImageUploadManager;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\BlogPost;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogPostRequest;
use App\Http\Requests\UpdateBlogPostRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Throwable;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $blogPost;

    protected $commonResponse;

    public function __construct(BlogPost $blogPost, CommonResponse $commonResponse)
    {
        $this->blogPost       = BlogPost::class;
        $this->commonResponse = $commonResponse;
    }


    public function index(Request $request)
    {
        $page_content = [
            'page_title'      => __('Blog Post List'),
            'module_name'     => __('Blog Post'),
            'sub_module_name' => __('List'),
            'module_route'    => route('blog-post.create'),
            'button_type'     => 'create' //create
        ];

        $blogPostList = (new BlogPost())->allBlogPostList($request);
       // dd($blogPostList);
        $columns      = Schema::getColumnListing('blog_posts');
        $filters      = $request->all();
        $categories = (new BlogCategory())->getBlogCategoryAssoc();
        return view('blog.index', compact(
            'blogPostList',
            'page_content',
            'columns',
            'filters',
            'categories'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_content       = [
            'page_title'      => __('Blog Post Create'),
            'module_name'     => __('Blog Post'),
            'sub_module_name' => __('Create'),
            'module_route'    => route('blog-post.index'),
            'button_type'     => 'list' //create
        ];
        $blog_category_name = (new BlogCategory())->bolgCategory();
        return view('blog.create', compact('page_content', 'blog_category_name'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogPostRequest $request)
    {

        try {
            DB::beginTransaction();
            (new BlogPost())->storeBlogPost($request);
            DB::commit();
            $message = 'Blog Post  added successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('BLOG__POST__SAVE_FAILED', ['error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->route('blog-post.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogPost $blogPost)
    {
        $page_content = [
            'page_title'      => __('Blog Post  Details'),
            'module_name'     => __('Blog Post '),
            'sub_module_name' => __('Details'),
            'module_route'    => route('blog-post.index'),
            'button_type'     => 'list' //create
        ];

        $blogPost->load(['blog_category', 'blog_comments', 'blog_comments.replies']);

        return view('blog.show', compact('blogPost', 'page_content'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogPost $blogPost)
    {
        $page_content       = [
            'page_title'      => __('Blog Post Edit'),
            'module_name'     => __('Blog Post'),
            'sub_module_name' => __('Edit'),
            'module_route'    => route('blog-post.index'),
            'button_type'     => 'list' //create
        ];
        $blog_category_name = (new BlogCategory())->bolgCategory();
        $blogPost->load('seos');
        return view('blog.edit', compact('page_content', 'blogPost', 'blog_category_name'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogPostRequest $request, BlogPost $blogPost)
    {

        try {
            DB::beginTransaction();
            (new BlogPost())->updateBlogPost($request, $blogPost);
            DB::commit();
            $message = 'Blog Post update successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('BLOG_POST_UPDATE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->route('blog-post.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogPost $blogPost)
    {
        try {
            DB::beginTransaction();
            if($blogPost?->blogPhoto)
            {
                foreach ($blogPost->blogPhoto as $photo)
                {
                    ImageUploadManager::deletePhoto(BlogPost::PHOTO_UPLOAD_PATH, $photo->photo);
                    $photo->delete();
                }

            }


            $blogPost->delete();
            DB::commit();
            $message = 'Blog Post Information Delete successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('BLOG_POST_INFORMATION_DELETE_FAILED', ['data' => $blogPost, 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();

    }


    final public function getBlog(Request $request): JsonResponse
    {
        $commonResponse = new CommonResponse();
        try {
           //$commonResponse->data           = BlogPostResource::collection(());
            $commonResponse->data           = (new BlogPost())->getBlogPost($request);
            $commonResponse->status_message = __('Blog Post Data fetched successfully');
        } catch (\Throwable $throwable) {
            Log::info('API_CATEGORY_LIST_FETCH_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();

    }


    final public function getBlogforFrontend(Request $request){
        $commonResponse = new CommonResponse();
        try{
            $commonResponse->data           = (new BlogPost())->getBlogforFrontend($request);
            $commonResponse->status_message = __('Blog Post Data fetched successfully');

        }
        catch (\Throwable $throwable) {
            Log::info('BLOG_POST_FETCH_FAILED', ['data' => [], 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();
    }


    final public function getBlogBySlug(Request $request,$slug): JsonResponse
    {
        $commonResponse = new CommonResponse();
        try {
            $data                           = [
                'blog_details'    => new BlogSlugResource(((new BlogPost())->getBlogPostBySlug($request,$slug))),
                'blog_categories' => BlogPostCountResource::collection((new BlogCategory())->getBlogCategoryWithCount())->response()->getData(),
                'featured_post'   => FeaturedResource::collection((new BlogPost())->getFeaturedPost()),
                'related_post'    => FeaturedResource::collection((new BlogPost())->getRelatedPost($slug))

            ];
            $commonResponse->data           = $data;
            $commonResponse->status_message = __('Blog Post Data fetched successfully');
        } catch (\Throwable $throwable) {
            Log::info('BLOG_POST_FETCH_FAILED', ['data' => $slug, 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();
    }


    final public function getBlogWithCategory(Request $request): JsonResponse
    {
        $commonResponse = new CommonResponse();
        try {

            $commonResponse->data           = BlogPostResource::collection((new BlogPost())->getBlogPostWithCategory($request))->response()->getData();
            $commonResponse->status_message = __('Blog Post Data fetched successfully');
        } catch (\Throwable $throwable) {
            Log::info('API_CATEGORY_LIST_FETCH_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();

    }

    final public function getRelatedBlog(Request $request): JsonResponse
    {
        $commonResponse = new CommonResponse();
        try {
            $commonResponse->data           = FeaturedResource::collection((new BlogPost())->getRelatedPostWithTypeAndSlug($request));
            $commonResponse->status_message = __('Blog Post Data fetched successfully');
        } catch (\Throwable $throwable) {
            Log::info('BLOG_POST_FETCH_FAILED', ['data' => [], 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();

    }


}
