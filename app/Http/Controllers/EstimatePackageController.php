<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Models\EstimatePackage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\StoreEstimatePackageRequest;
use App\Http\Requests\UpdateEstimatePackageRequest;

class EstimatePackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $estimatePackage;

    public function __construct()
    {
        $this->estimatePackage = new EstimatePackage();
    }


    final public function index(Request $request)
    {
        $estimatePackages = null;
        $page_content = [
            'page_title'      => __('Estimate Package Create'),
            'module_name'     => __('Estimate Package'),
            'sub_module_name' => __('List'),
            'module_route'    => route('estimate-package.create'),
            'button_type'    => 'create' //create
        ];
        try {
            DB::beginTransaction();
            $columns = Schema::getColumnListing('estimate_packages');
            $filters = $request->all();
            $estimatePackages =  (new EstimatePackage())->getEstimatePackageList($request);
            DB::commit();
        }catch (Throwable $throwable){
            DB::rollBack();
            Log::info('ESTIMATE_PACKAGE_DATA_FETCH_FAILED', ['error' => $throwable]);
        }
        return view('estimate_package.index', compact('estimatePackages',
         'page_content','columns','filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    final public function create()
    {
        $page_content = [
            'page_title'      => __('Estimate Package Create'),
            'module_name'     => __('Estimate Package'),
            'sub_module_name' => __('Create'),
            'module_route'    => route('estimate-package.index'),
            'button_type'    => 'list' //create
        ];
        return view('estimate_package.add', compact('page_content'));
    }

    /**
     * Store a newly created resource in storage.
     */
    final public function store(StoreEstimatePackageRequest $request)
    {
        try {
            DB::beginTransaction();
            (new EstimatePackage())->createNewEstimatePackage($request);
            DB::commit();
            $message = 'New Estimate Package added successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('NEW_ESTIMATE_PACKAGE_SAVE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
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
    public function show(EstimatePackage $estimatePackage)
    {
        $page_content = [
            'page_title'      => __('Estimate Package Details'),
            'module_name'     => __('Estimate Package'),
            'sub_module_name' => __('Details'),
            'module_route'    => route('estimate-package.index'),
            'button_type'    => 'list' //create
        ];
        $estimatePackage->load(['user', 'activity_logs']);
        return view('estimate_package.show',compact('estimatePackage','page_content'));   
    }

    /**
     * Show the form for editing the specified resource.
     */
   final  public function edit(EstimatePackage $estimatePackage)
    {
       $page_content = [
            'page_title'      => __('Estimate PackageInformation Edit'),
            'module_name'     => __('Estimate Package Edit Page'),
            'sub_module_name' => __('Edit'),
            'module_route'    => route('estimate-package.index'),
            'button_type'    => 'list' //create
        ]; 

        return view('estimate_package.edit', compact('page_content','estimatePackage'));
    }

    /**
     * Update the specified resource in storage.
     */
       final  public function update(UpdateEstimatePackageRequest $request, EstimatePackage $estimatePackage)
    {
        try {
            DB::beginTransaction();
            $original = $estimatePackage->getOriginal();
            $updated  = (new EstimatePackage())->updateEstimatePackageInfo($request,$estimatePackage);
            $changed  = $updated->getChanges();
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $estimatePackage);
            

            DB::commit();
            $message = 'Estimate Package Information update successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('ESTIMATE_PACKAGE_INFORMATION_UPDATE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->route('estimate-package.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    final public function destroy(Request $request,EstimatePackage $estimatePackage)
    {
        try {
            DB::beginTransaction();
            $original = $estimatePackage->getOriginal();
            $changed = null;
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $estimatePackage);
            
            $estimatePackage->delete();
            DB::commit();
            $message = 'Estimate Package Information Delete successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('ESTIMATE_PACKAGE_INFORMATION_DELETE_FAILED', ['data' => $estimatePackage, 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();
    
    }
}
