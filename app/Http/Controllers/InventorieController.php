<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Http\Requests\StoreInventorieRequest;
use App\Http\Requests\UpdateInventorieRequest;

class InventorieController extends Controller
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
    public function store(StoreInventorieRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventorie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventorie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInventorieRequest $request, Inventory $inventorie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventorie)
    {
        //
    }
}
