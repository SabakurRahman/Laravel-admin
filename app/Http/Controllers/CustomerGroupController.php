<?php

namespace App\Http\Controllers;

use App\Models\CustomerGroup;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerGroupRequest;
use App\Http\Requests\UpdateCustomerGroupRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Throwable;

class CustomerGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page_content = [
            'page_title'      => __('Customer Group List'),
            'module_name'     => __('Customer Group'),
            'sub_module_name' => __('List'),
            'module_route'    => route('customer-group.create'),
            'button_type'    => 'create' //create
        ];
        $customerGroupList = (new CustomerGroup())->allCustomerGroupList();
        return view('customer_group.customerGroupList',compact('customerGroupList','page_content'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_content = [
            'page_title'      => __('Customer Group Create'),
            'module_name'     => __('CustomerGroup'),
            'sub_module_name' => __('Create'),
            'module_route'    => route('customer-group.index'),
            'button_type'    => 'list' //create
        ];
        return view('customer_group.create',compact('page_content'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerGroupRequest $request)
    {
        try {
            DB::beginTransaction();
            (new CustomerGroup())->storeCustomerGroup($request);
            DB::commit();
            $message = 'Customer Group Add successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('CUSTOMER_GROUP__SAVE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->route('customer-group.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerGroup $customerGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerGroup $customerGroup)
    {
        $page_content = [
            'page_title'      => __('Customer Group Edit'),
            'module_name'     => __('Customer Group'),
            'sub_module_name' => __('Edit'),
            'module_route'    => route('customer-group.index'),
            'button_type'    => 'list' //create
        ];
        return view('customer_group.edit',compact('page_content','customerGroup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerGroupRequest $request, CustomerGroup $customerGroup)
    {
        try {
            DB::beginTransaction();
            (new CustomerGroup())->updateCustomerGroup($request,$customerGroup);
            DB::commit();
            $message = 'Customer Group update successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('CUSTOMER_UPDATE_FAILED', [$customerGroup, 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->route('customer-group.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerGroup $customerGroup)
    {
        try {
            DB::beginTransaction();
            $customerGroup->delete();
            DB::commit();
            $message = ' Customer Group Information Delete successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('CUSTOMER_GROUP_INFORMATION_DELETE_FAILED', ['data' => $customerGroup, 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();
    }
}
