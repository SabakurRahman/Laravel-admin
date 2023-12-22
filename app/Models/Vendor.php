<?php

namespace App\Models;

use App\Http\Requests\StoreVendorRequest;
use App\Http\Requests\UpdateVendorRequest;
use App\Manager\ImageUploadManager;
use App\Manager\Utility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Request;

class Vendor extends Model
{
    use HasFactory;
    protected $guarded =[];
    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 2;

    public const STATUS_LIST = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    public const PHOTO_UPLOAD_PATH = 'uploads/vendor/';
    public const PHOTO_UPLOAD_PATH_THUMB = 'uploads/vendor/thumb/';
    public const PHOTO_WIDTH = 600;
    public const PHOTO_HEIGHT = 600;
    public const PHOTO_WIDTH_THUMB = 150;
    public const PHOTO_HEIGHT_THUMB = 150;

    public function vendodfrList()
    {
        return self::all();
    }


    public function vendorList(Request $request)
    {
        $paginate  = $request->input('per_page') ?? 10;
        $query = self::query();
        if ($request->input('name')){
            $query->where('name', 'like', '%'.$request->input('name').'%');
        }
        if ($request->input('name_bn')){
            $query->where('name_bn', 'like', '%'.$request->input('name_bn').'%');
        }
        if ($request->input('status')){
            $query->where('status', $request->input('status'));
        }

        if ($request->input('sort_by') && $request->input('sort_direction')) {
            $query->orderBy($request->input('sort_by'), $request->input('sort_direction'));
        } else {
            $query->orderByDesc('id');
        }
        return $query->paginate($paginate);
    }


    public function storeVendor(StoreVendorRequest $request)
    {
        return self::query()->create($this->prepareVendorData($request));
    }

    private function prepareVendorData(StoreVendorRequest $request)
    {
        $data= [
            'name'              =>$request->input('name'),
            'name_bn'           =>$request->input('name_bn'),
            'slug'              => $request->input('slug'),
            'serial'            => $request->input('serial'),
            'description'       => $request->input('description'),
            'description_bn'    => $request->input('description_bn'),
            'email'             => $request->input('email'),
            'status'            =>$request->input('status'),
        ];
        if ($request->hasFile('photo')) {
            $photo = (new ImageUploadManager)->file($request->file('photo'))
                ->name(Utility::prepare_name($request->input('slug')))
                ->path(self::PHOTO_UPLOAD_PATH)
                ->height(self::PHOTO_HEIGHT)
                ->width(self::PHOTO_WIDTH)
                ->upload();

            $data['photo'] = $photo;
        }

        return $data;
    }

    public function updateVendor(UpdateVendorRequest $request, Vendor $vendor)
    {
        $updateVendorData = [
            'name'   =>$request->input('name')  ?? $vendor->name,
            'name_bn'   =>$request->input('name_bn')  ?? $vendor->name_bn,
            'slug'   =>$request->input('slug')  ?? $vendor->slug,
            'email'   =>$request->input('email')  ?? $vendor->email,
            'description' =>$request->input('description')?? $vendor->description,
            'description_bn' =>$request->input('description_bn')?? $vendor->description_bn,
            'status'   =>$request->input('status')  ?? $vendor->status,
            'serial'   =>$request->input('serial')  ?? $vendor->serial
        ];
        $photo=$vendor->photo;
        if($request->hasFile('photo'))
        {
            if($photo){
                ImageUploadManager::deletePhoto(self::PHOTO_UPLOAD_PATH, $vendor->photo);
            }

            $photo  = (new ImageUploadManager)->file($request->file('photo'))
                ->name(Utility::prepare_name($request->input('slug')))
                ->path(self::PHOTO_UPLOAD_PATH)
                ->height(self::PHOTO_HEIGHT)
                ->width(self::PHOTO_WIDTH)
                ->upload();

        }
        $updateVendorData['photo'] = $photo;
        $vendor->update($updateVendorData);
        return  $vendor;


    }


    final public function activity_logs():MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }
}
