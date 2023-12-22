<?php

namespace App\Http\Controllers;
use Throwable;
use App\Models\Banner;
use App\Models\BannerSize;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Manager\CommonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Manager\ImageUploadManager;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\BannerResource;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Http\Requests\StoreBannerSizeRequest;
use App\Http\Requests\UpdateBannerSizeRequest;


class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $banners     = null;
        $page_content = [
            'page_title'      => __('Banner List'),
            'module_name'     => __('Banner'),
            'sub_module_name' => __('List'),
            'module_route'    => route('banner.create'),
            'button_type'     => 'create' //create
        ];
        try {
            DB::beginTransaction();
            $columns = Schema::getColumnListing('banner_sizes');
            $filters = $request->all();
            $banners  = (new Banner())->getBanner($request);
            $bannerSizes = BannerSize::all();

            $bannerSizeOptions = [];
            foreach ($bannerSizes as $bannerSize) {
                $bannerSizeOptions[$bannerSize->id] = "{$bannerSize->banner_name} : ({$bannerSize->height} * {$bannerSize->width})";
            }
            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('BANNER_DATA_FETCH_FAILED', ['error' => $throwable]);
        }
        return view('banner.banner.index')->with(compact('banners', 
        'page_content','columns','filters','bannerSizeOptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      $page_content = [
            'page_title'      => __('Banner Create'),
            'module_name'     => __('Banner Page'),
            'sub_module_name' => __('Create'),
            'module_route'    => route('banner.index'),
            'button_type'     => 'list' //create
        ];

        // $bannerSizeOptions = BannerSize::pluck('banner_name', 'height','width','id');
        $bannerSizes = BannerSize::all();

        $bannerSizeOptions = [];
        foreach ($bannerSizes as $bannerSize) {
            $bannerSizeOptions[$bannerSize->id] = "{$bannerSize->location} : ({$bannerSize->height} * {$bannerSize->width})";
        }


        return view('banner.banner.add', compact('page_content', 'bannerSizeOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBannerRequest $request)
    {
       try {
            DB::beginTransaction();
            $banner = (new Banner())->createNewBanner($request);
            $bannerSize = BannerSize::find($request->input('banner_size_id'));
            if ($bannerSize) {
                $banner->bannerSize()->associate($bannerSize);
                $banner->save();
            }
            DB::commit();
            $message = 'New Banner added successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('NEW_BANNER_SAVE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
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
    public function show(Banner $banner)
    {
        $page_content = [
            'page_title'      => __('Banner Details'),
            'module_name'     => __('Banner'),
            'sub_module_name' => __('Details'),
            'module_route'    => route('banner.index'),
            'button_type'    => 'list' //create
        ];
        $banner->load(['user', 'activity_logs']);
        
        return view('banner.banner.show',compact('banner','page_content'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        $page_content = [
            'page_title'      => __('Banner Information Edit'),
            'module_name'     => __('Banner Edit Page'),
            'sub_module_name' => __('Edit'),
            'module_route'    => route('banner.index'),
            'button_type'     => 'list' //create
        ];
        //    $bannerSizeOptions = BannerSize::pluck('banner_name', 'id');
        $bannerSizes = BannerSize::all();

        $bannerSizeOptions = [];
        foreach ($bannerSizes as $bannerSize) {
            $bannerSizeOptions[$bannerSize->id] = "{$bannerSize->location} : ( {$bannerSize->height} * {$bannerSize->width})";
        }
        $banner->load('seos');

        return view('banner.banner.edit', compact('page_content', 'banner','bannerSizeOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateBannerRequest $request, Banner $banner)
    public function update(Request $request, Banner $banner)
    {
         try {
            DB::beginTransaction();
            $original = $banner->getOriginal();
            $updated = (new Banner())->updateBannerInfo($request,$banner);
            $changed = $updated->getChanges();
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $banner);
         
            // (new Banner())->updateBannerInfo($request, $banner);
            
            $bannerSize = BannerSize::find($request->input('banner_size_id'));
            if ($bannerSize) {
                $banner->bannerSize()->associate($bannerSize);
                $banner->save();
            }
            
            DB::commit();
            $message = 'Banner Information update successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('BANNER_INFORMATION_UPDATE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->route('banner.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner, Request $request)
    {
         try {
            DB::beginTransaction();
           
            ImageUploadManager::deletePhoto(Banner::PHOTO_UPLOAD_PATH, $banner->photo);
            $banner->seos()->delete();
            $original = $banner->getOriginal();
            $changed = null;
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $banner);
            $banner->delete();
            DB::commit();
            $message = 'Banner Information Delete successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('CATEGORY_INFORMATION_DELETE_FAILED', ['data' => $banner, 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();

    }

    //     final public function getBannerList(Request $request): JsonResponse
    // {
    //     $commonResponse = new CommonResponse();
    //     try {

    //         $searchParams = [
    //             'search'       => $request->all(),
    //             'order_by'     => 'display_order',
    //         ];
    //         $query = Banner::query();

    //         if ($request->has('type')) {
    //             $typeValue = $request->input('type') == 'Banner' ? Banner::TYPE_ACTIVE : Banner::TYPE_INACTIVE;
    //             $query->where('type', $typeValue);
    //         }

    //         if ($request->has('location')) {
    //             $query->where('location', $request->input('location'));
    //         }
            
    //         $bannerList = $query->get();
    //         $commonResponse->data = BannerResource::collection($bannerList)->response()->getData();
           
    //         $commonResponse->status_message = __('Banner Data fetched successfully');
    //     } catch (\Throwable $throwable) {
    //         Log::info('API_BANNER_LIST_FETCH_FAILED', ['data' => $request->all(), 'error' => $throwable]);
    //         $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
    //         $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
    //         $commonResponse->status         = false;
    //     }
    //     return $commonResponse->commonApiResponse();
    // }

    final public function getBannerList(Request $request): JsonResponse
{
    $commonResponse = new CommonResponse();

    try {
        $searchParams = [
            'search' => $request->all(),
            'order_by' => 'display_order',
        ];

        $query = Banner::query();

        if ($request->has('type')) {
            $types = explode(',', $request->input('type'));
            $typeValues = [];

            foreach ($types as $type) {
                if ($type === 'Banner') {
                    $typeValues[] = Banner::TYPE_BANNER;
                } elseif ($type === 'Slider') {
                    $typeValues[] = Banner::TYPE_SLIDER;
                }elseif ($type === 'Advertisement') {
                    $typeValues[] = Banner::TYPE_ADVERTISEMENT;
                }
            }

            $query->whereIn('type', $typeValues);
        }

        if ($request->has('location')) {
            $locations = explode(',', $request->input('location'));
            $query->whereIn('location', $locations);
        }

        $bannerList = $query->get();
        $formattedProductData = BannerResource::collection($bannerList)->response()->getData();
        $commonResponse->data = $formattedProductData->data;
        $commonResponse->status_message = __('Banner Data fetched successfully');
    } catch (\Throwable $throwable) {
        Log::info('API_BANNER_LIST_FETCH_FAILED', ['data' => $request->all(), 'error' => $throwable]);
        $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
        $commonResponse->status_code = CommonResponse::STATUS_CODE_FAILED;
        $commonResponse->status = false;
    }

    return $commonResponse->commonApiResponse();
}



}