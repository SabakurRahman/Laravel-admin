<?php

namespace App\Http\Controllers;

use App\Manager\ImageUploadManager;
use App\Models\ActivityLog;
use App\Models\Vendor;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVendorRequest;
use App\Http\Requests\UpdateVendorRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Throwable;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page_content = [
            'page_title'      => __('Vendor  List'),
            'module_name'     => __('Vendor'),
            'sub_module_name' => __('List'),
            'module_route'    => route('vendor.create'),
            'button_type'    => 'create' //create
        ];
        $columns = Schema::getColumnListing('vendors');
        $filters = $request->all();
        $vendorList = (new Vendor())->vendorList($request);
        return view('vendor.index',compact('vendorList','page_content','filters','columns'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_content = [
            'page_title'      => __('Vendor Create'),
            'module_name'     => __('Vendor'),
            'sub_module_name' => __('Create'),
            'module_route'    => route('vendor.index'),
            'button_type'    => 'list' //create
        ];

        return view('vendor.create',compact('page_content'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVendorRequest $request)
    {
        try {
            DB::beginTransaction();
            (new Vendor())->storeVendor($request);
            DB::commit();
            $message = ' Vendor added successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('VENDOR_SAVE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->route('vendor.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vendor $vendor)
    {
        $page_content = [
            'page_title'      => __('Vendor Details'),
            'module_name'     => __('Vendor'),
            'sub_module_name' => __('Details'),
            'module_route'    => route('vendor.index'),
            'button_type'    => 'list' //create
        ];
        return view('vendor.show',compact('vendor','page_content'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vendor $vendor)
    {
        $page_content = [
            'page_title'      => __('Vendor Edit'),
            'module_name'     => __('Vendor'),
            'sub_module_name' => __('Edit'),
            'module_route'    => route('vendor.index'),
            'button_type'    => 'list' //create
        ];

        return view('vendor.edit', compact('page_content','vendor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVendorRequest $request, Vendor $vendor)
    {
        try {
            DB::beginTransaction();
            $original =$vendor->getOriginal();
            $updated=(new Vendor())->updateVendor($request,$vendor);
            $changed=$updated->getChanges();
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $vendor);
            DB::commit();
            $message = 'Vendor update successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('VENDOR_UPDATE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->route('vendor.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vendor $vendor,Request $request)
    {
        try {
            DB::beginTransaction();
            ImageUploadManager::deletePhoto(Vendor::PHOTO_UPLOAD_PATH, $vendor->photo);
            $original = $vendor->getOriginal();
            $changed = null;
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $vendor);
            $vendor->delete();
            DB::commit();
            $message = 'Vendors Information Delete successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('VENDOR_INFORMATION_DELETE_FAILED', ['data' => $vendor, 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();
    }
}
