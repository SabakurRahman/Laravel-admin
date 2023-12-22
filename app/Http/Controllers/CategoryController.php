<?php

namespace App\Http\Controllers;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Throwable;
use App\Models\Category;
use App\Models\ActivityLog;
use App\Models\ProductPhoto;

use Illuminate\Http\Request;
use App\Manager\CommonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Manager\ImageUploadManager;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryListResource;
use App\Http\Resources\SubCategoryListResource;
use App\Http\Resources\ProductDetailsForCategorySlugResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories     = null;
        $page_content = [
            'page_title'      => __('Category List'),
            'module_name'     => __('Category'),
            'sub_module_name' => __('List'),
            'module_route'    => route('category.create'),
            'button_type'     => 'create' //create
        ];
        try {
            DB::beginTransaction();
            $columns = Schema::getColumnListing('categories');
            $filters = $request->all();
            $categories = (new Category())->getCategoryList($request);
            // dd($categories);
            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('CATEGORY_DATA_FETCH_FAILED', ['error' => $throwable]);
        }
        return view('admin.modules.category.index')->with(compact('categories',
         'page_content','columns','filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_content = [
            'page_title'      => __('Category Create'),
            'module_name'     => __('Category Page'),
            'sub_module_name' => __('Create'),
            'module_route'    => route('category.index'),
            'button_type'     => 'list' //create
        ];
        $category         = new Category();
        // $parentCategory   = Category::query()->pluck("name","id");
        $parentCategory   = Category::all();
        return view('admin.modules.category.add', compact('page_content',
        'category','parentCategory'));
    }

    /**
     * Store a newly created resource in storage.
     */

    final public function store(StoreCategoryRequest $request)
    {

        try {
            DB::beginTransaction();
            (new Category())->createNewCategory($request);
            DB::commit();
            $message = 'New Category added successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('NEW_CATEGORY_SAVE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
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
    public function show(Category $category)
    {
        $page_content = [
            'page_title'      => __('Category  Details'),
            'module_name'     => __('Category '),
            'sub_module_name' => __('Details'),
            'module_route'    => route('category.index'),
            'button_type'    => 'list' //create
        ];
        $category->load(['user', 'activity_logs']);
        return view('admin.modules.category.show',compact('category','page_content'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        // dd($category);
        $page_content = [
            'page_title'      => __('Category Information Edit'),
            'module_name'     => __('Category Edit Page'),
            'sub_module_name' => __('Edit'),
            'module_route'    => route('category.index'),
            'button_type'     => 'list' //create
        ];
        // $parentCategory   = Category::query()->pluck("name","id");
        $parentCategory   = Category::all();

        $category->load('seos');
        return view('admin.modules.category.edit', compact('page_content',
         'category','parentCategory'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        // dd($request->all());

        try {
            DB::beginTransaction();
            $original = $category->getOriginal();
            $updated = (new Category())->updateCategoryInfo($request,$category);
            $changed = $updated->getChanges();
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $category);

            // (new Category())->updateCategoryInfo($request, $category);
            DB::commit();
            $message = 'Category Information update successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('CATEGORY_INFORMATION_UPDATE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->route('category.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category, Request $request)
    {
        try {
            DB::beginTransaction();
            if ($category->category_id === null) {
                $subcategories = Category::where('category_id', $category->id)->get();

                foreach ($subcategories as $subcategory) {
                    ImageUploadManager::deletePhoto(Category::PHOTO_UPLOAD_PATH, $subcategory->photo);
                    ImageUploadManager::deletePhoto(Category::BANNER_UPLOAD_PATH, $subcategory->banner);
                    $subcategory->seos()->delete();
                    $original = $category->getOriginal();
                    $changed = null;
                    (new ActivityLog())->storeActivityLog($request, $original, $changed, $subcategory);
                    $subcategory->delete();
                }
            }
            ImageUploadManager::deletePhoto(Category::PHOTO_UPLOAD_PATH, $category->photo);
            ImageUploadManager::deletePhoto(Category::BANNER_UPLOAD_PATH, $category->banner);
            $category->seos()->delete();
            $original = $category->getOriginal();
            $changed = null;
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $category);
            $category->delete();

            DB::commit();
            $message = 'Category Information Delete successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();

            Log::info('CATEGORY_INFORMATION_DELETE_FAILED', ['data' => $category, 'error' => $throwable]);
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
            $categories = Category::whereNull('category_id')->get();
            $commonResponse->data = CategoryListResource::collection($categories);
            $commonResponse->status_message = __('Category Data fetched successfully');
        } catch (\Throwable $throwable) {
            Log::info('API_CATEGORY_LIST_FETCH_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status = false;
        }
        return $commonResponse->commonApiResponse();
    }

       final public function getSubCategories(Request $request): JsonResponse
    {
        $commonResponse = new CommonResponse();
        try {
            $searchParams                   = [
                'search'       => $request->all(),
                // 'is_published' => Category::IS_PUBLISHED,
                'order_by'     => 'display_order',
            ];
            $formattedProductData = SubCategoryListResource::collection((new Category())->getCategory())->response()->getData();
            $commonResponse->data = $formattedProductData->data;
            $commonResponse->status_message = __('Sub Category Data fetched successfully');
        } catch (\Throwable $throwable) {
            Log::info('API_SUB_CATEGORY_LIST_FETCH_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();
    }

        final public function getProductWithLimitByAllCategory(Request $request): JsonResponse
    {
        $commonResponse = new CommonResponse();
        try {
            $searchParams = [
                'search'       => $request->all(),
                'order_by'     => 'display_order',
            ];
            $productCategories = Category::all();

            $responseData = [];

            $limit = $request->input('limit', 1); // default = 1

            foreach ($productCategories as $category) {
                // Get the last N added projects under each category
                $products = $category->products->take($limit);

                $categoryData = [];

                foreach ($products as $product) {
                    $categoryData[] = [
                        'photo'              => url(ProductPhoto::PHOTO_UPLOAD_PATH, $product->ProductPhotoWithoutVariation?->first()?->photo),
                        'name'                => $product->title,
                        'price'               => $product->product_price->price,
                    ];
                }

                $responseData[$category->name] = $categoryData;
            }

            $commonResponse->data = $responseData;
            $commonResponse->status_message = __('Product By All category  With Limit Data fetched successfully');
        } catch (\Throwable $throwable) {
            Log::info('API_PRODUCT_BY_ALL_CATEGORY_WITH_LIMIT_LIST_FETCH_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();
    }



     final public function getAllProductListByCategorySlug(Request $request, string $categorySlug): JsonResponse
     {
         $commonResponse = new CommonResponse();
         try {
             $category = Category::query()->with('products', function ($q){
                 $q->published()->saved();
             })->where('slug', $categorySlug)->first();

//             if (!$category) {
//                 throw new \Exception('Category not found.');
//             }

                $categoryData = $category?->products->map(function ($product) {
                 return [
                     'id' => $product->id,
                     'product_type' => $product->product_type,
                     'product_type_text' => Product::PRODUCT_TYPE_LIST[$product->product_type] ?? null,
                     'photo' => url(ProductPhoto::PHOTO_UPLOAD_PATH, $product->ProductPhotoWithoutVariation?->first()?->photo),
                     'name' => $product->title,
                     'slug' => $product->slug,
                     'price' => $product->product_price->price,
                 ];
             });

             $commonResponse->data = $categoryData->values();
             $commonResponse->status_message = __('Products for category ' . $category?->name . ' fetched successfully');
         } catch (\Throwable $throwable) {
             Log::info('API_PRODUCTS_BY_CATEGORY_SLUG_FETCH_FAILED', ['error' => $throwable]);
             $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
             $commonResponse->status_code = CommonResponse::STATUS_CODE_FAILED;
             $commonResponse->status = false;
         }
         return $commonResponse->commonApiResponse();
     }

//     final public function getAllProductListByCategorySlug(Request $request, string $slug): JsonResponse
//    {
//        $commonResponse = new CommonResponse();
//        try {
//            $categorySlug = $request->query('category');
//            $limit        = $request->query('limit', 10); // Default limit is 10 if not provided
//
//            $category     = Category::where('slug', $categorySlug)->first();
//
//            if (!$category) {
//                throw new \Exception('Category not found.');
//            }
//
//            $categoryData = $category->products()
//                ->take($limit)
//                ->get()
//                ->map(function ($product) {
//                    return [
//                        'id' => $product->id,
//                        'name' => $product->title,
//                        'slug' => $product->slug,
//                        'price' => $product->product_price->price,
//                        'product_type' => $product->product_type,
//                        'product_type_text' => $product->product_type == 1 ? 'Simple' : 'Group with variant',
//                        'photo' => url(ProductPhoto::PHOTO_UPLOAD_PATH . '/' . $product->ProductPhotoWithoutVariation?->first()?->photo),
//
//                    ];
//                });
//
//            $commonResponse->data = $categoryData->values();
//            $commonResponse->status_message = __('Products for category ' . $category->name . ' fetched successfully');
//        } catch (\Throwable $throwable) {
//            Log::info('API_PRODUCTS_BY_CATEGORY_SLUG_FETCH_FAILED', ['error' => $throwable]);
//            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
//            $commonResponse->status_code = CommonResponse::STATUS_CODE_FAILED;
//            $commonResponse->status = false;
//        }
//        return $commonResponse->commonApiResponse();
//    }





}



