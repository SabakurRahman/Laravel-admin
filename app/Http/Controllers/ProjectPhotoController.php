<?php

namespace App\Http\Controllers;

use Throwable;
use App\Manager\Utility;
use App\Models\ProjectPhoto;
use Illuminate\Http\Request;
use App\Manager\ImageUploadManager;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreProjectPhotoRequest;
use App\Http\Requests\UpdateProjectPhotoRequest;

class ProjectPhotoController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     */


     protected $projectPhoto;
    public function __construct()
    {
        $this->projectPhoto = new ProjectPhoto();
    }
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
    public function store(StoreProjectPhotoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectPhoto $projectPhoto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectPhoto $projectPhoto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    final public function update(Request $request, ProjectPhoto $projectPhoto)
    {
       try {
        
            $this->projectPhoto->updateProjectPhoto($projectPhoto,$this->projectPhoto->prepare_photo_data($request));
            return redirect()->back()->with('success', __('Project Photo Updated Successfully'));
        } catch (Throwable $e) {
            Log::error($e);
            abort(500, $e->getMessage());
            return false;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
     final   public function destroy(ProjectPhoto $projectPhoto)
    {
        try {
            $projectPhoto->delete();
            return redirect()->back()->with('success', __('Project Photo Deleted Successfully'));
        } catch (Throwable $e) {
            Log::error($e);
            abort(500, $e->getMessage());
            return false;
        }
    }

  


}
