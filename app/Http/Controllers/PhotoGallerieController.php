<?php

namespace App\Http\Controllers;
use Throwable;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Models\PhotoGallerie;

use App\Manager\CommonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Manager\ImageUploadManager;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Http\Resources\PhotoGalleryResource;
use App\Http\Requests\StorePhotoGallerieRequest;
use App\Http\Requests\UpdatePhotoGallerieRequest;

class PhotoGallerieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $photoGalleries = null;
        $page_content = [
            'page_title'      => __('Photo Gallery List'),
            'module_name'     => __('Photo Gallery'),
            'sub_module_name' => __('List'),
            'module_route'    => route('photo-gallery.create'),
            'button_type'     => 'create' //create
        ];
        try {
            DB::beginTransaction();
            $columns = Schema::getColumnListing('photo_galleries');
            $filters = $request->all();
            $photoGalleries = (new PhotoGallerie())->getPhotoGalleryList($request);
            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('PHOTO_GALLERY_DATA_FETCH_FAILED', ['error' => $throwable]);
        }
        return view('photoGallery.index')->with(compact('photoGalleries',
         'page_content','columns','filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_content = [
            'page_title'      => __('Photo Gallery Create'),
            'module_name'     => __('Photo Gallery Page'),
            'sub_module_name' => __('Create'),
            'module_route'    => route('photo-gallery.index'),
            'button_type'     => 'list' //create
        ];

        return view('photoGallery.add', compact('page_content'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePhotoGallerieRequest $request)
    {
      
        try {
            DB::beginTransaction();
            (new PhotoGallerie())->createNewPhotoGallery($request);
            DB::commit();
            $message = 'New Photo Gallery added successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('NEW_PHOTO_GALLERY_SAVE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
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
    public function show(PhotoGallerie $photo_gallery)
    {
        // dd($photo_gallery);
        $page_content = [
            'page_title'      => __('Photo Gallery Details'),
            'module_name'     => __('Photo Gallery'),
            'sub_module_name' => __('Details'),
            'module_route'    => route('photo-gallery.index'),
            'button_type'    => 'list' //create
        ];
        $photo_gallery->load(['user', 'activity_logs']);
        return view('photoGallery.show',compact('photo_gallery','page_content'));  
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PhotoGallerie $photo_gallery)
    {
        // dd($photo_gallery);
        $page_content = [
            'page_title'      => __('Photo Gallery Information Edit'),
            'module_name'     => __('Photo Gallery Edit Page'),
            'sub_module_name' => __('Edit'),
            'module_route'    => route('photo-gallery.index'),
            'button_type'     => 'list' //create
        ];

        return view('photoGallery.edit', compact('page_content', 'photo_gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePhotoGallerieRequest $request, PhotoGallerie $photo_gallery)
    {
        // dd($request->all());
       
        try {
            DB::beginTransaction();
            $original = $photo_gallery->getOriginal();
            $updated = (new PhotoGallerie())->updatePhotoGalleryInfo($request,$photo_gallery);
            $changed = $updated->getChanges();
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $photo_gallery);
           
            // (new PhotoGallerie())->updatePhotoGalleryInfo($request, $photo_gallery);
            DB::commit();
            $message = 'Photo Gallery Information update successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('PHOTO_GALLERY_INFORMATION_UPDATE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->route('photo-gallery.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PhotoGallerie $photo_gallery, Request $request)
    {
        try {
            DB::beginTransaction();
            ImageUploadManager::deletePhoto(PhotoGallerie::PHOTO_UPLOAD_PATH, $photo_gallery->photo);
            $original = $photo_gallery->getOriginal();
            $changed = null;
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $photo_gallery);
           
            $photo_gallery->delete();
            DB::commit();
            $message = 'Photo Gallery Information Delete successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('PHOTO_GALLERY_INFORMATION_DELETE_FAILED', ['data' => $photo_gallery, 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();

    }

    final public function getPhotoGalleryList(Request $request): JsonResponse
    {
        $commonResponse = new CommonResponse();
        try {
            $searchParams                   = [
                'search'       => $request->all(),
                // 'is_published' => Category::IS_PUBLISHED,
                'order_by'     => 'display_order',
            ];
            $photoGalleryList = PhotoGallerie::all();
            $formattedProductData = PhotoGalleryResource::collection($photoGalleryList)->response()->getData();
            $commonResponse->data = $formattedProductData->data;
            // $commonResponse->data           = PaymentMethodResource::collection((new PaymentMethod())->self::all())->response()->getData();
            $commonResponse->status_message = __('Photo Gallery Data fetched successfully');
        } catch (\Throwable $throwable) {
            Log::info('API_PHOTO_GALLERY_LIST_FETCH_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();
    }

}
