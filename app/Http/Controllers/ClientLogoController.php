<?php

namespace App\Http\Controllers;
use Throwable;
use App\Models\ClientLogo;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Manager\CommonResponse;
use Illuminate\Http\JsonResponse;


use Illuminate\Support\Facades\DB;
use App\Manager\ImageUploadManager;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Http\Resources\ClientLogoResource;
use App\Http\Requests\StoreClientLogoRequest;
use App\Http\Requests\UpdateClientLogoRequest;

class ClientLogoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request->all());
        $clientLogos     = null;
        $page_content = [
            'page_title'      => __('Client Logo List'),
            'module_name'     => __('Client Logo'),
            'sub_module_name' => __('List'),
            'module_route'    => route('client-logo.create'),
            'button_type'     => 'create' //create
        ];
        try {
            DB::beginTransaction();
            $columns = Schema::getColumnListing('client_logos');
            $filters = $request->all();
            $clientLogos = (new ClientLogo())->getClientLogoList($request);
            
            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('CLIENT_LOGO_DATA_FETCH_FAILED', ['error' => $throwable]);
        }
        // dd($clientLogos);
        return view('clientLogo.index')->with(compact('clientLogos',
         'page_content','columns','filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $page_content = [
            'page_title'      => __('Client logo Create'),
            'module_name'     => __('Client logo Page'),
            'sub_module_name' => __('Create'),
            'module_route'    => route('client-logo.index'),
            'button_type'     => 'list' //create
        ];

        return view('clientLogo.add', compact('page_content'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientLogoRequest $request)
    {
        try {
            DB::beginTransaction();
            (new ClientLogo())->createNewClientLogo($request);
            DB::commit();
            $message = 'New Client Logo added successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('NEW_CLIENT_LOGO_SAVE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
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
    public function show(ClientLogo $clientLogo)
    {
        $page_content = [
            'page_title'      => __('Client Logo Details'),
            'module_name'     => __('Client Logo'),
            'sub_module_name' => __('Details'),
            'module_route'    => route('client-logo.index'),
            'button_type'    => 'list' //create
        ];
        $clientLogo->load(['user', 'activity_logs']);
        return view('clientLogo.show',compact('clientLogo','page_content')); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClientLogo $clientLogo)
    {
        $page_content = [
            'page_title'      => __('Client logo Information Edit'),
            'module_name'     => __('Client logo Edit Page'),
            'sub_module_name' => __('Edit'),
            'module_route'    => route('client-logo.index'),
            'button_type'     => 'list' //create
        ];
        //    $category= Category::findOrFail($id);

        return view('clientLogo.edit', compact('page_content', 'clientLogo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientLogoRequest $request, ClientLogo $clientLogo)
    {
        
        try {
            DB::beginTransaction();
            $original = $clientLogo->getOriginal();
            $updated = (new ClientLogo())->updateClientLogoInfo($request,$clientLogo);
            $changed = $updated->getChanges();
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $clientLogo);
            
            DB::commit();
            $message = 'Client Logo Information update successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('CLIENT_LOGO_INFORMATION_UPDATE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClientLogo $clientLogo,Request $request)
    {
         try {
            DB::beginTransaction();
            ImageUploadManager::deletePhoto(ClientLogo::PHOTO_UPLOAD_PATH, $clientLogo->photo);
            $original = $clientLogo->getOriginal();
            $changed = null;
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $clientLogo);
            $clientLogo->delete();
            DB::commit();
            $message = 'Client Logo Information Delete successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('CLIENT_LOGO_INFORMATION_DELETE_FAILED', ['data' => $clientLogo, 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();
    }

    final public function getClientLogoList(Request $request): JsonResponse
    {
        $commonResponse = new CommonResponse();
        try {
            $searchParams                   = [
                'search'       => $request->all(),
                // 'is_published' => Category::IS_PUBLISHED,
                'order_by'     => 'display_order',
            ];
            $clientLogoList = ClientLogo::all();
            $formattedProductData = ClientLogoResource::collection($clientLogoList)->response()->getData();
            $commonResponse->data = $formattedProductData->data;
            // $commonResponse->data           = PaymentMethodResource::collection((new PaymentMethod())->self::all())->response()->getData();
            $commonResponse->status_message = __('Client Logo Data fetched successfully');
        } catch (\Throwable $throwable) {
            Log::info('API_CLIENT_LOGO_LIST_FETCH_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();
    }
}
