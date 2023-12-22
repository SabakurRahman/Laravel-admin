<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Throwable;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Manager\CommonResponse;
use App\Models\EstimateCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Manager\ImageUploadManager;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Http\Resources\EstimateCategoryResource;
use App\Http\Requests\StoreEstimateCategoryRequest;
use App\Http\Resources\EstimateSubCategoryResource;
use App\Http\Requests\UpdateEstimateCategoryRequest;

class EstimateCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $estimateCategory;

    public function __construct()
    {
        $this->estimateCategory = new EstimateCategory();
    }

    public function index(Request $request)
    {
        $estimateCategoryLists = null;
        $page_content          = [
            'page_title'      => __('Estimate Category Create'),
            'module_name'     => __('Estimate Category'),
            'sub_module_name' => __('List'),
            'module_route'    => route('estimate-category.create'),
            'button_type'     => 'create' //create
        ];
        try {
            DB::beginTransaction();
            $columns               = Schema::getColumnListing('estimate_categories');
            $filters               = $request->all();
            $estimateCategoryLists = (new EstimateCategory())->getEstimateCategoryList($request);
            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('ESTIMATE_CATEGORY_DATA_FETCH_FAILED', ['error' => $throwable]);
        }
        return view('estimate_category.index')->with(compact('estimateCategoryLists',
            'page_content', 'columns', 'filters'));

    }

    /**
     * Show the form for creating a new resource.
     */
    final public function create()
    {
        $page_content = [
            'page_title'      => __('Estimate Category Create'),
            'module_name'     => __('Estimate Category'),
            'sub_module_name' => __('Create'),
            'module_route'    => route('estimate-category.index'),
            'button_type'     => 'list' //create
        ];


        $estimateCategory = new EstimateCategory();
        $parentCategory   = EstimateCategory::whereNull('category_id')->pluck("name", "id");
        return view('estimate_category.add', compact('page_content',
            'estimateCategory', 'parentCategory'));
    }


    /**
     * Store a newly created resource in storage.
     */
    final public function store(StoreEstimateCategoryRequest $request)
    {

        try {
            DB::beginTransaction();
            (new EstimateCategory())->createNewEstimateCategory($request);
            DB::commit();
            $message = 'New Estimate Category added successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('NEW_ESTIMATE_CATEGORY_SAVE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
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
    public function show(EstimateCategory $EstimateCategory)
    {
        $page_content = [
            'page_title'      => __('Estimate Category  Details'),
            'module_name'     => __('Estimete Category '),
            'sub_module_name' => __('Details'),
            'module_route'    => route('estimate-category.index'),
            'button_type'     => 'list' //create
        ];
        $EstimateCategory->load(['user', 'activity_logs']);
        return view('estimate_category.show', compact('EstimateCategory', 'page_content'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    final  public function edit(EstimateCategory $EstimateCategory)
    {
        $page_content   = [
            'page_title'      => __('Estimate Category Edit'),
            'module_name'     => __('Estimate Category'),
            'sub_module_name' => __('Edit'),
            'module_route'    => route('estimate-category.index'),
            'button_type'     => 'list' //create
        ];
        $parentCategory = EstimateCategory::query()->pluck("name", "id");
        $EstimateCategory->load('seos');
        return view('estimate_category.edit', compact('page_content', 'EstimateCategory', 'parentCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    final public function update(UpdateEstimateCategoryRequest $request, EstimateCategory $EstimateCategory)
    {
        try {
            DB::beginTransaction();
            $original = $EstimateCategory->getOriginal();
            $updated  = (new EstimateCategory())->updateEstimateCategoryInfo($request, $EstimateCategory);
            $changed  = $updated->getChanges();
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $EstimateCategory);

            DB::commit();
            $message = 'Estimate Category Update successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('ESTIMATE_CATEGORY__UPDATE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Estimate Category Update Failed';
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->route('estimate-category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    final public function destroy(Request $request, EstimateCategory $EstimateCategory)
    {
        try {
            DB::beginTransaction();
            if ($EstimateCategory->category_id === null) {
                $subcategories = EstimateCategory::where('category_id', $EstimateCategory->id)->get();

                foreach ($subcategories as $subcategory) {
                    ImageUploadManager::deletePhoto(EstimateCategory::PHOTO_UPLOAD_PATH, $subcategory->photo);
                    ImageUploadManager::deletePhoto(EstimateCategory::BANNER_UPLOAD_PATH, $subcategory->banner);
                    $subcategory->seos()->delete();
                    $subcategory->activity_logs()->delete();
                    $subcategory->delete();
                }
            }

            // Delete the parent category's photos, SEO data, and logs
            ImageUploadManager::deletePhoto(EstimateCategory::PHOTO_UPLOAD_PATH, $EstimateCategory->photo);
            ImageUploadManager::deletePhoto(EstimateCategory::BANNER_UPLOAD_PATH, $EstimateCategory->banner);
            $EstimateCategory->seos()->delete();
            $original = $EstimateCategory->getOriginal();
            $changed  = null;
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $EstimateCategory);
            $EstimateCategory->delete();

            DB::commit();
            $message = 'Estimeate Category Information Delete successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();

            Log::info('ESTIMATE_CATEGORY_INFORMATION_DELETE_FAILED', ['data' => $EstimateCategory, 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();

    }

    final public function getAllSubCategory(Request $request)
    {

        $data         = null;
        $page_content = [
            'page_title'      => __('Sub Category List'),
            'module_name'     => __('Estimate Sub Category'),
            'sub_module_name' => __('Sub Category List'),
            'module_route'    => route('estimate-category.create'),
            'button_type'     => 'create' //create
        ];
        try {
            DB::beginTransaction();
            $columns = Schema::getColumnListing('estimate_categories');
            $filters = $request->all();
            $data    = (new EstimateCategory())->getEstimateSubCategoryList($request);
            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('ESTIMATE_SUB_CATEGORY_DATA_FETCH_FAILED', ['error' => $throwable]);
        }
        return view('estimate_category.estimateSubCategoryList', compact('data'
            , 'page_content', 'columns', 'filters'));

    }


    // final public function getAllSubCategoryByTypeAndCategory(Request $request)
    // {

    //     $commonResponse = new CommonResponse();
    //     try {
    //         $searchParams = [
    //             'search'       => $request->all(),
    //             'order_by'     => 'display_order',
    //         ];
    //         $types = EstimateCategory::TYPES_LIST;

    //         $responseData = [];

    //         foreach ($types as $typeId => $typeName) {
    //             $categoriesForType = EstimateCategory::where('type', $typeId)->get();

    //             $categoryData = [];

    //             foreach ($categoriesForType as $category) {
    //                 $parentCategory = $category->parentCategory()->whereNull('category_id')->first();
    //                 if ($parentCategory) {
    //                     $subCategoryIncluded = isset($categoryData[$parentCategory->name]);

    //                     if (!$subCategoryIncluded) {
    //                         $categoryInfo = [
    //                             'type_id'   => $category->type,
    //                             $parentCategory->name => new EstimateCategoryResource($parentCategory),
    //                         ];

    //                         $categoryData[$parentCategory->name] = $categoryInfo;
    //                     }
    //                 }
    //             }

    //             $responseData[$typeName] = array_values($categoryData);
    //         }

    //         $commonResponse->data = $responseData;
    //         $commonResponse->status_message = __('Type Wise All category with All Sub Category Of Estimate Category Data fetched successfully');
    //     } catch (\Throwable $throwable) {
    //         Log::info('TYPE_WISE_ALL_CATEGORY_AND_SUB_CATEGORY_OF_ESTIMATE_CATEGORY_LIST_FETCH_FAILED', ['data' => $request->all(), 'error' => $throwable]);
    //         $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
    //         $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
    //         $commonResponse->status         = false;
    //     }
    //     return $commonResponse->commonApiResponse();
    // }

    final public function getAllSubCategoryByTypeAndCategory(Request $request)
    {
        $commonResponse = new CommonResponse();

        try {
            $categories                     = EstimateCategory::query()->with('estimateSubCategory')->whereNull('category_id')->get()->groupBy(function ($data) {
                return strtolower(str_replace(' ', '_', EstimateCategory::TYPES_LIST[$data->type]));
            })->map(function ($category) {
                return ['type' => $category->first()->type, 'type_name' => EstimateCategory::TYPES_LIST[$category->first()->type], 'category' => EstimateCategoryResource::collection($category)];
            });
            $commonResponse->data           = $categories;
            $commonResponse->status_message = __('Type Wise All category with All Sub Category Of Estimate Category Data fetched successfully');
        } catch (\Throwable $throwable) {
            Log::info('TYPE_WISE_ALL_CATEGORY_AND_SUB_CATEGORY_OF_ESTIMATE_CATEGORY_LIST_FETCH_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }

        return $commonResponse->commonApiResponse();
    }


}
