<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Seo;
use App\Models\City;
use App\Models\Zone;
use App\Models\Address;
use App\Models\Country;
use App\Models\Division;
use App\Models\ActivityLog;
use App\Models\ProjectPhoto;
use Illuminate\Http\Request;
use App\Manager\CommonResponse;
use App\Models\ProjectCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Manager\ImageUploadManager;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Http\Resources\OurProjectDetailsResource;
use App\Http\Requests\StoreProjectCategoryRequest;
use App\Http\Requests\UpdateProjectCategoryRequest;
use App\Http\Resources\ProjectCategoryListResource;

class ProjectCategoryController extends Controller
{

    protected $pro_Category;

    public function __construct()
    {
       $this->pro_Category = new ProjectCategory();
    }


    /**
     * Display a listing of the resource.
     */
    final public function index(Request $request)
    {
        $projectCategories  = null;
        $page_content = [
            'page_title'      => __('Project Category List'),
            'module_name'     => __('Project Category'),
            'sub_module_name' => __('List'),
            'module_route'    => route('project-category.create'),
            'button_type'     => 'create' //create
        ];
        try {
            DB::beginTransaction();
            $columns = Schema::getColumnListing('project_categories');
            $filters = $request->all();
            $projectCategories = (new ProjectCategory())->getProjectCategoryList($request);
            // dd($categories);
            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('PROJECT_CATEGORY_DATA_FETCH_FAILED', ['error' => $throwable]);
        }
        return view('project_category.index')->with(compact('projectCategories',
         'page_content','columns','filters'));


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $allCity     = (new City())->getallCity();
        $allZone     = (new Zone())->getAllZone();
        $allCountry  = (new Country())->getAllCountry();
        $allDivision = (new Division())->getAllDivision();

        $page_content = [
            'page_title'      => __('Project Category Create'),
            'module_name'     => __('Project Category Page'),
            'sub_module_name' => __('list'),
            'module_route'    => route('project-category.index'),
            'button_type'     => 'list' //create
        ];
        return view('project_category.add', compact('page_content','allCity','allZone','allCountry','allDivision'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectCategoryRequest $request)
    {

        try{
            DB::beginTransaction();
            $projectCategory = (new ProjectCategory())->createProjectCategory($request);
            $address = new Address();
            $addressdata = $address->prepareAddressData($request);
            $projectCategory->address()->create($addressdata);


            DB::commit();
            $message = 'Project Category added successfully';
            $class   = 'success';

        }
        catch(Throwable $throwable){
            DB::rollBack();
            Log::info('PROJECT_CATEGORY_SAVE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
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
   final  public function show(ProjectCategory $projectCategory)
    {
        $page_content = [
            'page_title'      => __('Project Categoryy  Details'),
            'module_name'     => __('Project Category '),
            'sub_module_name' => __('Details'),
            'module_route'    => route('project-category.index'),
            'button_type'    => 'list' //create
        ];
        $projectCategory->load(['user', 'activity_logs']);
        return view('project_category.show',compact('projectCategory','page_content'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    final public function edit(ProjectCategory $projectCategory)
    {
        $page_content = [
            'page_title'      => __('Project Category Edit'),
            'module_name'     => __('Project Category Edit Page'),
            'sub_module_name' => __('Edit'),
            'module_route'    => route('project-category.index'),
            'button_type'     => 'list' //create
        ];

        $projectCategory->load('seos');
        $allCity     = (new City())->getallCity();
        $allZone     = (new Zone())->getAllZone();
        $allCountry  = (new Country())->getAllCountry();
        $allDivision = (new Division())->getAllDivision();

        return view('project_category.edit', compact('page_content',
        'projectCategory','allCity','allZone','allCountry','allDivision'));

    }

    /**
     * Update the specified resource in storage.
     */
    final public function update(UpdateProjectCategoryRequest $request, ProjectCategory $projectCategory)
    {
        try{

            $original= $projectCategory->getOriginal();
            $updated = (new ProjectCategory())->updateProjectCategoryInfo($request,$projectCategory);
            $changed = $updated->getChanges();
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $projectCategory);


            DB::commit();
            $message = 'Project Category Information update successfully';
            $class   = 'success';

        }
        catch(Throwable $throwable){
            DB::rollBack();
            Log::info('PROJECT_CATEGORY_UPDATE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->route('project-category.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectCategory $projectCategory,Request $request)
    {
         try {
            DB::beginTransaction();
            ImageUploadManager::deletePhoto(ProjectCategory::PHOTO_UPLOAD_PATH, $projectCategory->photo);
            ImageUploadManager::deletePhoto(ProjectCategory::BANNER__UPLOAD_PATH_THUMB, $projectCategory->banner);
            $projectCategory->seos()->delete();
            $projectCategory->address()->delete();
            $original = $projectCategory->getOriginal();
            $changed = null;
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $projectCategory);

            $projectCategory->delete();

            DB::commit();
            $message = 'Category Information Delete successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();

            Log::info('CATEGORY_INFORMATION_DELETE_FAILED', ['data' => $projectCategory, 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();
        // try{
        // $this->pro_Category->deleteProjectCategoryById($projectCategory);
        // $message = 'Project Category deleted successfully';
        // $class   = 'success';
        // session()->flash('message', $message);
        // DB::commit();
        // }
        // catch(Throwable $throwable){
        //     Log::info('PROJECT_CATEGORY_DELETE_FAILED', ['data' => $projectCategory, 'error' => $throwable]);
        //     $message = 'Failed! ' . $throwable->getMessage();
        //     $class   = 'danger';
        //     session()->flash('message', $message);
        // }
        // session()->flash('class', $class);
        // return redirect()->back();

    }


    // api


    // final public function getOurProjectCategoryList()
    // {
    //     $commonResponse = new CommonResponse();
    //     try{
    //         $categorylist = $this->pro_Category->getProjectCategoryListapi();
    //         $list = ProjectCategoryListResource::collection($categorylist);
    //         $commonResponse->data = $list;
    //         $commonResponse->status_message = __('OurProjectsCategoryList Data fetched successfully');
    //         Log::info('API_OUR_PROJECTS_CATEGORY_LIST_FETCHED');
    //         $commonResponse->status_code    = CommonResponse::STATUS_CODE_SUCCESS;
    //         $commonResponse->status         = true;

    //     }
    //     catch(Throwable $e){
    //         $commonResponse->status_message = __('Approach Data fetched failed');
    //         Log::info('Category_FETCH_FAILED',[$e]);
    //         $commonResponse->status_message = 'Failed! ' . $e->getMessage();
    //         $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
    //         $commonResponse->status         = false;
    //     }
    //     return $commonResponse->commonApiResponse();
    // }

        final public function getOurProjectCategoryList(Request $request): JsonResponse
    {
        $commonResponse = new CommonResponse();
        try {
            $searchParams                   = [
                'search'       => $request->all(),
                'order_by'     => 'display_order',
            ];
            $projectCategory      = ProjectCategory::all();
            $formattedProductData = ProjectCategoryListResource::collection($projectCategory)->response()->getData();
            $commonResponse->data = $formattedProductData->data;

            $commonResponse->status_message = __('Project category Data fetched successfully');
        } catch (\Throwable $throwable) {
            Log::info('API_PROJECT_CATEGORY_LIST_FETCH_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();
    }






    // final public function getSingleProjectByAllCategory(Request $request): JsonResponse
    // {
    //     $commonResponse = new CommonResponse();
    //     try {
    //         $searchParams = [
    //             'search'       => $request->all(),
    //             'order_by'     => 'display_order',
    //         ];
    //         $projectCategories = ProjectCategory::all();

    //         $responseData = [];

    //         foreach ($projectCategories as $category) {
    //             $categoryData = [
    //                 $category->name => [],
    //             ];

    //             // Get the last added project under each category
    //             $lastProject = $category->projects->sortByDesc('created_at')->first();

    //             if ($lastProject) {
    //                 $categoryData[$category->name][] = [
    //                     'id'                  => $lastProject->id,
    //                     'name'                => $lastProject->name,
    //                     'description'         => $lastProject->project_description,
    //                     'type'                => $lastProject->type == 1 ? "Office Interior" : "Home Interior",
    //                     'category'            => $lastProject->project_category?->name,
    //                     'client_name'         => $lastProject->client_name,
    //                     'total_area'          => $lastProject->total_area,
    //                     'total_cost'          => $lastProject->total_cost,
    //                     'location'            => $lastProject->project_location,
    //                     'is_show_on_home_page'=> $lastProject->is_show_on_home_page == 1 ? "Yes" : "NO",
    //                     'status'              => $lastProject->status == 1 ? "Active" : "Inactive",
    //                     'tags'                => $lastProject->tags?->pluck('name'),
    //                     'photos'              => $this->formatPhotosUrls($lastProject->photos_all()->get()),
    //                     'Cover photo'         => url(ProjectPhoto::PHOTO_UPLOAD_PATH, $lastProject->primary_photo()?->first()?->photo),
    //                 ];
    //             }

    //             $responseData[] = $categoryData;
    //         }

    //         $commonResponse->data = $responseData;
    //         $commonResponse->status_message = __('Single Project By All category Data fetched successfully');
    //     } catch (\Throwable $throwable) {
    //         Log::info('API_SINGLE_PROJECT_BY_ALL_CATEGORY_LIST_FETCH_FAILED', ['data' => $request->all(), 'error' => $throwable]);
    //         $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
    //         $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
    //         $commonResponse->status         = false;
    //     }
    //     return $commonResponse->commonApiResponse();
    // }

        protected function formatPhotosUrls($photos)
    {
        return $photos->map(function ($photo) {
            return url(ProjectPhoto::PHOTO_UPLOAD_PATH, $photo->photo);
        });
    }

    final public function getSingleProjectByAllCategory(Request $request): JsonResponse
    {
        $commonResponse = new CommonResponse();
        try {
            $searchParams = [
                'search'       => $request->all(),
                'order_by'     => 'display_order',
            ];
            $projectCategories = ProjectCategory::all();

            $responseData = [];

            foreach ($projectCategories as $category) {
                $lastProject = $category->projects->sortByDesc('created_at')->first();

                if ($lastProject) {
                    $categoryData = [
                        'id'                  => $lastProject->id,
                        'name'                => $lastProject->name,
                        'slug'                => $lastProject->slug,
                        'description'         => $lastProject->project_description,
                        'type'                => $lastProject->type == 1 ? "Office Interior" : "Home Interior",
                        'category'            => $lastProject->project_category?->name,
                        'client_name'         => $lastProject->client_name,
                        'total_area'          => $lastProject->total_area,
                        'total_cost'          => $lastProject->total_cost,
                        'location'            => $lastProject->project_location,
                        'is_show_on_home_page'=> $lastProject->is_show_on_home_page == 1 ? "Yes" : "NO",
                        'status'              => $lastProject->status == 1 ? "Active" : "Inactive",
                        'tags'                => $lastProject->tags?->pluck('name'),
                        'photos'              => $this->formatPhotosUrls($lastProject->photos_all()->get()),
                        'Cover photo'         => url(ProjectPhoto::PHOTO_UPLOAD_PATH, $lastProject->primary_photo()?->first()?->photo),
                    ];

                    $responseData[$category->name] = [$categoryData];
                } else {
                    // If no project exists in the category, set an empty array
                    $responseData[$category->name] = [];
                }
            }

            $commonResponse->data = $responseData;
            $commonResponse->status_message = __('Single Project By All category Data fetched successfully');
        } catch (\Throwable $throwable) {
            Log::info('API_SINGLE_PROJECT_BY_ALL_CATEGORY_LIST_FETCH_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();
    }


    final public function getProjectWithLimitByAllCategory(Request $request): JsonResponse
    {
        $commonResponse = new CommonResponse();
        try {
            $searchParams = [
                'search'       => $request->all(),
                'order_by'     => 'display_order',
            ];
            $projectCategories = ProjectCategory::all();

            $responseData = [];

            $limit = $request->input('limit', 1); // Get the limit parameter, default to 1 if not provided

            foreach ($projectCategories as $category) {
                // Get the last N added projects under each category
                $lastProjects = $category->projects->sortByDesc('created_at')->take($limit);

                $categoryData = [];

                foreach ($lastProjects as $lastProject) {
                    $categoryData[] = [
                        'id'                  => $lastProject->id,
                        'name'                => $lastProject->name,
                        'description'         => $lastProject->project_description,
                        'type'                => $lastProject->type == 1 ? "Office Interior" : "Home Interior",
                        'category'            => $lastProject->project_category?->name,
                        'client_name'         => $lastProject->client_name,
                        'total_area'          => $lastProject->total_area,
                        'total_cost'          => $lastProject->total_cost,
                        'location'            => $lastProject->project_location,
                        'is_show_on_home_page'=> $lastProject->is_show_on_home_page == 1 ? "Yes" : "NO",
                        'status'              => $lastProject->status == 1 ? "Active" : "Inactive",
                        'tags'                => $lastProject->tags?->pluck('name'),
                        'photos'              => $this->formatPhotosUrls($lastProject->photos_all()->get()),
                        'cover_photo'         => url(ProjectPhoto::PHOTO_UPLOAD_PATH, $lastProject->primary_photo()?->first()?->photo),
                    ];
                }

                $responseData[$category->name] = $categoryData;
            }

            $commonResponse->data = $responseData;
            $commonResponse->status_message = __('Project By All category  With Limit Data fetched successfully');
        } catch (\Throwable $throwable) {
            Log::info('API_PROJECT_BY_ALL_CATEGORY_WITH_LIMIT_LIST_FETCH_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();
    }

}












