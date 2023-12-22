<?php

namespace App\Http\Controllers;

use App\Models\EstimatePrice;
use App\Http\Requests\StoreEstimatePriceRequest;
use App\Http\Requests\UpdateEstimatePriceRequest;

class EstimatePriceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 
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
    public function store(StoreEstimatePriceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(EstimatePrice $estimatePrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EstimatePrice $estimatePrice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEstimatePriceRequest $request, EstimatePrice $estimatePrice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EstimatePrice $estimatePrice)
    {
        //
    }
}
