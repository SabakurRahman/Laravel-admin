<?php

namespace App\Http\Controllers;
use Throwable;
use App\Models\NewsLetter;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

use App\Manager\CommonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Http\Resources\NewsletterResource;
use App\Http\Requests\StoreNewsLetterRequest;
use App\Http\Requests\UpdateNewsLetterRequest;

class NewsLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $newsLetters = null;

        $page_content=[
            'page_title' => __('Newsletter List'),
            'module_name' =>__('Newsletter'),
            'sub_module_name' => __('List'),
            'module_route'=>route('news-letter.create'),
            'button_type'=> 'create'
        ];
        try{
            DB::beginTransaction();
            $columns = Schema::getColumnListing('news_letters');
            $filters = $request->all();
            $newsLetters= (new NewsLetter())->getNewsLetterList($request);
            DB::commit();
        }catch(Throwable $throwable){
            DB::rollback();
            Log::info('NEWSLETTER_DATA_FETCH_FAILED',['error'=>$throwable]);

        }
        return view('newsLetter.index')->with(compact('newsLetters', 'page_content'
        ,'columns','filters'));

        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_content = [
            'page_title'      => __('Newsletter Create'),
            'module_name'     => __('NewsletterPage'),
            'sub_module_name' => __('Create'),
            'module_route'    => route('news-letter.index'),
            'button_type'    => 'list' //create
        ];

        return view('newsLetter.add', compact('page_content'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewsLetterRequest $request)
    {
        try {
            DB::beginTransaction();
            (new NewsLetter())->createNewNewsLetter($request);
            DB::commit();
            $message = 'New Newsletter added successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('NEW_NEWSLETTER_SAVE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(NewsLetter $newsLetter)
    {
        $page_content = [
            'page_title'      => __('Newsletter Details'),
            'module_name'     => __('Newsletter'),
            'sub_module_name' => __('Details'),
            'module_route'    => route('news-letter.index'),
            'button_type'    => 'list' //create
        ];
        $newsLetter->load(['user', 'activity_logs']);
        return view('newsLetter.show',compact('newsLetter','page_content'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NewsLetter $newsLetter)
    {
       $page_content = [
            'page_title'      => __('Newsletter Information Edit'),
            'module_name'     => __('Newsletter Edit Page'),
            'sub_module_name' => __('Edit'),
            'module_route'    => route('news-letter.index'),
            'button_type'    => 'list' //create
        ]; 

        return view('newsLetter.edit', compact('page_content','newsLetter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNewsLetterRequest $request, NewsLetter $newsLetter)
    {
        try {
            DB::beginTransaction();
            $original = $newsLetter->getOriginal();
            $updated = (new NewsLetter())->updateNewsLetterInfo($request,$newsLetter);
            $changed = $updated->getChanges();
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $newsLetter);
           
            DB::commit();
            $message = 'Newsletter Information update successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('NEWSLETTER_INFORMATION_UPDATE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->route('news-letter.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NewsLetter $newsLetter,Request $request)
    {
        try {
            DB::beginTransaction();
            $original = $newsLetter->getOriginal();
            $changed = null;
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $newsLetter);
            
            $newsLetter->delete();
            DB::commit();
            $message = 'Newsletter Information Delete successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('NEWSLETTER_INFORMATION_DELETE_FAILED', ['data' => $newsLetter, 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();
    
    }
        final public function getNewsletterList(Request $request): JsonResponse
    {
        $commonResponse = new CommonResponse();
        try {
            $searchParams                   = [
                'search'       => $request->all(),
                // 'is_published' => Category::IS_PUBLISHED,
                'order_by'     => 'display_order',
            ];
            $newsletterList = NewsLetter::all();
            $formattedProductData = NewsLetterResource::collection($newsletterList)->response()->getData();
            $commonResponse->data = $formattedProductData->data;
            // $commonResponse->data           = PaymentMethodResource::collection((new PaymentMethod())->self::all())->response()->getData();
            $commonResponse->status_message = __('Newsletter Data fetched successfully');
        } catch (\Throwable $throwable) {
            Log::info('API_NEWSLETTER_LIST_FETCH_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();
    }

    final public function PostNewsletterStore(StoreNewsLetterRequest $request): JsonResponse
    {
        $commonResponse = new CommonResponse();
        try {
            (new NewsLetter())->createNewNewsLetter($request);
            // data show
            // $newsletterList = NewsLetter::all();
            // $commonResponse->data = NewsLetterResource::collection($newsletterList)->response()->getData();

            $commonResponse->status_message = __('Newsletter Data fetched successfully');
        } catch (\Throwable $throwable) {
            Log::info('API_NEWSLETTER_LIST_FETCH_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse(); 
    }
    
}
