<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page_content = [
            'page_title'      => __('Zone List'),
            'module_name'     => __('Zone'),
            'sub_module_name' => __('List'),
            'module_route'    => route('zone.create'),
            'button_type'    => 'create' //create
        ];

        $zone = (new Zone())->getAllZone();
        return view('zone.index',compact('page_content','zone'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_content = [
            'page_title'      => __('Zone Create'),
            'module_name'     => __('Zone'),
            'sub_module_name' => __('Create'),
            'module_route'    => route('zone.index'),
            'button_type'    => 'list' //create
        ];

        $cityOptions = (new City())->getCity();


        return view('zone.create', compact('page_content', 'cityOptions'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name'             => 'required',
            'city_id'          => 'required'

        ]);

        (new Zone())->storeZone($request);
        return redirect()->route('zone.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Zone $zone)
    {
        $page_content = [
            'page_title'      => __('Zone Edit'),
            'module_name'     => __('Zone'),
            'sub_module_name' => __('Edit'),
            'module_route'    => route('zone.index'),
            'button_type'     => 'list' //create
        ];
        $zone->load('city');
        $cityOptions = (new City())->getCity();
        return view('zone.edit', compact('page_content','zone','cityOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Zone $zone)
    {
        $validatedData = $request->validate([
            'name'             => 'required',
            'city_id'      => 'required'

        ]);


        (new zone())->updateZone($request,$zone);
        return redirect()->route('zone.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Zone $zone)
    {
        try {
            DB::beginTransaction();
            $zone->couriers()->detach();
            $zone->delete();
            DB::commit();
            $zone->couriers()->detach();
            $message = 'Zone delete successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('ZONE_DELETE_FAILED', ['data' => $zone, 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();
    }


}
