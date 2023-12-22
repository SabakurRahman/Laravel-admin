<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlogCommentResource;
use App\Http\Resources\BlogPostCountResource;
use App\Manager\CommonResponse;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogCommentRequest;
use App\Http\Requests\UpdateBlogCommentRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class BlogCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page_content = [
            'page_title'      => __('Blog Comment  Create'),
            'module_name'     => __('Blog Comment'),
            'sub_module_name' => __('List'),
            'module_route'    => route('blog-comment.create'),
            'button_type'    => 'create' //create
        ];
        $blogCommentList = (new BlogComment())->allBlogCommentList();
        return view('blog_comment.index',compact('blogCommentList','page_content'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $page_content = [
            'page_title'      => __('Blog Comment  Create'),
            'module_name'     => __('Blog Comment'),
            'sub_module_name' => __('Create'),
            'module_route'    => route('blog-comment.index'),
            'button_type'    => 'list' //create
        ];

        return view('blog_comment.create',compact('page_content',));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogCommentRequest $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(BlogComment $blogComment)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogComment $blogComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogCommentRequest $request, BlogComment $blogComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogComment $blogComment)
    {
        //
        try {
            DB::beginTransaction();
            $blogComment->delete();
            DB::commit();
            $message = 'Blog Category Information Delete successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('BLOG_POST_INFORMATION_DELETE_FAILED', ['data' => $blogComment, 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();
    }


    public function changeStatus($id, $status)
    {
        (new BlogComment())->blogStatusChang($id,$status);
        return redirect()->back()->with('success', 'Blog post status updated successfully.');
    }


    final public function postBlogComment(Request $request,$blog_id): JsonResponse
    {
        $commonResponse = new CommonResponse();
        $parent_comment_id = $request->input('blog_comment_id',null);
        $validationRules = [
            'comment' => 'required|string'
        ];
        try {
            $validatedData = $request->validate($validationRules);
            $commonResponse->data           =  (new BlogComment())->storeBlogComment($validatedData,$blog_id,$parent_comment_id);
            $commonResponse->status_message = __('Comment Post successfully');
        } catch (\Throwable $throwable) {
            Log::info('COMMENTS_POST_FAILED', ['data' =>$request->all(), 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();
    }

    final public function getBlogComments($blog_id):JsonResponse
    {
        $commonResponse = new CommonResponse();
        try {
            $commonResponse->data           =  BlogCommentResource::collection((new BlogComment())->getBlogComment($blog_id));
            $commonResponse->status_message = __('Blog Comment Get Successfully');
        } catch (\Throwable $throwable) {
            Log::info('COMMENTS_GET_FAILED', ['data' =>$blog_id, 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();

    }
}
