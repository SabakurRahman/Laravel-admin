<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Courier;
use App\Models\Division;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class CourierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page_content = [
                'page_title'      => __('Courier List'),
                'module_name'     => __('Courier'),
                'sub_module_name' => __('List'),
                'module_route'    => route('couriers.create'),
                'button_type'    => 'create' //create
            ];

        $courier = (new Courier())->getCourierWithAll();


      return view('courier.index',compact('page_content','courier'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_content = [
            'page_title'      => __('Courier Create'),
            'module_name'     => __('Courier'),
            'sub_module_name' => __('List'),
            'module_route'    => route('couriers.index'),
            'button_type'    => 'list' //create
        ];
        $divisions=(new Division())->getTotalDivision();
        $cities = (new City())->getTotalCity();
        $zones= (new Zone())->getTotalZone();

       return view('courier.create',compact('page_content','divisions','cities','zones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       //dd($request->all());
        $validatedData = $request->validate([
            'courier_name'             => 'required',
            'inside_courier_charge'    => 'required|numeric',
            'outside_courier_charge'   => 'required|numeric',
            'inside_condition_charge'  => 'required|numeric',
            'outside_condition_charge' => 'required|numeric',
            'inside_return_charge'     => 'required|numeric',
            'outside_return_charge'    => 'required|numeric',
        ]);

        $courier=(new Courier())->storeCourier($request);

        $courier->divisions()->sync($request->division_id);
        $courier->cities()->sync($request->city_id);
        $courier->zones()->sync($request->zone_id);

        return redirect()->route('couriers.index');




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
    public function edit(Courier $courier)
    {
        $page_content = [
            'page_title'      => __('Courier Edit'),
            'module_name'     => __('Courier'),
            'sub_module_name' => __('Edit'),
            'module_route'    => route('couriers.index'),
            'button_type'     => 'list' //create
        ];
        $courier->load('divisions','cities','zones');

        //dd($courier);
        $divisions=(new Division())->getTotalDivision();
        $cities = (new City())->getTotalCity();
        $zones= (new Zone())->getTotalZone();

        $selectedDivisions =$courier->divisions;
        $selectedCities = $courier->cities;
        $selectedZones =$courier->zones;

        return view('courier.edit', compact('page_content', 'courier','divisions','cities','zones','selectedDivisions','selectedCities','selectedZones'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Courier $courier)
    {
        $validatedData = $request->validate([
            'courier_name'             => 'required',
            'inside_courier_charge'    => 'required|numeric',
            'outside_courier_charge'   => 'required|numeric',
            'inside_condition_charge'  => 'required|numeric',
            'outside_condition_charge' => 'required|numeric',
            'inside_return_charge'     => 'required|numeric',
            'outside_return_charge'    => 'required|numeric',
        ]);



        $courier = (new Courier())->updateCourier($request,$courier);

        // You can sync the relationships here if needed.
        $courier->divisions()->sync($request->division_id);
        $courier->cities()->sync($request->city_id);
        $courier->zones()->sync($request->zone_id);

        return redirect()->route('couriers.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Courier $courier)
    {
        try {
            DB::beginTransaction();
            $courier->cities()->detach();
            $courier->zones()->detach();
            $courier->divisions()->detach();
            $courier->delete();
            DB::commit();
            $message = 'Courier delete successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('ZONE_DELETE_FAILED', ['data' => $courier, 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();
    }
}
