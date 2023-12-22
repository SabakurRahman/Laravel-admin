<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlogCategoryResource;
use App\Http\Resources\BlogPostCountResource;
use App\Http\Resources\BlogPostResource;
use App\Http\Resources\BlogSlugResource;
use App\Manager\CommonResponse;
use App\Manager\ImageUploadManager;
use App\Models\ActivityLog;
use App\Models\BlogCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogCategoryRequest;
use App\Http\Requests\UpdateBlogCategoryRequest;
use App\Models\BlogPost;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Throwable;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page_content = [
            'page_title'      => __('Blog Category List'),
            'module_name'     => __('Blog Category'),
            'sub_module_name' => __('List'),
            'module_route'    => route('blog-category.create'),
            'button_type'    => 'create' //create
        ];
        $columns = Schema::getColumnListing('blog_categories');
        $filters = $request->all();
        $blogCategoryList = (new BlogCategory())->allBlogCategoryList($request);
        return view('blog_category.index',compact(
            'blogCategoryList',
            'page_content',
            'filters',
            'columns'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_content = [
            'page_title'      => __('Blog Category  Create'),
            'module_name'     => __('Blog Category'),
            'sub_module_name' => __('Create'),
            'module_route'    => route('blog-category.index'),
            'button_type'    => 'list' //create
        ];

        return view('blog_category.create',compact('page_content',));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogCategoryRequest $request)
    {
        try {
            DB::beginTransaction();
            (new BlogCategory())->storeBlogCategory($request);
            DB::commit();
            $message = 'Blog Category  added successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('BLOG__CATEGORY__SAVE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->route('blog-category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogCategory $blogCategory)
    {
        $page_content = [
            'page_title'      => __('Blog Category  Details'),
            'module_name'     => __('Blog Category '),
            'sub_module_name' => __('Details'),
            'module_route'    => route('blog-category.index'),
            'button_type'    => 'list' //create
        ];
        $blogCategory->load(['user', 'activity_logs']);
        return view('blog_category.show',compact('blogCategory','page_content'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogCategory $blogCategory)
    {
        $page_content = [
            'page_title'      => __('Blog Category Edit'),
            'module_name'     => __('Blog Category'),
            'sub_module_name' => __('Edit'),
            'module_route'    => route('blog-category.index'),
            'button_type'    => 'list' //create
        ];

        $blogCategory->load('seos');

        return view('blog_category.edit', compact('page_content', 'blogCategory'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogCategoryRequest $request, BlogCategory $blogCategory)
    {
        try {
            DB::beginTransaction();
            $original = $blogCategory->getOriginal();
            $updated = (new BlogCategory())->updateBlogCategory($request,$blogCategory);
            $changed = $updated->getChanges();
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $blogCategory);
            DB::commit();
            $message = 'Blog Category update successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('BLOG_CATEGORY_UPDATE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->route('blog-category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogCategory $blogCategory, Request $request)
    {
        try {
            DB::beginTransaction();
            ImageUploadManager::deletePhoto(BlogCategory::PHOTO_UPLOAD_PATH, $blogCategory->photo);
            ImageUploadManager::deletePhoto(BlogCategory::COVER_PHOTO_UPLOAD_PATH, $blogCategory->cover_photo);
            $original = $blogCategory->getOriginal();
            $changed = null;
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $blogCategory);
            $blogCategory->delete();
            DB::commit();
            $message = 'Blog Category Information Delete successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('BLOG_POST_INFORMATION_DELETE_FAILED', ['data' => $blogCategory, 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    final public function getCategories(Request $request): JsonResponse
    {
        $commonResponse = new CommonResponse();
        try {
            $searchParams                   = [
                'search'       => $request->all(),
                // 'is_published' => Category::IS_PUBLISHED,
                'order_by'     => 'display_order',
            ];
            $commonResponse->data           = BlogCategoryResource::collection((new BlogCategory())->getBlogCategory())->response()->getData();
            $commonResponse->status_message = __('Category Data fetched successfully');
        } catch (\Throwable $throwable) {
            Log::info('API_CATEGORY_LIST_FETCH_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();
    }


    final public function  getCategoriesWithPostCount():JsonResponse
    {

        $commonResponse = new CommonResponse();
        try {
            $commonResponse->data           = BlogPostCountResource::collection((new BlogCategory())->getBlogCategoryWithCount());
            $commonResponse->status_message = __('Category Data fetched successfully');
        } catch (\Throwable $throwable) {
            Log::info('API_CATEGORY_LIST_FETCH_FAILED', ['data' => [], 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();

    }



}
