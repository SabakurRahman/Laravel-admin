<?php

namespace App\Http\Controllers;
use Throwable;
use App\Models\ActivityLog;
use App\Models\SocialMedia;
use Illuminate\Http\Request;

use App\Manager\CommonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Manager\ImageUploadManager;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Http\Resources\SocialMediaResource;
use App\Http\Requests\StoreSocialMediaRequest;
use App\Http\Requests\UpdateSocialMediaRequest;


class SocialMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $socialMedia = null;
        $page_content = [
            'page_title'      => __('Social Media List'),
            'module_name'     => __('Social Media'),
            'sub_module_name' => __('List'),
            'module_route'    => route('social.create'),
            'button_type'     => 'create' //create
        ];
        try {
            DB::beginTransaction();
            $columns = Schema::getColumnListing('social_media');
            $filters = $request->all();
            $socialMedia =  (new SocialMedia())->getSocialMediaList( $request);
            DB::commit();
        }catch (Throwable $throwable){
            DB::rollBack();
            Log::info('SOCIAL_MEDIA_DATA_FETCH_FAILED', ['error' => $throwable]);
        }
        return view('socialMedia.index')->with(compact('socialMedia',
         'page_content','columns','filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $page_content = [
            'page_title'      => __('Social Media Create'),
            'module_name'     => __('Social Media Page'),
            'sub_module_name' => __('Create'),
            'module_route'    => route('social.index'),
            'button_type'    => 'list' //create
        ];

        return view('socialMedia.add', compact('page_content'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSocialMediaRequest $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            (new SocialMedia())->createNewSocialMedia($request);
            // dd($request->all());
            DB::commit();
            $message = 'New Social Media added successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('NEW_SOCIAL_MEDIA_SAVE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();
    }

    public function show(SocialMedia $social)
    {
        $page_content = [
            'page_title'      => __('Social Media Details'),
            'module_name'     => __('Social Media'),
            'sub_module_name' => __('Details'),
            'module_route'    => route('social.index'),
            'button_type'    => 'list' //create
        ];
        $social->load(['user', 'activity_logs']);
        return view('socialMedia.show',compact('social','page_content')); 
    }

    public function edit(SocialMedia $social)
    {
        $page_content = [
            'page_title'      => __('Social Media Information Edit'),
            'module_name'     => __('Social Media Edit Page'),
            'sub_module_name' => __('Edit'),
            'module_route'    => route('social.index'),
            'button_type'    => 'list' //create
        ]; 
       // $social_media = SocialMedia::findOrFail($id);
        return view('socialMedia.edit', compact('page_content','social'));
    }


    public function update(UpdateSocialMediaRequest $request, SocialMedia $social)
    {
        try {
            DB::beginTransaction();
            // $socialMedia= SocialMedia::findOrFail($request->id);
            $original = $social->getOriginal();
            $updated = (new SocialMedia())->updateSocialMediaInfo($request,$social);
            $changed = $updated->getChanges();
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $social);
            
            
            // (new SocialMedia())->updateSocialMediaInfo($request,$social);
            DB::commit();
            $message = 'Social Media Information update successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('SOCIAL_MEDIA_INFORMATION_UPDATE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->route('social.index');
    }




    public function destroy(SocialMedia $social, Request $request)
    {
        try {
            DB::beginTransaction();
            ImageUploadManager::deletePhoto(SocialMedia::PHOTO_UPLOAD_PATH, $social->photo);
            $original = $social->getOriginal();
            $changed = null;
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $social);
            
            $social->delete();
            DB::commit();
            $message = 'Social Media Information Delete successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('SOCIAL_MEDIA_INFORMATION_DELETE_FAILED', ['data' => $social, 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();
    }

    final public function getSocialMediaList(Request $request): JsonResponse
    {
        $commonResponse = new CommonResponse();
        try {
            $searchParams                   = [
                'search'       => $request->all(),
                // 'is_published' => Category::IS_PUBLISHED,
                'order_by'     => 'display_order',
            ];
            $socialMediaList      = SocialMedia::all();
            $formattedProductData = SocialMediaResource::collection($socialMediaList)->response()->getData();
            $commonResponse->data = $formattedProductData->data;
        
            // $commonResponse->data           = PaymentMethodResource::collection((new PaymentMethod())->self::all())->response()->getData();
            $commonResponse->status_message = __('Social Media Data fetched successfully');
        } catch (\Throwable $throwable) {
            Log::info('API_SOCIAL_MEDIA_LIST_FETCH_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();
    }


}
