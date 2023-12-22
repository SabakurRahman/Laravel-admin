<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Http\Requests\StoreActivityLogRequest;
use App\Http\Requests\UpdateActivityLogRequest;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $activityLog = new ActivityLog();
        $page_content  = [
            'page_title'      => __('Blog Category List'),
            'module_name'     => __('Blog Category'),
            'sub_module_name' => __('List'),
            'module_route'    => route('blog-category.create'),
            'button_type'     => 'create' //create
        ];
        $activity_logs = $activityLog->getAllActivityLog($request);
        $columns = Schema::getColumnListing('activity_logs');
        $admins = User::query()->pluck('name', 'id');
        $routes = $activityLog->getDistinctData('route');
        $ips = $activityLog->getDistinctData('ip');
        $filters = $request->all();

        return view('activity_log.index', compact(
            'page_content',
            'activity_logs',
            'columns',
            'admins',
            'routes',
            'ips',
            'filters'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreActivityLogRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ActivityLog $activityLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ActivityLog $activityLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateActivityLogRequest $request, ActivityLog $activityLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActivityLog $activityLog)
    {
        //
    }


}
