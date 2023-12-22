<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\ActivityLog;
use App\Models\Manufacture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Manager\ImageUploadManager;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\StoreManufactureRequest;
use App\Http\Requests\UpdateManufactureRequest;

class ManufactureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       $manufactures = [];
       $page_content = [
          'page_title'      => __('Manufacture List'),
          'module_name'     => __('Manufacture'),
          'sub_module_name' => __('List'),
          'module_route'    => route('manufacture.create'),
          'button_type'     => 'create' //create
       ];
       try {
        DB::beginTransaction();
        $columns = Schema::getColumnListing('manufactures');
        $filters = $request->all();
        $manufactures = (new Manufacture())->getManufactureList($request);
        DB::commit();
       } catch (Throwable $throwable) {
        DB::rollBack();
        Log::info('MANUFACTURES_DATA_FETCH_FAILED', ['error' => $throwable]);
       }
       return view('manufacture.index')->with(compact('manufactures',
        'page_content',
    'columns','filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_content = [
            'page_title'      => __('Manufacture Create'),
            'module_name'     => __('Manufacture Page'),
            'sub_module_name' => __('Create'),
            'module_route'    => route('manufacture.index'),
            'button_type'     => 'list' //create
        ];

        return view('manufacture.add', compact('page_content'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreManufactureRequest $request)
    {
      
        try {
            DB::beginTransaction();
            (new Manufacture())->createNewManufacture($request);
            DB::commit();
            $message = 'New Manufacture added successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('NEW_MANUFACTURE_SAVE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
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
    public function show(Manufacture $manufacture)
    {
        $page_content = [
            'page_title'      => __('Manufacture Details'),
            'module_name'     => __('Manufacture'),
            'sub_module_name' => __('Details'),
            'module_route'    => route('manufacture.index'),
            'button_type'    => 'list' //create
        ];
        $manufacture->load(['user', 'activity_logs']);
        return view('manufacture.show',compact('manufacture','page_content')); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Manufacture $manufacture)
    {
        // dd($category);
        $page_content = [
            'page_title'      => __('Manufacture Page Edit'),
            'module_name'     => __('Manufacture Edit Page'),
            'sub_module_name' => __('Edit'),
            'module_route'    => route('manufacture.index'),
            'button_type'     => 'list' //create
        ];
        //    $category= Category::findOrFail($id);

        return view('manufacture.edit', compact('page_content', 'manufacture'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateManufactureRequest $request, Manufacture $manufacture)
    {
        // dd($request->all());
       
        try {
            DB::beginTransaction();
            $original = $manufacture->getOriginal();
            $updated = (new Manufacture())->updateManufactureInfo($request,$manufacture);
            $changed = $updated->getChanges();
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $manufacture);
            
            DB::commit();
            $message = 'Manufacture Information update successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('MANUFACTURE_INFORMATION_UPDATE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->route('manufacture.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Manufacture $manufacture,Request $request)
    {
        try {
            DB::beginTransaction();
            ImageUploadManager::deletePhoto(Manufacture::PHOTO_UPLOAD_PATH, $manufacture->photo);
            $original = $manufacture->getOriginal();
            $changed = null;
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $manufacture);
            
            $manufacture->delete();
            DB::commit();
            $message = 'Manufacture Information Delete successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('MANUFACTURE_INFORMATION_DELETE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();

    }
}
