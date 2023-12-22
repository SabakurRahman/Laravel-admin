<?php

namespace App\Http\Controllers;

use App\Http\Resources\TeamResource;
use App\Manager\CommonResponse;
use App\Manager\ImageUploadManager;
use App\Models\ActivityLog;
use App\Models\Team;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Throwable;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page_content = [
            'page_title'      => __('Team List'),
            'module_name'     => __('Team'),
            'sub_module_name' => __('List'),
            'module_route'    => route('team.create'),
            'button_type'    => 'create' //create
        ];
        $columns = Schema::getColumnListing('teams');
        $filters = $request->all();
        $teamList = (new Team())->TeamList($request);
        return view('team.index',compact('teamList','page_content','columns','filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $page_content = [
            'page_title'      => __('Team Create'),
            'module_name'     => __('Team'),
            'sub_module_name' => __('Create'),
            'module_route'    => route('team.index'),
            'button_type'    => 'list' //create
        ];

        return view('team.create',compact('page_content',));


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeamRequest $request)
    {
        try {
            DB::beginTransaction();
            (new Team())->storeTeam($request);
            DB::commit();
            $message = ' Team added successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('TEAM__SAVE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->route('team.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        $page_content = [
            'page_title'      => __('Team  Details'),
            'module_name'     => __('Team'),
            'sub_module_name' => __('Details'),
            'module_route'    => route('team.index'),
            'button_type'    => 'list' //create
        ];
        return view('team.show',compact('team','page_content'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        $page_content = [
            'page_title'      => __('Team Edit'),
            'module_name'     => __('Team'),
            'sub_module_name' => __('Edit'),
            'module_route'    => route('team.index'),
            'button_type'    => 'list' //create
        ];

        return view('team.edit', compact('page_content','team'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeamRequest $request, Team $team)
    {
        try {
            DB::beginTransaction();
            $original = $team->getOriginal();
            $updated= (new Team())->updateTeam($request,$team);
            $changed=$updated->getChanges();
            (new ActivityLog())->storeActivityLog($request, $original,$changed,$team);
            DB::commit();
            $message = 'Team update successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('TEAM_UPDATE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->route('team.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team,Request $request)
    {
        try {
            DB::beginTransaction();
            ImageUploadManager::deletePhoto(Team::PHOTO_UPLOAD_PATH, $team->photo);

            $original = $team->getOriginal();
            $changed = null;
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $team);

            $team->delete();
            DB::commit();
            $message = 'Team Information Delete successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('TEAM_INFORMATION_DELETE_FAILED', ['data' => $team, 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();
    }

    final public function getTeam(): JsonResponse
    {

        $commonResponse = new CommonResponse();
        try {

            $commonResponse->data           = TeamResource::collection((new Team())->getTeamData());
            $commonResponse->status_message = __('Team Data fetched successfully');
        } catch (\Throwable $throwable) {
            Log::info('TEAM_DATA_FETCH_FAILED', ['data' => [], 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();

    }
}
