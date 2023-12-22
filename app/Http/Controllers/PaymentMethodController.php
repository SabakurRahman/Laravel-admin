<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;

use App\Manager\CommonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Http\Resources\PaymentMethodResource;
use App\Http\Requests\StorePaymentMethodRequest;
use App\Http\Requests\UpdatePaymentMethodRequest;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $paymentMethod = null;
        $page_content = [
            'page_title'      => __('Payment Method List'),
            'module_name'     => __('Payment Methods'),
            'sub_module_name' => __('List'),
            'module_route'    => route('payment-method.create'),
            'button_type'     => 'create' //create
        ];
        try {
            DB::beginTransaction();
            $columns = Schema::getColumnListing('payment_methods');
            $filters = $request->all();
            $paymentMethod =  (new PaymentMethod())->getPaymentMethodList($request);
            DB::commit();
        }catch (Throwable $throwable){
            DB::rollBack();
            Log::info('PAYMENT_METHOD_DATA_FETCH_FAILED', ['error' => $throwable]);
        }
        return view('paymentMethod.index')->with(compact(
            'paymentMethod',
         'page_content','columns','filters'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $page_content = [
            'page_title'      => __('Payment Method Create'),
            'module_name'     => __('Payment Method Page'),
            'sub_module_name' => __('Create'),
            'module_route'    => route('payment-method.index'),
            'button_type'    => 'list' //create
        ];

        return view('paymentMethod.add', compact('page_content'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentMethodRequest $request)
    {
        try {
            DB::beginTransaction();
            (new PaymentMethod())->createNewPaymentMethod($request);
            DB::commit();
            $message = 'New Payment Method added successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('NEW_PAYMENT_METHOD_SAVE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
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
    public function show(PaymentMethod $paymentMethod)
    {
        $page_content = [
            'page_title'      => __('Payment Method Details'),
            'module_name'     => __('Payment Method'),
            'sub_module_name' => __('Details'),
            'module_route'    => route('payment-method.index'),
            'button_type'    => 'list' //create
        ];
        $paymentMethod->load(['user', 'activity_logs']);
        return view('paymentMethod.show',compact('paymentMethod','page_content'));   
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentMethod $payment_method)
    {
       $page_content = [
            'page_title'      => __('Payment Method Information Edit'),
            'module_name'     => __('Payment Method Edit Page'),
            'sub_module_name' => __('Edit'),
            'module_route'    => route('payment-method.index'),
            'button_type'    => 'list' //create
        ]; 

        return view('paymentMethod.edit', compact('page_content','payment_method'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentMethodRequest $request, PaymentMethod $paymentMethod)
    {
        try {
            DB::beginTransaction();
            $original = $paymentMethod->getOriginal();
            $updated = (new PaymentMethod())->updatePaymentMethodInfo($request,$paymentMethod);
            $changed = $updated->getChanges();
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $paymentMethod);
            
            // (new PaymentMethod())->updatePaymentMethodInfo($request,$paymentMethod);
            DB::commit();
            $message = 'Payment Method Information update successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('PAYMENT_METHOD_INFORMATION_UPDATE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->route('payment-method.index');
    }

    /**
     * Remove the specified resource from storage.
     */

     public function destroy(PaymentMethod $payment_method, Request $request)
    {
        try {
            DB::beginTransaction();
            $original = $payment_method->getOriginal();
            $changed = null;
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $payment_method);
            
            $payment_method->delete();
            DB::commit();
            $message = 'Payment Method Information Delete successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('PAYMENT_METHOD_INFORMATION_DELETE_FAILED', ['data' => $payment_method, 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();
    
    }
        final public function getPaymentMethods(Request $request): JsonResponse
    {
        $commonResponse = new CommonResponse();
        try {
            $searchParams                   = [
                'search'       => $request->all(),
                // 'is_published' => Category::IS_PUBLISHED,
                'order_by'     => 'display_order',
            ];
            $paymentMethods = PaymentMethod::all();
            $formattedProductData = PaymentMethodResource::collection($paymentMethods)->response()->getData();
            $commonResponse->data = $formattedProductData->data;
        
            // $commonResponse->data           = PaymentMethodResource::collection((new PaymentMethod())->self::all())->response()->getData();
            $commonResponse->status_message = __('Payment Method Data fetched successfully');
        } catch (\Throwable $throwable) {
            Log::info('API_PAYMENT_METHOD_LIST_FETCH_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();
    }
}


