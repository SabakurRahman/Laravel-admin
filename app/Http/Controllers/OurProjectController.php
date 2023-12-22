<?php

namespace App\Http\Controllers;

use api;
use Throwable;
use App\Models\Tag;
use App\Manager\Utility;
use App\Models\ActivityLog;
use App\Models\OurProject;
use App\Models\ProductPhoto;
use App\Models\ProjectPhoto;
use Illuminate\Http\Request;
use App\Manager\CommonResponse;
use App\Models\ProjectCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Manager\ImageUploadManager;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\StoreOurProjectRequest;
use App\Http\Requests\UpdateOurProjectRequest;
use App\Http\Resources\OurProjectsListResource;
use App\Http\Resources\OurProjectDetailsResource;
// use App\Models\OurProject;

class OurProjectController extends Controller
{

    protected $ourProjects;
    public function __construct()
    {
        $this->ourProjects = new OurProject();
    }

    /**
     * Display a listing of the resource.
     */
    final public function index(Request $request)
    {
        // dd($request);
        $ourProjects =null;
        $page_content = [
                'page_title' => __('Our Projects List'),
                'module_name' => __('Our Projects Page'),
                'sub_module_name' => __('List'),
                'module_route' => route('our-project.create'),
                'button_type' => 'create' //create
        ];
        try {
            DB::beginTransaction();
            $columns = Schema::getColumnListing('our_projects');
            $filters = $request->all();
            $ourProjects = (new OurProject())->getOurProjectsList($request);
            DB::commit();

        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('OUR_PROJECT_DATA_FETCH_FAILED', ['error' => $throwable]);
        }
        return view('our_projects.index', compact('page_content',
             'ourProjects','columns','filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    final public function create()
    {
        $page_content = [
            'page_title' => __('Our Projects Create'),
            'module_name' => __('Our Projects Page'),
            'sub_module_name' => __('create'),
            'module_route' => route('our-project.index'),
            'button_type' => 'list' //create
        ];

        $tags =Tag::all();

        $all_category = ProjectCategory::where('status', ProjectCategory::STATUS_ACTIVE)->get();

        return view('our_projects.add', compact('page_content', 'all_category','tags'));

    }

    /**
     * Store a newly created resource in storage.
     */
    final public function store(StoreOurProjectRequest $request)
    {
        try {
            DB::beginTransaction();
            $ourProjects=(new OurProject())->createNewOurProject($request);

            $tags = $request->input('tags');
            $ourProjects->tags()->attach($tags);

            $id         = $ourProjects->id;
            $name       = $ourProjects->name;
            $title      = $request->input('title');
            $is_primary = $request->input('is_primary');
            $serial     = $request->input('serial');

            $projectPhoto = new ProjectPhoto();

            $photo_data = [];
            foreach ($request->file('photo') as $key => $photo) {
                $photo_data = [
                    'our_project_id' => $id,
                    'title'          => $title[$key],
                    'is_primary'     => $is_primary[$key],
                    'serial'         => $serial[$key],
                    'photo'          => $projectPhoto->storeProject_photos($photo, $name),
                ];
                $projectPhoto->store_photo($photo_data);
            }
            DB::commit();
            $message = 'New Our Project added successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('NEW_OUR_PROJECT_SAVE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
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
    final public function show(OurProject $ourProject)
    {
        
        $page_content = [
            'page_title' => __('Our Projects Show'),
            'module_name' => __('Our Projects Page'),
            'sub_module_name' => __('Show'),
            'module_route' => route('our-project.index'),
            'button_type' => 'list' //create
        ];
        $ourProject->load(['user', 'activity_logs','photos_all', 'project_category', 'tags', 'primary_photo']);

        return view('our_projects.show',compact('ourProject','page_content'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // final public function edit(int $id,OurProjects $ourProject)
    final public function edit(OurProject $ourProject)
    {
        $page_content = [
            'page_title' => __('Our Projects Edit'),
            'module_name' => __('Our Projects Page'),
            'sub_module_name' => __('Edit'),
            'module_route' => route('our-project.index'),
            'button_type' => 'list' //create
        ];
        $tags            = Tag::all();
        $all_category    = ProjectCategory::where('status', ProjectCategory::STATUS_ACTIVE)->get();
        $ourproject      = $this->ourProjects->getOurProjectsById($ourProject->id)->load('photos_all', 'project_category', 'tags', 'primary_photo');
        $ourProjectPhoto = ProjectPhoto::all();
        $selectedTags    = $ourProject->tags->pluck('id')->toArray();

        $ourproject->load('seos');

        return view('our_projects.edit', compact('page_content','tags',
        'ourProjectPhoto', 'ourproject', 'all_category','selectedTags'));

    }

    /**
     * Update the specified resource in storage.
     */

     final public function update(UpdateOurProjectRequest $request, OurProject $ourProject)
    {
        // dd($our_project);
        // dd($request->all());
        try {
            DB::beginTransaction();
            $original = $ourProject->getOriginal();
            $updated = (new OurProject())->updateOurProjectInfo($request,$ourProject);
            $changed = $updated->getChanges();
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $ourProject);
            if ($request->has('tag_id')) {
                $ourProject->tags()->sync($request->input('tag_id'));
            }
      // $ourProjectPhoto = new ProjectPhoto();
            $ourProjectPhoto = ProjectPhoto::where('project_photos.our_project_id',$ourProject->id)->first();

            if ($request->has('photos')) {
                $ourProjectPhoto = ProductPhoto::where('our_project_id', $ourProject->id)->get();

                foreach ($ourProjectPhoto as $projectPhoto){
                    $productOurProjectPhotoData = [
                        'title'    => $projectPhoto->title,
                        'serial'   => $projectPhoto->serial,
                        'is_primary'=> $projectPhoto->is_primary,
                        'photo'    => $projectPhoto->photo,
                    ];
                    $projectPhoto->update($productOurProjectPhotoData);
                }

                foreach ($ourProjectPhoto as $projectPhoto) {
                    ImageUploadManager::deletePhoto('uploads/our_project/', $projectPhoto->photo);
                    $projectPhoto->delete();
                }

                (new ProjectPhoto())->processImageUpload($request, $ourProject);
            }

            // foreach ($request->input('photo_id') as $key => $photo) {

            //     if($photo != 'null' && !is_numeric($photo) ){

            //         $photo_data = [
            //             'title' => $request->title[$key],
            //             'serial' => $request->serial[$key],
            //             'photo' => $projectPhoto->storeProject_photos($photo, $request->name ?? 'project-name'),
            //         ];

            //         $projectPhoto->store_photo($photo_data);
            //     }
            //     else if ($photo != 'null'){
            //         $photo_data = [
            //             'our_project_id' => $our_project->id,
            //             'title' => $request->title[$key],
            //             'serial' => $request->serial[$key],
            //         ];

            //         $projectPhoto->updateProjectPhoto($photo_data,$photo);
            //     }
            // }
            // $ourProject->save();
            // return json_encode($our_project);

            DB::commit();
            $message = 'Our Project Information update successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('OUR_PROJECT_INFORMATION_UPDATE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->route('our-project.index');

    }



    /**
     * Remove the specified resource from storage.
     */
    final public function destroy(int $id,Request $request, OurProject $ourproject)
    {
        try {
            DB::beginTransaction();
            $ourproject = OurProject::find($id);
            if ($ourproject !== null) {
                $ourproject->seos()->delete();
                $original = $ourproject->getOriginal();
                $changed = null;
                (new ActivityLog())->storeActivityLog($request, $original, $changed, $ourproject);
                $ourproject->delete();

                DB::commit();
                $message = 'Our Project Information Delete successfully';
                $class   = 'success';
            }else {
                $message = 'Our Project Information not found';
                $class   = 'danger';
            }
        } catch (Throwable $throwable) {
            DB::rollBack();

            Log::info('OUR_PROJECT_INFORMATION_DELETE_FAILED', ['data' => $ourproject, 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();
    }

    // api

    final public function getOurProjects(Request $request)
    {
        $commonResponse = new CommonResponse();
        try {
            $projects = $this->ourProjects->getOurProjectsbyCategory($request);
            $details = OurProjectsListResource::collection($projects);
            $commonResponse->data = $details;
            $commonResponse->status_message = __('Our Projects fetched successfully');
            Log::info('First_OUR_PROJECTS_FETCHED');
            $commonResponse->status_code = CommonResponse::STATUS_CODE_SUCCESS;
            $commonResponse->status = true;
        } catch (Throwable $e) {
            $commonResponse->status_message = __('Approach Data fetched successfully');
            Log::info('First_APPROACH_FETCH_FAILED', [$e]);
            $commonResponse->status_message = 'Failed! ' . $e->getMessage();
            $commonResponse->status_code = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status = false;
        }
        return $commonResponse->commonApiResponse();
    }



        final public function getOurProjectDetails(Request $request): JsonResponse
    {
        $commonResponse = new CommonResponse();
        try {
            $searchParams                   = [
                'search'       => $request->all(),
                'order_by'     => 'display_order',
            ];

            $ourProjects = (new OurProject())->getOurProjectsBySlug($request->slug);
            $related_project = $this->relatedProjectData($ourProjects->project_category_id,$request->slug);
            $details = !empty($ourProjects)?new OurProjectDetailsResource($ourProjects):[];
            $data = [
              'details'         => $details,
              'related_project' => $related_project
            ];
            $commonResponse->data = $data;

            $commonResponse->status_message = __('Project  Data fetched successfully');
        } catch (\Throwable $throwable) {
            Log::info('API_PROJECT_LIST_FETCH_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();
    }


    public  function relatedProjectData($id,$slug)
    {
        $projectCategories = ProjectCategory::all();

        $responseData = [];

        foreach ($projectCategories as $category) {
            $latestProjects = $category->projects()
                ->where('project_category_id',$id)
                ->where('slug','!=',$slug)
                ->take(3)
                ->get();

            $categoryData = [];

            foreach ($latestProjects as $project) {
                $categoryData[] = [
                    'id'                  => $project->id,
                    'name'                => $project->name,
                    'slug'                => $project->slug,
                    'description'         => $project->project_description,
                    'type'                => $project->type == 1 ? "Office Interior" : "Home Interior",
                    'category'            => $project->project_category?->name,
                    'client_name'         => $project->client_name,
                    'total_area'          => $project->total_area,
                    'total_cost'          => $project->total_cost,
                    'location'            => $project->project_location,
                    'is_show_on_home_page'=> $project->is_show_on_home_page == 1 ? "Yes" : "NO",
                    'status'              => $project->status == 1 ? "Active" : "Inactive",
                    'tags'                => $project->tags?->pluck('name'),
                    'photos'              => $this->formatPhotosUrls($project->photos_all()->get()),
                    'cover_photo'         => url(ProjectPhoto::PHOTO_UPLOAD_PATH, $project->primary_photo()?->first()?->photo),
                ];
            }

            $responseData[$category->name] = $categoryData;
        }
        return $responseData;
    }

    protected function formatPhotosUrls($photos)
    {
        return $photos->map(function ($photo) {
            return url(ProjectPhoto::PHOTO_UPLOAD_PATH, $photo->photo);
        });
    }

    final public function getAllOurProjectDetails(Request $request): JsonResponse
    {
        $commonResponse = new CommonResponse();
        try {
            $allProjectDetail = OurProject::all();
            $formattedProductData = OurProjectDetailsResource::collection($allProjectDetail)->response()->getData();
            $commonResponse->data = $formattedProductData->data;
            $commonResponse->status_message = __('Project Data fetched successfully');
        } catch (\Throwable $throwable) {
            Log::info('API_PROJECT_LIST_FETCH_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();
    }


}


