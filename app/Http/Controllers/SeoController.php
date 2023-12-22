<?php

namespace App\Http\Controllers;

use App\Models\Seo;
use App\Http\Requests\StoreSeoRequest;
use App\Http\Requests\UpdateSeoRequest;

class SeoController extends Controller
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
    public function store(StoreSeoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Seo $seo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Seo $seo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    final public function update(UpdateSeoRequest $request, Seo $seo)
    {
        try {
            $seo->update($request->validated());
            return redirect()->back()->with('success', __('Seo Updated Successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seo $seo)
    {
        //
    }
}
