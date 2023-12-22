<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Throwable;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page_content = [
            'page_title'      => __('City List'),
            'module_name'     => __('City'),
            'sub_module_name' => __('List'),
            'module_route'    => route('city.create'),
            'button_type'     => 'create' //create
        ];

        $city = (new City())->getAllCity();
        return view('city.index',compact('page_content','city'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_content = [
            'page_title'      => __('City  Create'),
            'module_name'     => __('City'),
            'sub_module_name' => __('Create'),
            'module_route'    => route('city.index'),
            'button_type'     => 'list' //create
        ];

        $divisionOptions = (new Division())->getDivision();


        return view('city.create', compact('page_content', 'divisionOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'             => 'required',
            'division_id'      => 'required'

        ]);

        (new City())->storeCity($request);
        return redirect()->route('city.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city): View
    {
        $page_content = [
            'page_title'      => __('City Edit'),
            'module_name'     => __('City'),
            'sub_module_name' => __('Edit'),
            'module_route'    => route('city.index'),
            'button_type'     => 'list' //create
        ];
        $city->load('division');
        $divisionOptions = (new Division())->getDivision();
        return view('city.edit', compact('page_content','city','divisionOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city)
    {
        $validatedData = $request->validate([
            'name'             => 'required',
            'division_id'      => 'required'

        ]);


        (new City())->updateCity($request,$city);
        return redirect()->route('city.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        try {
            DB::beginTransaction();
            $city->couriers()->detach();
            $city->delete();
            DB::commit();
            $message = 'City delete successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('CITY_DELETE_FAILED', ['data' => $city, 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();
    }
}
