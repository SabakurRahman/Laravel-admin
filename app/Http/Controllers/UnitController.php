<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Unit;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Manager\CommonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     protected $unit;

        public function __construct()
        {
            $this->unit = new Unit();
        }

    final public function index(Request $request)
    {
        $unitLists = null;
        $page_content = [
            'page_title'      => __('Unit List'),
            'module_name'     => __('Unit'),
            'sub_module_name' => __('List'),
            'module_route'    => route('unit.create'),
            'button_type'     => 'create' //create
        ];
        try {
            DB::beginTransaction();
            $columns = Schema::getColumnListing('units');
            $filters = $request->all();
            $unitLists =  (new Unit())->getUnitList( $request);
            DB::commit();
        }catch (Throwable $throwable){
            DB::rollBack();
            Log::info('UNIT_DATA_FETCH_FAILED', ['error' => $throwable]);
        }
        return view('unit.index')->with(compact('unitLists',
         'page_content','columns','filters'));
    }
    /**
     * Show the form for creating a new resource.
     */
     final public function create()
    {

        $page_content = [
            'page_title'      => __('Unit Create'),
            'module_name'     => __('Unit Page'),
            'sub_module_name' => __('Create'),
            'module_route'    => route('unit.index'),
            'button_type'    => 'list' //create
        ];
        return view('unit.add', compact('page_content'));
    }

    /**
     * Store a newly created resource in storage.
     */
    final public function store(StoreUnitRequest $request)
    {
        try {
            DB::beginTransaction();
            (new Unit())->createNewUnit($request);
            DB::commit();
            $message = 'New Unit added successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('NEW_UNIT_SAVE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
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
    public function show(Unit $unit)
    {
        $page_content = [
            'page_title'      => __('Unit Details'),
            'module_name'     => __('Unit'),
            'sub_module_name' => __('Details'),
            'module_route'    => route('unit.index'),
            'button_type'    => 'list' //create
        ];
        $unit->load(['user', 'activity_logs']);
        return view('unit.show',compact('unit','page_content'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    final public function edit(Unit $unit)
    {
        $page_content = [
            'page_title'      => __('Unit Edit'),
            'module_name'     => __('Unit Edit Page'),
            'sub_module_name' => __('Edit'),
            'module_route'    => route('unit.index'),
            'button_type'    => 'list' //create
        ]; 
        return view('unit.edit', compact('page_content','unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    final public function update(UpdateUnitRequest $request, Unit $unit)
    {
        try {
            DB::beginTransaction();
            // $socialMedia= SocialMedia::findOrFail($request->id);
            $original = $unit->getOriginal();
            $updated = (new Unit())->updateUnitInfo($request,$unit);
            $changed = $updated->getChanges();
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $unit);
            
            DB::commit();
            $message = 'Unit Information update successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('UNIT_INFORMATION_UPDATE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->route('unit.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    final public function destroy(Unit $unit)
    {
        try{
            DB::beginTransaction();
            $unit = $this->unit->deleteUnitData($unit);
            DB::commit();
        }
        catch(Throwable $e){
            DB::rollBack();
            Log::error($e->getMessage());
        }
        return redirect()->route('unit.index');
    }
}
