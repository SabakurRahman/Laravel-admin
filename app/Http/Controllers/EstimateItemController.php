<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\EstimateItem;
use App\Manager\CommonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreEstimateRecordRequest;
use App\Http\Requests\UpdateEstimateRecordRequest;

class EstimateItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $estimateItem;
    protected CommonResponse $commonResponse;

    public function __construct()
    {
        $this->estimateItem = new EstimateItem();
        $this->commonResponse = new CommonResponse();
    }


    final public function index()
    {
        try{
            
            $estimateRecordList = $this->estimateItem->getEstimateRecordList();
            $this->commonResponse->data = $estimateRecordList;
            $this->commonResponse->status_message = __('Record Fetched Successfully');
            $this->commonResponse->status_code = CommonResponse::STATUS_CODE_SUCCESS;
        }
        catch(Throwable $e){
            Log::error($e->getMessage());
            $this->commonResponse->status = false;
            $this->commonResponse->status_message = $e->getMessage();
            $this->commonResponse->status_code = CommonResponse::STATUS_CODE_FAILED;
        }
        return $this->commonResponse->commonApiResponse();
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
    public function store(StoreEstimateRecordRequest $request)
    {
        try{
            $estimateRecord = $this->estimateItem->createEstimateRecord($this->estimateItem->prepareEstimateRecoredData($request));
            $this->commonResponse->data = $estimateRecord;
            $this->commonResponse->status_message = __('Record Created Successfully');
            $this->commonResponse->status_code = CommonResponse::STATUS_CODE_SUCCESS;
        }
        catch(Throwable $e){
            Log::error($e->getMessage());
            $this->commonResponse->status = false;
            $this->commonResponse->status_message = $e->getMessage();
            $this->commonResponse->status_code = CommonResponse::STATUS_CODE_FAILED;
        }
        return $this->commonResponse->commonApiResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(EstimateItem $estimateRecord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EstimateItem $estimateRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    final public function update(UpdateEstimateRecordRequest $request, EstimateItem $estimateRecord)
    {
        try{
            $estimateRecord = $this->estimateItem->updateEstimateRecord($this->estimateItem->prepareEstimateRecoredData($request,$estimateRecord),$estimateRecord);
            $this->commonResponse->data = $estimateRecord;
            $this->commonResponse->status_message = __('Record Updated Successfully');
            $this->commonResponse->status_code = CommonResponse::STATUS_CODE_SUCCESS;
        }
        catch(Throwable $e){
            Log::error($e->getMessage());
            $this->commonResponse->status = false;
            $this->commonResponse->status_message = $e->getMessage();
            $this->commonResponse->status_code = CommonResponse::STATUS_CODE_FAILED;

        }
        return $this->commonResponse->commonApiResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
     final public function destroy(EstimateItem $estimateRecord)
    {
        try{
            $estimateRecord = $this->estimateItem->deleteEstimateRecord($estimateRecord);
            $this->commonResponse->data = $estimateRecord;
            $this->commonResponse->status_message = __('Record Deleted Successfully');
            $this->commonResponse->status_code = CommonResponse::STATUS_CODE_SUCCESS;
        }
        catch(Throwable $e){
            Log::error($e->getMessage());
            $this->commonResponse->status = false;
            $this->commonResponse->status_message = $e->getMessage();
            $this->commonResponse->status_code = CommonResponse::STATUS_CODE_FAILED;

        }
        return $this->commonResponse->commonApiResponse();
    }
}
