<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Faq;
use App\Models\FaqPage;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Manager\CommonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\FaqResource;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreFaqRequest;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\UpdateFaqRequest;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page_content = [
            'page_title'      => __('Faq  List'),
            'module_name'     => __('Faq '),
            'sub_module_name' => __('List'),
            'module_route'    => route('faq.create'),
            'button_type'     => 'create' //create
        ];
        $columns = Schema::getColumnListing('faqs');
        $filters = $request->all();
        $faqPageOptions = (new FaqPage())->faqPages();
        $faqList = (new Faq())->allFaqList($request);
        return view('faq.index',compact('faqList','page_content',
            'filters','columns','faqPageOptions'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_content = [
            'page_title'      => __('Faq  Create'),
            'module_name'     => __('Faq '),
            'sub_module_name' => __('Create'),
            'module_route'    => route('faq.index'),
            'button_type'    => 'list' //create
        ];
        
        $faqPageOptions = (new FaqPage())->faqPages();
        
        $faqableType = 'App\Models\FaqPage'; 
        
        return view('faq.create', compact('page_content', 'faqPageOptions', 'faqableType'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFaqRequest $request)
    {
        try {
            DB::beginTransaction();
            (new Faq())->storeFaq($request); 
            DB::commit();
            $message = 'FAQ added successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('FAQ_SAVE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->route('faq.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
        $page_content = [
            'page_title'      => __('Faq  Details'),
            'module_name'     => __('Faq '),
            'sub_module_name' => __('Details'),
            'module_route'    => route('faq.index'),
            'button_type'    => 'list' //create
        ];
        $faq->load('faq_page');
           return view('faq.show',compact('faq','page_content'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        $page_content = [
            'page_title'      => __('Faq  Edit'),
            'module_name'     => __('Faq '),
            'sub_module_name' => __('Edit'),
            'module_route'    => route('faq.index'),
            'button_type'    => 'list' //create
        ];
        
        $faqPageOptions = (new FaqPage())->faqPages();
        $faqableType = 'App\Models\FaqPage'; 
        return view('faq.edit',compact('page_content','faq',
        'faqableType','faqPageOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(UpdateFaqRequest $request, Faq $faq)
    {
        try {
            DB::beginTransaction();
            $original = $faq->getOriginal();
             $faq->update([
                'question_title'=> $request->input('question_title'),
                'description'   => $request->input('description'),
                'status'        => $request->input('status'),
                'faqable_id'    => $request->input('faqable_id'),
                'faqable_type'  => $request->input('faqable_type'),
            ]);
            
            $changed = $faq->getChanges();
            
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $faq);
            
            DB::commit();
            $message = 'FAQ updated successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('FAQ_UPDATE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->route('faq.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq,Request $request)
    {
        try {
            DB::beginTransaction();
            $original = $faq->getOriginal();
            $changed = null;
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $faq);
            $faq->delete();
            DB::commit();
            $message = 'Faq Information Delete successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('FAQ_INFORMATION_DELETE_FAILED', ['data' => $faq, 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();
    }

    final public function getFaq(Request $request): JsonResponse
    {


        $commonResponse = new CommonResponse();
        try {

            $commonResponse->data           = FaqResource::collection(((new Faq())->getFaqDetails($request)));
            $commonResponse->status_message = __('Blog Post Data fetched successfully');
        } catch (\Throwable $throwable) {
            Log::info('API_CATEGORY_LIST_FETCH_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();


    }

}
