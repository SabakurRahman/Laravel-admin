<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\WebContent;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Manager\CommonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Http\Resources\WebContentResource;
use App\Http\Requests\StoreWebContentRequest;
use App\Http\Requests\UpdateWebContentRequest;

class WebContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $webContents =null;
        $page_content=[
            'page_title'      => __('Web Content List'),
            'module_name'     => __('Web Content'),
            'sub_module_name' => __('List'),
            'module_route'    => route('web-content.create'),
            'button_type'     => 'create' //create
        ];

        try {
                DB::beginTransaction();
                $columns = Schema::getColumnListing('web_contents');
                $filters = $request->all();
                $webContents = (new WebContent())->getWebCOntentList($request);
                DB::commit();
            } catch (Throwable $throwable) {
                DB::rollBack();
                Log::info('WEB_CONTENT_DATE_FETCH_FAILED', ['error' => $throwable]);
            }
            return view('web_content.index')->with(compact('webContents',
             'page_content','columns','filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_content = [
            'page_title'      => __('Web Content Page Create'),
            'module_name'     => __('Web Content Page '),
            'sub_module_name' => __('Create'),
            'module_route'    => route('web-content.index'),
            'button_type'     => 'list' //create
        ];

        return view('web_content.add', compact('page_content'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWebContentRequest $request)
    {
        try {
            DB::beginTransaction();
            (new WebContent())->createNewWebContentInfo($request);
            DB::commit();
            $message = 'New Web Content Information added successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('WEB_CONTENT_INFORMATION_SAVE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
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
    public function show(WebContent $webContent)
    {
        $page_content = [
            'page_title'      => __('Web Content Details'),
            'module_name'     => __('Web Content'),
            'sub_module_name' => __('Details'),
            'module_route'    => route('web-content.index'),
            'button_type'    => 'list' //create
        ];
        $webContent->load(['user', 'activity_logs']);
        return view('web_content.show',compact('webContent','page_content'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WebContent $webContent)
    {
        $page_content = [
            'page_title'      => __('Web Content Information Edit'),
            'module_name'     => __('Web Content Information Edit Page'),
            'sub_module_name' => __('Edit'),
            'module_route'    => route('web-content.index'),
            'button_type'     => 'list' //create
        ];

        return view('web_content.edit', compact('page_content', 'webContent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWebContentRequest $request, WebContent $webContent)
    {
        try {
            DB::beginTransaction();
            $original = $webContent->getOriginal();
            $updated = (new WebContent())->updateWebContentInfo($request,$webContent);
            $changed = $updated->getChanges();
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $webContent);

            DB::commit();
            $message = 'Web Content Information update successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('WEB_CONTENT_INFORMATION_UPDATE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->route('web-content.index');

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WebContent $webContent,Request $request)
    {
         try {
            DB::beginTransaction();
            $original = $webContent->getOriginal();
            $changed = null;
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $webContent);

            $webContent->delete();
            DB::commit();
            $message = 'Web Content Information Delete successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('WEB_CONTENT_INFORMATION_DELETE_FAILED', ['data' => $webContent, 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();
    }



    // API

            final public function getWebContent(Request $request): JsonResponse
    {
        $commonResponse = new CommonResponse();
        try {
            $searchParams                   = [
                'search'       => $request->all(),
                // 'is_published' => Category::IS_PUBLISHED,
                'order_by'     => 'display_order',
            ];

            $query = WebContent::query();

            if ($request->has('location')) {
                $locations = explode(',', $request->input('location'));
                $locationValues = [];

                foreach ($locations as $location) {
                    if ($location === 'Homepage') {
                        $locationValues[] = WebContent::LOCATION_HOMEPAGE;
                    } elseif ($location === 'Product') {
                        $locationValues[] = WebContent::LOCATION_PRODUCT;
                    }
                }

                $query->whereIn('location', $locationValues);
            }
            $webContentList       = $query->get();
            $formattedProductData = WebContentResource::collection($webContentList)->response()->getData();
            $commonResponse->data = $formattedProductData->data;
            // $commonResponse->data           = PaymentMethodResource::collection((new PaymentMethod())->self::all())->response()->getData();
            $commonResponse->status_message = __('Web Content Data fetched successfully');
        } catch (\Throwable $throwable) {
            Log::info('API_WEB_CONTENT_LIST_FETCH_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();
    }
}
