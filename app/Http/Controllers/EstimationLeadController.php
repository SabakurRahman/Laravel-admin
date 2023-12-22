<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use App\Models\EstimationLead;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\StoreEstimationLeadRequest;
use App\Http\Requests\UpdateEstimationLeadRequest;

class EstimationLeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $estimationLeads    = null;
        $page_content = [
            'page_title'      => __('Estimation Leads List'),
            'module_name'     => __('Estimation Leads'),
            'sub_module_name' => __('List'),
        ];
        try {
            DB::beginTransaction();
            $columns = Schema::getColumnListing('estimation_leads');
            $filters = $request->all();
            $estimationLeads   = (new EstimationLead())->getEstimationLeadsList($request);
            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('ESTIMATION_LEADS_DATA_FETCH_FAILED', ['error' => $throwable]);
        }
        return view('estimation_leads.index')->with(compact('estimationLeads',
        'page_content','columns','filters'));
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
    public function store(StoreEstimationLeadRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(EstimationLead $estimationLead)
    {
        $page_content = [
                'page_title'      => __('Estimation Leads Details'),
                'module_name'     => __('Estimation Leads'),
                'sub_module_name' => __('Details'),
                'module_route'    => route('estimation-lead.index'),
                'button_type'    => 'list' //create
            ];
        return view('estimation_leads.show',compact('estimationLead','page_content'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EstimationLead $estimationLead)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEstimationLeadRequest $request, EstimationLead $estimationLead)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EstimationLead $estimationLead)
    {
        try {
            DB::beginTransaction();
            // dd($estimationLeads);
            // $estimationLead = EstimationLead::query()->pluck('id');
            $estimationLead->delete();
            DB::commit();
            $message = 'Estimation Leads Information Delete successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('ESTIMATION_LEADS_INFORMATION_DELETE_FAILED', ['data' => $estimationLead, 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();
    }
}
