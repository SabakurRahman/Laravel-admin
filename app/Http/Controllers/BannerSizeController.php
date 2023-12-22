<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\BannerSize;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Manager\ImageUploadManager;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\StoreBannerSizeRequest;
use App\Http\Requests\UpdateBannerSizeRequest;

class BannerSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $bannerSizes =null;
        $page_content=[
            'page_title'      => __('Banner Size List'),
            'module_name'     => __('Banner Size'),
            'sub_module_name' => __('List'),
            'module_route'    => route('banner-size.create'),
            'button_type'     => 'create' //create
        ];

        try {
                DB::beginTransaction();
                $columns = Schema::getColumnListing('banner_sizes');
                $filters = $request->all();
                $bannerSizes = (new BannerSize())->getBannerSizeList($request);
                DB::commit();
            } catch (Throwable $throwable) {
                DB::rollBack();
                Log::info('BANNER_SIZE_DATE_FETCH_FAILED', ['error' => $throwable]);
            }
            return view('banner.bannerSize.index')->with(compact('bannerSizes',
             'page_content','columns','filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_content = [
            'page_title'      => __('Banner Size Page Create'),
            'module_name'     => __('Banner Size Page '),
            'sub_module_name' => __('Create'),
            'module_route'    => route('banner-size.index'),
            'button_type'     => 'list' //create
        ];

        return view('banner.bannerSize.add', compact('page_content'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBannerSizeRequest $request)
    {
        try {
            DB::beginTransaction();
            (new BannerSize())->createNewBannerSizeInfo($request);
            DB::commit();
            $message = 'New Banner Size Information added successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('BANNER_SIZE_INFORMATION_SAVE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
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
    public function show(BannerSize $bannerSize)
    {
        $page_content = [
            'page_title'      => __('Banner Size Details'),
            'module_name'     => __('Banner Size'),
            'sub_module_name' => __('Details'),
            'module_route'    => route('banner-size.index'),
            'button_type'    => 'list' //create
        ];
        $bannerSize->load(['user', 'activity_logs']);
        return view('banner.bannerSize.show',compact('bannerSize','page_content'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BannerSize $bannerSize)
    {
        $page_content = [
            'page_title'      => __('Banner Size Information Edit'),
            'module_name'     => __('Banner Size Information Edit Page'),
            'sub_module_name' => __('Edit'),
            'module_route'    => route('banner-size.index'),
            'button_type'     => 'list' //create
        ];

        return view('banner.bannerSize.edit', compact('page_content', 'bannerSize'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBannerSizeRequest $request, BannerSize $bannerSize)
    {
        try {
            DB::beginTransaction();
            $original = $bannerSize->getOriginal();
            $updated = (new BannerSize())->updateBannerSizeInfo($request,$bannerSize);
            $changed = $updated->getChanges();
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $bannerSize);
            // (new BannerSize())->updateBannerSizeInfo($request, $bannerSize);
            DB::commit();
            $message = 'Banner Size Information update successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('BANNER_SIZE_INFORMATION_UPDATE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->route('banner-size.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BannerSize $bannerSize , Request $request)
    {
         try {
            DB::beginTransaction();
            $original = $bannerSize->getOriginal();
            $changed = null;
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $bannerSize);
            
            $bannerSize->delete();
            DB::commit();
            $message = 'Banner Size Information Delete successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('BANNER_SIZE_INFORMATION_DELETE_FAILED', ['data' => $bannerSize, 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();
    }
}
