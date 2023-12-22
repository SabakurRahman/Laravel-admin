<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page_content = [
            'page_title'      => __('Division List'),
            'module_name'     => __('Division'),
            'sub_module_name' => __('List'),
            'module_route'    => route('division.create'),
            'button_type'    => 'create' //create
        ];

        $division = (new Division())->getAllDivision();
        return view('division.index',compact('page_content','division'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_content = [
            'page_title'      => __('Division Create'),
            'module_name'     => __('Division'),
            'sub_module_name' => __('List'),
            'module_route'    => route('division.index'),
            'button_type'    => 'list' //create
        ];


        return view('division.create',compact('page_content'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'             => 'required',

        ]);

        (new Division())->storeDivision($request);
        return redirect()->route('division.index');

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
    public function edit(Division $division)
    {
        $page_content = [
            'page_title'      => __('Division Edit'),
            'module_name'     => __('Division'),
            'sub_module_name' => __('Edit'),
            'module_route'    => route('division.index'),
            'button_type'     => 'list' //create
        ];
        return view('division.edit', compact('page_content','division'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Division $division)
    {
        $validatedData = $request->validate([
            'name'             => 'required',

        ]);

        (new Division())->updateDivision($request,$division);
         return redirect()->route('division.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Division $division)
    {
        try {
            DB::beginTransaction();
            $division->couriers()->detach();
            $division->delete();
            DB::commit();
            $message = 'division Delete successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('Division_DELETE_FAILED', ['data' => $division, 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();
    }
}
