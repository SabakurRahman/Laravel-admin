<?php

namespace App\Http\Controllers;

// use App\Models\Role;
use App\Models\CustomerGroup;
use Throwable;
use App\Models\User;
use Spatie\FlareClient\View;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
Use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateUserRequest;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = null;
        $page_content = [
            'page_title'      => __('User Role Associate List'),
            'module_name'     => __('User Role Associate'),
            'sub_module_name' => __('List'),
        ];
        try {
            DB::beginTransaction();
            $columns = Schema::getColumnListing('users');
            $filters = $request->all();
            $users = (new User())->userList($request);
            // $users  = User::query()->paginate(10);
            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('ROLE_ASSOCIATION_DATA_FETCH_FAILED', ['error' => $throwable]);
        }
        return view('role.roleUserAssociation.index')->with(compact('users',
         'page_content','columns','filters'));

    }
    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $page_content = [
            'page_title'      => __('Role Association Details'),
            'module_name'     => __('Role Association'),
            'sub_module_name' => __('Details'),
            'module_route'    => route('user.index'),
            'button_type'    => 'list' //create
        ];
        return view('role.roleUserAssociation.show',compact('user','page_content'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {

        $page_content = [
            'page_title'      => __('Role Association Information Edit'),
            'module_name'     => __('Role Association Edit Page'),
            'sub_module_name' => __('Edit'),
            'module_route'    => route('user.index'),
            'button_type'    => 'list' //create
        ];
        $user->load('roles');
        // dd($user);
        $user_assigned_role_id_list = $user->roles()->pluck('id')->toArray();
        $roles = Role::pluck('name', 'id');
        // dd($role);
        return view('role.roleUserAssociation.edit')->with(compact('user','roles', 'user_assigned_role_id_list', 'page_content'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request,User $user)
    {
        if ($request->has('role_id')){
            $role_id = $request->input('role_id');
            $user->roles()->sync($role_id);
        }
        return redirect()->back();

    }


    public function customerGroupAssign(Request $request){
        $users = null;
        $page_content = [
            'page_title'      => __('User Customer Group Associate List'),
            'module_name'     => __('User Customer Group Associate'),
            'sub_module_name' => __('List'),
        ];
        try {
            DB::beginTransaction();
            $columns = Schema::getColumnListing('users');
            $filters = $request->all();
            $users  = (new User())->userList($request);
            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('CUSTOMER_GROUP_ASSOCIATION_DATA_FETCH_FAILED', ['error' => $throwable]);
        }
        return view('customer_group.customerGroupUserAssociation.index')->with(compact('users', 'page_content','columns','filters'));
    }

    public function customerGroupEdit($id){
        $user = (new User())->findUser($id);
        $page_content = [
            'page_title'      => __('Customer Group Information Edit'),
            'module_name'     => __('Customer Group Association Edit Page'),
            'sub_module_name' => __('Edit'),
            'module_route'    => route('user-customer.group'),
            'button_type'    => 'list' //create
        ];
        $user->load('customerGroups');
        $user_assigned_customerGroup_id_list = $user->customerGroups->pluck('id')->toArray();

        $customerGroup = CustomerGroup::pluck('name', 'id');
        return view('customer_group.customerGroupUserAssociation.edit')->with(compact('user','customerGroup', 'user_assigned_customerGroup_id_list', 'page_content'));

    }
    public function updateCustomerGroupAssociations(Request $request,$id)
    {
        $user = User::findOrFail($id);
        if ($request->has('customer_group_id'))
          {
           $selectedCustomerGroupIds = $request->input('customer_group_id');
           $user->customerGroups()->sync($selectedCustomerGroupIds);
          }

       return redirect()->back();
    }


}
