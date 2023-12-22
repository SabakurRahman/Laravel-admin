<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitPriceEstimationRequest;
use Illuminate\Validation\ValidationException;
use Throwable;
use App\Models\Unit;
use App\Models\UnitPrice;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Models\EstimatePrice;
use App\Manager\CommonResponse;
use App\Models\EstimatePackage;
use App\Models\EstimateCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\StoreUnitPriceRequest;
use App\Http\Requests\UpdateUnitPriceRequest;
use App\Models\EstimationLead;
use App\Models\EstimationLeads;

class UnitPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    final public function index(Request $request)
    {
        $unitPriceLists = null;
        $page_content   = [
            'page_title'      => __('Unit Price Details'),
            'module_name'     => __('Unit Price'),
            'sub_module_name' => __('Details'),
            'module_route'    => route('unit-price.create'),
            'button_type'     => 'create' //create
        ];
        try {
            DB::beginTransaction();
            $columns         = Schema::getColumnListing('unit_prices');
            $filters         = $request->all();
            $unitPriceLists  = (new UnitPrice())->getUnitPriceList($request);
            $es_category     = EstimateCategory::whereNull('category_id')->pluck("name", "id");
            $es_sub_category = EstimateCategory::whereNotNull('category_id')->pluck("name", "id");

            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('UNIT_PRICE_DATA_FETCH_FAILED', ['error' => $throwable]);
        }
        return view('unitPrice.index')->with(compact('unitPriceLists',
            'columns', 'filters', 'page_content',
            'es_category', 'es_sub_category'));

    }

    final public function create()
    {
        $page_content = [
            'page_title'      => __('Unit Price Create'),
            'module_name'     => __('Unit Price'),
            'sub_module_name' => __('Create'),
            'module_route'    => route('unit-price.index'),
            'button_type'     => 'list' //create
        ];

        $estimate_categories     = (new EstimateCategory())->getAssoc();
        $estimate_sub_categories = (new EstimateCategory())->getAssoc('sub');
        $estimatePackages        = (new EstimatePackage())->getAllEstimate(true);
        $units                   = (new Unit())->getAssoc(true);

        return view('unitPrice.create',
            compact([
                    'page_content',
                    'estimate_categories',
                    'estimate_sub_categories',
                    'estimatePackages',
                    'units']
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     * @throws ValidationException
     */
    final public function store(StoreUnitPriceRequest $request)
    {
        $is_exists_previous_unit_price = UnitPrice::query()
            ->where('type', $request->input('type'))
            ->where('estimate_category_id', $request->input('estimate_category_id'))
            ->where('estimate_sub_category_id', $request->input('estimate_sub_category_id'))
            ->first();

        if ($is_exists_previous_unit_price) {
            throw ValidationException::withMessages(['message' => 'Unit Price Already Exists']);
        }

        try {
            DB::beginTransaction();
            $unit_price = (new UnitPrice())->createNewUnitPrice($request);
            if ($request->input('package')) {
                (new EstimatePrice())->storeEstimatePrice($request, $unit_price);
            }
            DB::commit();
            $message = 'New Unit Price added successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('NEW_UNIT_PRICE_SAVE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
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
    public function show(UnitPrice $unitPrice, Request $request)
    {
        $page_content = [
            'page_title'      => __('Unit Price Information '),
            'module_name'     => __('Unit Price Page'),
            'sub_module_name' => __('Details'),
            'module_route'    => route('unit-price.index'),
            'button_type'     => 'list' //create
        ];
        $unitPrice->load([
            'user', 
            'activity_logs', 
            'estimatePrices',
            'estimateCategory',
            'estimateSubCategory'
        ]);
        $estimatePackages = EstimatePackage::all();
        // $es_category      = EstimateCategory::all();

        $es_category      = EstimateCategory::whereNull('category_id')->pluck("name", "id");
        $es_sub_category  = EstimateCategory::whereNotNull('category_id')->pluck("name", "id");
        $es_unit          = Unit::query()->pluck("name", "id");
        return view('unitPrice.show', compact('unitPrice',
        'page_content','es_category'
         ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    final public function edit(UnitPrice $unit_price)
    {
        $page_content = [
            'page_title'      => __('Edit unit price'),
            'module_name'     => __('Unit Price'),
            'sub_module_name' => __('Details'),
            'module_route'    => route('unit-price.index'),
            'button_type'     => 'list' //create
        ];

        $estimate_categories     = (new EstimateCategory())->getAssoc();
        $estimate_sub_categories = (new EstimateCategory())->getAssoc('sub');
        $estimate_packages       = (new EstimatePackage())->getAllEstimate(true);
        $units                   = (new Unit())->getAssoc(true);
        $unit_price->load('estimatePrices');
        return view('unitPrice.edit', compact('page_content', 'unit_price',
            'estimate_categories', 'estimate_sub_categories', 'units', 'estimate_packages'));
    }

    /**
     * Update the specified resource in storage.
     */
    final public function update(UpdateUnitPriceRequest $request, UnitPrice $unit_price)
    {
        try {
            DB::beginTransaction();
            $original = $unit_price->getOriginal();
            $updated  = (new UnitPrice())->updateUnitPriceInfo($request, $unit_price);
            $changed  = $updated->getChanges();
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $unit_price);

            // Update unit price data for each package
            if ($request->input('package')) {
                (new EstimatePrice())->updateEstimatePrice($request, $unit_price);
            }

            DB::commit();
            $message = 'Unit Price Information update successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('UNIT_PRICE_INFORMATION_UPDATE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        // Clear existing flash messages
        session()->forget(['message', 'class']);

        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->route('unit-price.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    final public function destroy(UnitPrice $unitPrice)
    {
        try {
            DB::beginTransaction();
            foreach ($unitPrice->estimatePrices as $estimatePrice) {
                $estimatePrice->delete();
            }
            $unitPrice->delete();
            DB::commit();
            $message = 'Unit Price Information Delete successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('UNIT_PRICE_INFORMATION_DELETE_FAILED', ['data' => $unitPrice, 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->forget(['message', 'class']);

        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();
    }

    //******

    //      Api

    // ******
    public function PostUnitPriceDataForSingle(StoreUnitPriceRequest $request)
    {
        $commonResponse = new CommonResponse();

        try {
            DB::beginTransaction();

            $estimateCategoryId    = $request->input('estimate_category_id');
            $estimateSubCategoryId = $request->input('estimate_sub_category_id');
            $type                  = $request->input('type');
            $quantity              = $request->input('quantity');

            $unitPrice = UnitPrice::where([
                'estimate_category_id'     => $estimateCategoryId,
                'estimate_sub_category_id' => $estimateSubCategoryId,
                'type'                     => $type,
            ])->first();

            if (!$unitPrice) {
                $commonResponse->status_message = 'This Combination is not exists';

            } else {
                $unitPriceId    = $unitPrice->id;
                $estimatePrices = EstimatePrice::where('unit_price_id', $unitPriceId)->get();

                $responseData = [
                    'name'     => (int)$quantity . ' X ' . $unitPrice->estimateSubCategory->name,
                    'quantity' => (int)$quantity,
                ];

                foreach ($estimatePrices as $estimatePrice) {
                    $finalTotal = $estimatePrice->price * $quantity;

                    $responseData[$estimatePrice->package->name] = [
                        'unit'      => $estimatePrice->min_size,
                        'unit_name' => $estimatePrice->unit->short_name,
                        'total'     => $finalTotal,
                    ];
                }

                $commonResponse->data           = $responseData;
                $commonResponse->status_message = __('Unit Price Data fetched successfully');
            }

            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::error('API_UNIT_PRICE_LIST_FETCH_FAILED', ['error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }

        return $commonResponse->commonApiResponse();
    }


    /**
     */
    final public function PostUnitPriceDataForMultiple(UnitPriceEstimationRequest $request): JsonResponse
    {
        $commonResponse = new CommonResponse();

        try {
            DB::beginTransaction();

            $inputData = $request->input('estimate_data');


            $responseData = [];

            $category = EstimateCategory::query()->pluck('name', 'id')->toArray();

            foreach ($inputData as $data) {
                $estimateCategoryId    = $data['estimate_category_id'];
                $estimateSubCategoryId = $data['estimate_sub_category_id'];
                $type                  = $data['type'];
                $quantity              = $data['quantity'];

                $unitPrice = UnitPrice::query()->where([
                    'estimate_category_id'     => $estimateCategoryId,
                    'estimate_sub_category_id' => $estimateSubCategoryId,
                    'type'                     => $type,
                ])->first();

                if (!$unitPrice) {
                    $statusMessage = sprintf(
                        'The price of this %s -> %s -> %s combination is not exists',
                        EstimateCategory::TYPES_LIST[$type] ?? null,
                        $category[$estimateCategoryId] ?? null,
                        $category[$estimateSubCategoryId] ?? null

                    );

                    $responseData[] = [
                        'status_message' => $statusMessage,
                    ];

                } else {
                    $unitPriceId    = $unitPrice->id;
                    $estimatePrices = EstimatePrice::query()->where('unit_price_id', $unitPriceId)->get();

                    $resultData = [
                        'name'     => (int)$quantity . ' X ' . $unitPrice->estimateSubCategory?->name,
                        'quantity' => (int)$quantity,
                    ];

                    foreach ($estimatePrices as $estimatePrice) {
                        $finalTotal = $estimatePrice->price * $quantity;

                        $resultData[$estimatePrice->package->name] = [
                            'unit'      => $estimatePrice->min_size,
                            'unit_name' => $estimatePrice?->unit?->short_name,
                            'total'     => $finalTotal,
                        ];
                    }

                    $responseData[] = $resultData;
                }
            }
            (new EstimationLead())->storeEstimationLead($request, $responseData);

            $commonResponse->data           = $responseData;
            $commonResponse->status_message = __('Unit Price Data fetched successfully');

            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::error('API_UNIT_PRICE_LIST_FETCH_FAILED', ['error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }

        return $commonResponse->commonApiResponse();
    }


    public function PostEstimationLeads(Request $request)
    {
        $commonResponse = new CommonResponse();

        try {
            DB::beginTransaction();

            $inputData = $request->all();
            // Debugging: Log the input data to ensure it's correct.
            // Log::info('Input Data:', ['data' => $inputData]);

            $responseData = [];

            foreach ($inputData as $leadData) {
                $leadInfo = [
                    'name'  => $leadData['name'],
                    'email' => $leadData['email'],
                    'phone' => $leadData['phone'],
                ];

                $estimateData = [];

                foreach ($leadData['estimate'] as $estimate) {
                    $estimateCategoryId    = $estimate['estimate_category_id'];
                    $estimateSubCategoryId = $estimate['estimate_sub_category_id'];
                    $type                  = $estimate['type'];
                    $quantity              = $estimate['quantity'];

                    $unitPrice = UnitPrice::where([
                        'estimate_category_id'     => $estimateCategoryId,
                        'estimate_sub_category_id' => $estimateSubCategoryId,
                        'type'                     => $type,
                    ])->first();

                    if (!$unitPrice) {
                        $statusMessage = sprintf(
                            'The combination of estimate category id:%s, estimate sub-category id:%s, and type:%s is not exists',
                            $estimateCategoryId,
                            $estimateSubCategoryId,
                            $type
                        );

                        $estimateData[] = [
                            'status_message' => $statusMessage,
                        ];
                    } else {
                        $unitPriceId    = $unitPrice->id;
                        $estimatePrices = EstimatePrice::where('unit_price_id', $unitPriceId)->get();

                        $resultData = [
                            'name'     => (int)$quantity . ' X ' . $unitPrice->estimateSubCategory->name,
                            'quantity' => (int)$quantity,
                        ];

                        foreach ($estimatePrices as $estimatePrice) {
                            $finalTotal = $estimatePrice->price * $quantity;

                            $resultData[$estimatePrice->package->name] = [
                                'unit'      => $estimatePrice->min_size,
                                'unit_name' => $estimatePrice->unit->short_name,
                                'total'     => $finalTotal,
                            ];
                        }

                        $estimateData[] = $resultData;
                    }
                }

                $leadInfo['estimate'] = $estimateData;
                $responseData[]       = $leadInfo;
            }

            // // Debugging: Log the response data before saving to the database.
            // Log::info('Response Data:', ['data' => $responseData]);

            foreach ($responseData as $leadInfo) {
                $estimationLead = new EstimationLead();

                $estimationLead->name  = $leadInfo['name'];
                $estimationLead->email = $leadInfo['email'];
                $estimationLead->phone = $leadInfo['phone'];
                $estimationLead->data  = json_encode($leadInfo['estimate']);

                $estimationLead->save();
            }

            DB::commit();
            $commonResponse->status         = true;
            $commonResponse->status_message = 'Estimation Leads Data saved successfully';
            $commonResponse->data           = $responseData;
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_SUCCESS;
            $commonResponse->status_class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::error('API_ESTIMATION_LEADS_SAVE_FAILED', ['error' => $throwable]);
            $commonResponse->status         = false;
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status_class   = 'error';
        }

        return $commonResponse->commonApiResponse();
    }
}


