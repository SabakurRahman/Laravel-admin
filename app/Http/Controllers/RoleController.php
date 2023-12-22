<?php

namespace App\Http\Controllers;

// use App\Models\Role;
use Throwable;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $roles = null;
        $page_content = [
            'page_title'      => __('Role List'),
            'module_name'     => __('Role'),
            'sub_module_name' => __('List'),
            'module_route'    => route('role.create'),
            'button_type'     => 'Role' //create
        ];
        try {
            DB::beginTransaction();
            // $roles  = Role::query()->paginate(10);
            $columns = Schema::getColumnListing('roles');
            $filters = $request->all();
            $roles=  (new Role())->getRoleList($request);
           
            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('ROLE_DATA_FETCH_FAILED', ['error' => $throwable]);
            $roles = [];
        }
        return view('role.index')->with(compact('roles', 'page_content',
    'columns','filters'));
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_content = [
            'page_title'      => __('Role Create'),
            'module_name'     => __('Role Page'),
            'sub_module_name' => __('Create'),
            'module_route'    => route('role.index'),
            'button_type'    => 'list' //create
        ];

        return view('role.add', compact('page_content'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
       try {
            DB::beginTransaction();
            (new Role())->createNewRole($request);
            // Role::create( ['name'   => $request->input('name')]);
           
            DB::commit();
            $message = 'New Role added successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('NEW_ROLE_SAVE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
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
    public function show(Role $role)
    {
        $page_content = [
            'page_title'      => __('Role Details'),
            'module_name'     => __('Role'),
            'sub_module_name' => __('Details'),
            'module_route'    => route('role.index'),
            'button_type'    => 'list' //create
        ];
        // $role->load(['user', 'activity_logs']);
        return view('role.show',compact('role','page_content'));  
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $page_content = [
            'page_title'      => __('Role Information Edit'),
            'module_name'     => __('Role Edit Page'),
            'sub_module_name' => __('Edit'),
            'module_route'    => route('role.index'),
            'button_type'    => 'list' //create
        ]; 
        return view('role.edit', compact('page_content','role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        try {
            DB::beginTransaction();
            $original = $role->getOriginal();
            $updated = (new Role())->updateRoleInfo($request,$role);
            $changed = $updated->getChanges();
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $role);
           
            // $role->update(['name' => $request->input('name') ?? $role->name]);
            (new Role())->updateRoleInfo($request,$role);
            DB::commit();
            $message = 'Role Information update successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('ROLE_INFORMATION_UPDATE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->route('role.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role,Request $request)
    {
        try {
            DB::beginTransaction();
            // $original = $role->getOriginal();
            // $changed = null;
            // (new ActivityLog())->storeActivityLog($request, $original, $changed,$role);
            
            $role->delete();
            DB::commit();
            $message = 'Role Information Delete successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('ROLE_INFORMATION_DELETE_FAILED', ['data' => $role, 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();
    }



}
