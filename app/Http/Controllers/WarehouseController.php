<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Warehouse;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\StoreWarehouseRequest;
use App\Http\Requests\UpdateWarehouseRequest;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       $warehouses = null;
       $page_content = [
          'page_title'      => __('Warehouse List'),
          'module_name'     => __('Warehouse'),
          'sub_module_name' => __('List'),
          'module_route'    => route('warehouses.create'),
          'button_type'     => 'create' //create
       ];
       try {
          DB::beginTransaction();
          $columns = Schema::getColumnListing('warehouses');
          $filters = $request->all();
          $warehouses = (new Warehouse())->getWarehouseList($request);
          DB::commit();
       } catch (Throwable $throwable) {
        DB::rollBack();
        Log::info('WAREHOUSE_DATA_FETCH_FAILED', ['error' => $throwable]);
       }
       return view('warehouses.index')->with(compact('warehouses', 
       'page_content','columns','filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_content = [
            'page_title'      => __('Warehouse Create'),
            'module_name'     => __('Warehouse Page'),
            'sub_module_name' => __('Create'),
            'module_route'    => route('warehouses.index'),
            'button_type'     => 'list' //create
        ];

        return view('warehouses.add', compact('page_content'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWarehouseRequest $request)
    {
      
        try {
            DB::beginTransaction();
            (new Warehouse())->createNewWarehouse($request);
            DB::commit();
            $message = 'New Warehouse added successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('NEW_WAREHOUSE_SAVE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
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
    public function show(Warehouse $warehouse)
    {
        $page_content = [
            'page_title'      => __('Warehouse Details'),
            'module_name'     => __('Warehouse'),
            'sub_module_name' => __('Details'),
            'module_route'    => route('warehouses.index'),
            'button_type'    => 'list' //create
        ];
        $warehouse->load(['user', 'activity_logs']);
        return view('warehouses.show',compact('warehouse','page_content')); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warehouse $warehouse)
    {
        $page_content = [
            'page_title'      => __('Warehouse Information Edit'),
            'module_name'     => __('Warehouse Edit Page'),
            'sub_module_name' => __('Edit'),
            'module_route'    => route('warehouses.index'),
            'button_type'     => 'list' //create
        ];;

        return view('warehouses.edit', compact('page_content', 'warehouse'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWarehouseRequest $request, Warehouse $warehouse)
    {
        // dd($request->all());
       
        try {
            DB::beginTransaction();
            $original = $warehouse->getOriginal();
            $updated = (new Warehouse())->updateWarehouseInfo($request,$warehouse);
            $changed = $updated->getChanges();
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $warehouse);
           
            DB::commit();
            $message = 'WarehouseInformation update successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('WAREHOUSE_INFORMATION_UPDATE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->route('warehouses.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warehouse $warehouse, Request $request)
    {
        try {
            DB::beginTransaction();
            $original = $warehouse->getOriginal();
            $changed = null;
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $warehouse);
            
            $warehouse->delete();
            DB::commit();
            $message = 'Warehouse Information Delete successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('WAREHOUSE_INFORMATION_DELETE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();

    }
}
