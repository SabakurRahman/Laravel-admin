<?php

namespace App\Models;

use App\Manager\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Manager\ImageUploadManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attribute extends Model
{
    use HasFactory;

    protected $guarded = [];
    public const STATUS_ACTIVE = 1;
    public const STATUS_PENDING = 2;
    public const STATUS_BLOCKED = 3;

    public const STATUS_LIST = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_PENDING => 'Pending',
        self::STATUS_BLOCKED => 'Blocked',
    ];

    public const PHOTO_UPLOAD_PATH = 'uploads/attributes';
    public const PHOTO_WIDTH = 300;
    public const PHOTO_HEIGHT = 300;


    final public function prepareAttributeData($request, Attribute $attribute = null)
    {
        // Define an array to store the prepared data
        $data = [
            'name' => $request->input('name'),
            'name_bn' => $request->input('name_bn'),
            'description' => $request->input('description'),
            'description_bn' => $request->input('description_bn'),
            'status' => $request->input('status'),
        ];

        // Check if a photo is included in the request
        if ($request->hasFile('photo')) {
            $uploadedPhoto = (new ImageUploadManager)
                ->file($request->file('photo')) // Use file() to access uploaded files
                ->name(Utility::prepare_name($request->input('name')))
                ->path(self::PHOTO_UPLOAD_PATH)
                ->height(self::PHOTO_HEIGHT)
                ->width(self::PHOTO_WIDTH)
                ->upload();
            $data['photo'] = $uploadedPhoto;
        } elseif ($attribute && $attribute->photo) {
            $data['photo'] = $attribute->photo;
        }

        return $data;
    }


    final public function updateAttributeData(array $data, Attribute $attribute)
    {
        return $attribute->update($data);


    }

    final public function updateAttribute(Attribute $attribute , $data)
    {
        $attribute->update($data);
        return $attribute;
    }

    final public function createAttribute($data)
    {
        return Attribute::create($data);
    }

    final public function deleteAttribute(Attribute $attribute)
    {
        $attribute->delete();
    }

    final public function getAttributeById($id)
    {
        return Attribute::findOrFail($id);
    }


    final public function getAttributeList(Request $request)
    {
        $paginate = $request->input('per_page') ?? 10;
        $query    = self::query();
        if ($request->input('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->input('name_bn')) {
            $query->where('name_bn', 'like', '%' . $request->input('name_bn') . '%');
        }
        if ($request->input('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->input('sort_by') && $request->input('sort_direction')) {
            $query->orderBy($request->input('sort_by'), $request->input('sort_direction'));
        } else {
            $query->orderByDesc('id');
        }
        return $query->paginate($paginate);
    }



    final public function getActiveAttributes()
    {
        return Attribute::where('status' , self::STATUS_ACTIVE)->get();
    }

    final public function activity_logs():MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }

    public function getAttributeOption()
    {
        return self::query()->pluck('name', 'id');
    }

        final public function getProductAttributesByIds(array $ids): Collection
    {
        return self::query()->findMany($ids);
    }


}
