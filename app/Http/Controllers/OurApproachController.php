<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Schema;
use Throwable;
use App\Models\Seo;
use App\Models\OurApproach;
use Illuminate\Http\Request;
use App\Manager\CommonResponse;
use App\Models\OurApproachCategory;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreSeoRequest;
use App\Http\Requests\StoreourApproachRequest;
use App\Http\Requests\UpdateourApproachRequest;
use App\Http\Resources\OurApproacDetailsResource;

class OurApproachController extends Controller
{


     protected $ourApproach;

        public function __construct()
        {
            $this->ourApproach = new OurApproach();
        }

    final public function index(Request $request)
    {
        try{

            $page_content = [
                'page_title'      => __('Our Approach List'),
                'module_name'     => __('Our Approach Page'),
                'sub_module_name' => __('List'),
                'module_route'    => route('our-approach.create'),
                'button_type'    => 'create' //create
            ];
            $all_approachCategory = OurApproachCategory::all();
            $columns = Schema::getColumnListing('our_approach_categories');
            $filters = $request->all();
            $ourApproach = $this->ourApproach->getOurApproachList($request);
            return view('our_approach.index', compact('page_content','ourApproach','columns','filters','all_approachCategory'));
        }
        catch(Throwable $e){
            Log::error($e);
            abort(500);
            return false;
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    final public function create()
    {
        try{





            $page_content = [
                'page_title'      => __('Our Approach Create'),
                'module_name'     => __('Our Approach Page'),
                'sub_module_name' => __('create'),
                'module_route'    => route('our-approach.index'),
                'button_type'    => 'list' //create
            ];
            $ourApproachCategoryOptions = (new OurApproachCategory())->ourApprochCategoryList();
            return view('our_approach.create', compact('page_content','ourApproachCategoryOptions'));
        }
        catch(Throwable $e){
            Log::error($e);
            abort(500);
            return false;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    final public function store(StoreourApproachRequest $request)
    {
           $approachData= $this->ourApproach->storeOurApproach($this->ourApproach->prepareApporachData($request));
        //     $seo= new Seo();
        //    $seoData= $seo->prepareSeoData($request);
        //    $approachData->seos()->create($seoData);

            return redirect()->route('our-approach.index')->with('success', 'Our Approach created successfully');

}

    /**
     * Display the specified resource.
     */
    final public function show(OurApproach $ourApproach)
    {
        try {
            $page_content = [
                'page_title' => __('Our Approach  Details'),
                'module_name' => __('Our Approach'),
                'sub_module_name' => __('Details'),
                'module_route' => route('our-approach.index'),
                'button_type' => 'list' //create
            ];

            return view('our_approach.show', compact('page_content', 'ourApproach'));
        }
        catch(Throwable $e){
            Log::error($e->getMessage());
            abort(500, $e->getMessage());
            return false;
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    final public function edit(OurApproach $ourApproach)
    {
        try{

            $page_content = [
                'page_title'      => __('Our Approach Edit'),
                'module_name'     => __('Our Approach Page'),
                'sub_module_name' => __('Edit'),
                'module_route'    => route('our-approach.index'),
                'button_type'    => 'list' //create
            ];
            $ourApproachCategoryOptions = (new OurApproachCategory())->ourApprochCategoryList();
            return view('our_approach.edit', compact('page_content','ourApproach','ourApproachCategoryOptions'));
        }
        catch(Throwable $e){
            Log::error($e);
            abort(500);
            return false;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    final public function update(UpdateourApproachRequest $request, OurApproach $ourApproach)
    {
        try{
            $original = $ourApproach->getOriginal();
            $updated= $this->ourApproach->updateOurApproach($ourApproach, $this->ourApproach->prepareApporachData($request, $ourApproach));
            $changed = $updated->getChanges();
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $ourApproach);
            return redirect()->route('our-approach.index')->with('success', 'Our Approach updated successfully');
        }
        catch(Throwable $e){
            Log::error($e);
            abort(500);
            return false;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    final public function destroy(OurApproach $ourApproach,Request $request)
    {
        try{
            $original = $ourApproach->getOriginal();
            $changed = null;
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $ourApproach);

            $this->ourApproach->deleteOurApproach($ourApproach->id);
            return redirect()->route('our-approach.index')->with('success', 'Our Approach deleted successfully');
        }
        catch(Throwable $e){
            Log::error($e);
            abort(500);
            return false;
        }
    }

    //api-start

    final public function getOurApproach(string $slug){
        $commonResponse = new CommonResponse();
        try{
            $ourApproach = $this->ourApproach->getOurApproachDetails($slug);
            $details = !empty($ourApproach) ? new OurApproacDetailsResource($ourApproach) : [];

            $commonResponse->data = $details;
            $commonResponse->status_message = __('Approach Data fetched successfully');
            Log::info('First_APPROACH_FETCHED');
            $commonResponse->status_message = 'Success';
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_SUCCESS;
            $commonResponse->status         = true;
        }
        catch(Throwable $e){
            $commonResponse->status_message = __('Approach Data fetched successfully');
            Log::info('First_APPROACH_FETCH_FAILED',[$e]);
            $commonResponse->status_message = 'Failed! ' . $e->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();
    }

    final public function getAllApproach(){
        $commonResponse = new CommonResponse();
        try{
            $ourApproach = $this->ourApproach->getOurApproachListforFrontend();
            $details = !empty($ourApproach) ? OurApproacDetailsResource::collection($ourApproach) : [];

            $commonResponse->data = $details;
            $commonResponse->status_message = __('Approach Data fetched successfully');
            Log::info('First_APPROACH_FETCHED');
            $commonResponse->status_message = 'Success';
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_SUCCESS;
            $commonResponse->status         = true;
        }
        catch(Throwable $e){
            $commonResponse->status_message = __('Approach Data fetched successfully');
            Log::info('First_APPROACH_FETCH_FAILED',[$e]);
            $commonResponse->status_message = 'Failed! ' . $e->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();
    }


}
