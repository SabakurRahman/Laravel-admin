<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Manager\CommonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\OurApproachCategory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Http\Requests\StoreOurApproachCategoryRequest;
use App\Http\Requests\UpdateOurApproachCategoryRequest;
use App\Http\Resources\OurApproachCategorylistResource;
use App\Models\OurApproach;

class OurApproachCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $ourApproachCategory;
    public function __construct()
    {
        $this->ourApproachCategory = new OurApproachCategory();
    }

    final public function index(Request $request)
    {


            $page_content = [
                'page_title'      => __('Our Approach Category List'),
                'module_name'     => __('Our Approach Category'),
                'sub_module_name' => __('List'),
                'module_route'    => route('our-approach-category.create'),
                'button_type'    => 'create' //create
            ];
            $columns = Schema::getColumnListing('our_approach_categories');
            $filters = $request->all();
            $ourApproachCategory = $this->ourApproachCategory->getOurApproachCategoryList($request);
            return view('our_approach_category.index', compact('page_content','ourApproachCategory','columns','filters'));

    }

    /**
     * Show the form for creating a new resource.
     */
    final public function create()
    {
        try{
            $page_content = [
                'page_title'      => __('Our Approach Category Create'),
                'module_name'     => __('Our Approach Category'),
                'sub_module_name' => __('create'),
                'module_route'    => route('our-approach-category.index'),
                'button_type'    => 'list' //create
            ];
            return view('our_approach_category.create', compact('page_content'));
        }
        catch(Throwable $e){
            Log::error($e->getMessage());
            abort(500, $e->getMessage());
            return false;
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    final public function store(StoreOurApproachCategoryRequest $request)
    {
        try{
            $this->ourApproachCategory->createNewOurApproachCategory($this->ourApproachCategory->prepareOurApproachCategory($request));
            return redirect()->route('our-approach-category.index')->with('success', __('Our Approach Category Created Successfully'));
        }
        catch(Throwable $e){
            Log::error($e->getMessage());
            abort(500, $e->getMessage());
            return false;
        }
    }

    /**
     * Display the specified resource.
     */
    final public function show(OurApproachCategory $ourApproachCategory)
    {
        try {
            $page_content = [
                'page_title' => __('Our Approach Category Details'),
                'module_name' => __('Our Approach Category '),
                'sub_module_name' => __('Details'),
                'module_route' => route('our-approach-category.index'),
                'button_type' => 'list' //create
            ];

            return view('our_approach_category.show', compact('page_content', 'ourApproachCategory'));
        }
        catch(Throwable $e){
            Log::error($e->getMessage());
            abort(500, $e->getMessage());
            return false;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    final public function edit(OurApproachCategory $ourApproachCategory)
    {
        try{
            $approachCategory = $this->ourApproachCategory->getOurApproachCategoryById($ourApproachCategory->id);

            $page_content = [
                'page_title'      => __('Our Approach Category Edit'),
                'module_name'     => __('Our Approach Category '),
                'sub_module_name' => __('Edit'),
                'module_route'    => route('our-approach-category.index'),
                'button_type'    => 'list' //create
            ];
            return view('our_approach_category.Edit', compact('page_content','approachCategory'));
        }
        catch(Throwable $e){
            Log::error($e->getMessage());
            abort(500, $e->getMessage());
            return false;
        }

    }

    /**
     * Update the specified resource in storage.
     */

    final public function update(UpdateOurApproachCategoryRequest $request, OurApproachCategory $ourApproachCategory)
    {
        try{
            DB::beginTransaction();
            $original = $ourApproachCategory->getOriginal();
            $approachCategory=     $this->ourApproachCategory->getOurApproachCategoryById($ourApproachCategory->id);
            $updated= $this->ourApproachCategory->updateOurApproachCategory($this->ourApproachCategory->prepareOurApproachCategory($request),$approachCategory);
            $changed = $updated->getChanges();
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $ourApproachCategory);
            DB::commit();
            $message = 'Project Category updated successfully';
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
        return redirect()->route('our-approach-category.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    final public function destroy(OurApproachCategory $ourApproachCategory,Request $request)
    {
        try{
            $original = $ourApproachCategory->getOriginal();
            $changed = null;
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $ourApproachCategory);

            $approachCategory = $this->ourApproachCategory->getOurApproachCategoryById($ourApproachCategory->id);
            $this->ourApproachCategory->deleteOurApproachCategory($approachCategory);
            return redirect()->route('our-approach-category.index')->with('success', __('Our Approach Category Deleted Successfully'));
        }
        catch(Throwable $e){
            Log::error($e->getMessage());
            abort(500, $e->getMessage());
            return false;
        }
    }


    //getmethod
       final public function getOurApproachCategoryList(Request $request): JsonResponse
    {
        $commonResponse = new CommonResponse();
        try {
            $searchParams                   = [
                'search'       => $request->all(),
                // 'is_published' => Category::IS_PUBLISHED,
                'order_by'     => 'display_order',
            ];
            $formattedProductData= OurApproachCategorylistResource::collection((new OurApproachCategory())->all())->response()->getData();
            $commonResponse->data = $formattedProductData->data;
            
            $commonResponse->status_message = __('Our Approach Category Data fetched successfully');
        } catch (\Throwable $throwable) {
            Log::info('API_OUR_APPROACH_CATEGORY_LIST_FETCH_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();
    }

      final public function getSingleApproachByAllCategory(Request $request): JsonResponse
    {
        $commonResponse = new CommonResponse();
        try {
            $searchParams = [
                'search'       => $request->all(),
                'order_by'     => 'display_order',
            ];
            $approachCategories = OurApproachCategory::all();

            $responseData = [];

            foreach ($approachCategories as $category) {
                $lastApproach = $category->ourApproach->sortByDesc('created_at')->first();

                if ($lastApproach) {
                    $ApproachData = [
                        'id'                  => $lastApproach->id,
                        'name'                => $lastApproach->name,
                        'slug'                => $lastApproach->slug,
                        'description'         => strip_tags($lastApproach->description),
                        'serial'              => $lastApproach->serial,
                        'status'              => $lastApproach->status == 1 ? "Active" : "Inactive",
                        'banner'              =>url(OurApproach::BANNER_UPLOAD_PATH.$lastApproach->banner),
                    ];

                    $responseData[$category->name] = [$ApproachData];
                } else {
                    $responseData[$category->name] = [];
                }
            }

            $commonResponse->data = $responseData;
            $commonResponse->status_message = __('Single Approach By All category Data fetched successfully');
        } catch (\Throwable $throwable) {
            Log::info('API_SINGLE_APPROACH_BY_ALL_CATEGORY_LIST_FETCH_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();
    }










}
