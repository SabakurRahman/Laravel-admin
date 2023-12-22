<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Tag;
use App\Models\ActivityLog;
use App\Models\OurProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreTagRequest;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\UpdateTagRequest;

class TagController extends Controller
{

    protected $tag;

    public function __construct()
    {
       $this->tag = new Tag();
    }
    /**
     * Display a listing of the resource.
     */
    final public function index(Request $request)
    {
        $tags =null;
        $page_content=[
            'page_title'      => __('Tag List'),
            'module_name'     => __('Tag'),
            'sub_module_name' => __('List'),
            'module_route'    => route('tag.create'),
            'button_type'     => 'create' //create
        ];

        try {
            DB::beginTransaction();
            $columns = Schema::getColumnListing('tags');
            $filters = $request->all();
            $tags    = (new Tag())->getTagList($request);
            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('TAG_DATE_FETCH_FAILED', ['error' => $throwable]);
        }
        return view('tag.index')->with(compact('tags',
             'page_content','columns','filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    final public function create(Request $request)
    {
        $page_content = [
            'page_title'      => __('Tag Create'),
            'module_name'     => __('Tag'),
            'sub_module_name' => __('Create'),
            'module_route'    => route('tag.index'),
            'button_type'     => 'list' //create
        ];
        $our_projects = new OurProject();
        $all_our_projects =$our_projects->getOurProjectsList($request);
        return view('tag.add', compact('page_content','all_our_projects'));

    }

    /**
     * Store a newly created resource in storage.
     */
    final public function store(StoreTagRequest $request)
    {
        try {
            DB::beginTransaction();
            $tag=$this->tag->createTag($this->tag->prepareTagData($request->all()));
            $tag->our_project()->attach($request->our_project_id);
            DB::commit();
            $message = 'New Tag added successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('NEW_Tag_SAVE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        $page_content = [
            'page_title'      => __('Tag Details'),
            'module_name'     => __('Tag '),
            'sub_module_name' => __('Details'),
            'module_route'    => route('tag.index'),
            'button_type'    => 'list' //create
        ];
        return view('tag.show', compact('page_content','tag'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    final public function edit(Tag $tag,Request $request)
    {
        $page_content = [
                'page_title'      => __('Tag Edit'),
                'module_name'     => __('Tag'),
                'sub_module_name' => __('Edit'),
                'module_route'    => route('tag.index'),
                'button_type'    => 'list' //create
        ]; 
        $our_projects = new OurProject();
        $all_our_projects =$our_projects->getOurProjectsList($request);
        return view('tag.edit', compact('page_content','tag','all_our_projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    final public function update(UpdateTagRequest $request, Tag $tag)
    {

        try {
            DB::beginTransaction();
            $original = $tag->getOriginal();
            $updated=$tag->updateTag($tag,$this->tag->prepareTagData($request->all(),$tag));
            $changed = $updated->getChanges();
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $tag);
            
            DB::commit();
            $message = 'Tag Information update successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('TAG_INFORMATION_UPDATE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->route('tag.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    final public function destroy(Request $request,Tag $tag)
    {
        try {
            DB::beginTransaction();
            $original = $tag->getOriginal();
            $changed = null;
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $tag);
            
            $tag->delete();
            DB::commit();
            $message = 'Tag Information Delete successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('TAG_INFORMATION_DELETE_FAILED', ['data' => $tag, 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();

    }
}
