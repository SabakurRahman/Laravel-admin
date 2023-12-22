<?php

namespace App\Models;
use Carbon\Carbon;
use App\Manager\Utility;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Manager\ImageUploadManager;
use function Laravel\Prompts\select;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\StoreManufactureRequest;
use App\Http\Requests\UpdateManufactureRequest;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Manufacture extends Model

{
    use HasFactory;
    protected $guarded = [];
    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    public const STATUS_LIST = [
        self::STATUS_ACTIVE   => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    public const PHOTO_UPLOAD_PATH = 'uploads/manufacture/';
    public const PHOTO_UPLOAD_PATH_THUMB = 'uploads/manufacture/thumb/';
    public const PHOTO_WIDTH = 800;
    public const PHOTO_HEIGHT = 800;
    public const PHOTO_WIDTH_THUMB = 150;
    public const PHOTO_HEIGHT_THUMB = 150;


    public function getManufactureList(Request $request)
    {
        // dd($request->all());
        $paginate  = $request->input('per_page') ?? 10;
        $query     = self::query()->with(['user']);
        if ($request->input('name')){
            $query->where('name', 'like', '%'.$request->input('name').'%');
        }
        if ($request->input('description')){
            $query->where('description', 'like', '%'.$request->input('description').'%');
        }
        if ($request->input('serial')){
            $query->where('serial',$request->input('serial'));
        }
        if ($request->input('status')|| $request ->input('status')===0){
            $query->where('status', $request->input('status'));
        }
        if ($request->input('sort_by') && $request->input('sort_direction')) {
            $query->orderBy($request->input('sort_by'), $request->input('sort_direction'));
        } else {
            $query->orderByDesc('id');
        }
        return $query->paginate($paginate);
    }

        public function createNewManufacture(StoreManufactureRequest $request)
    {
       
        return self::query()->create($this->prepareNewManufactureData($request));
    }

    private function prepareNewManufactureData(StoreManufactureRequest $request)
    {
        return [
            'name'          => $request->input('name'),
            'description'   => $request->input('description'),
            'serial'        => $request->input('serial'),
            'status'        => $request->input('status'),
            'user_id'       => Auth::id(),
            'photo'         => (new ImageUploadManager)->file($request->file('photo'))
                ->name(Utility::prepare_name($request->input('name')))
                ->path(self::PHOTO_UPLOAD_PATH)
                ->height(self::PHOTO_HEIGHT)
                ->width(self::PHOTO_WIDTH)
                ->upload(),
        ];
    }

        public function updateManufactureInfo(UpdateManufactureRequest $request, Manufacture $manufacture)
    {
        $updateManufactureInfoData = [
            'name'        => $request->input('name') ?? $manufacture->name,
            'serial'      => $request->input('serial') ?? $manufacture->serial,
            'status'      => $request->input('status') ?? $manufacture->status,
            'description' => $request->input('description') ?? $manufacture->description,
            'user_id'       => Auth::id(),
        ];
        if($request->has('photo')){
             ImageUploadManager::deletePhoto(self::PHOTO_UPLOAD_PATH, $manufacture->photo);
            $updateManufactureInfoData['photo' ]   = (new ImageUploadManager)->file($request->file('photo'))
                ->name(Utility::prepare_name($request->input('name')))
                ->path(self::PHOTO_UPLOAD_PATH)
                ->height(self::PHOTO_HEIGHT)
                ->width(self::PHOTO_WIDTH)
                ->upload();
        }

        $manufacture->update($updateManufactureInfoData);

        return $manufacture;

    }
        public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return MorphMany
     */
    final public function activity_logs():MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }

}
