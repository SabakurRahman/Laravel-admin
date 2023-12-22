<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

use function Laravel\Prompts\select;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\StoreWarehouseRequest;
use App\Http\Requests\UpdateWarehouseRequest;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Warehouse extends Model
{
    use HasFactory;
    protected $guarded = [];

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    public const STATUS_LIST = [
        self::STATUS_ACTIVE   => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    public function getWarehouseList(Request $request)
    {
        $paginate  = $request->input('per_page') ?? 10;
        $query     = self::query()->with(['user']);
        if ($request->input('name')){
            $query->where('name', 'like', '%'.$request->input('name').'%');
        }
        if ($request->input('admin_comment')){
            $query->where('admin_comment', 'like', '%'.$request->input('admin_comment').'%');
        }
        if ($request->input('phone')){
            $query->where('phone', 'like', '%'.$request->input('phone').'%');
        }
        if ($request->input('city')){
            $query->where('city', 'like', '%'.$request->input('city').'%');
        }
        if ($request->input('street_address')){
            $query->where('street_address', 'like', '%'.$request->input('street_address').'%');
        }
          
        if ($request->input('status')|| $request ->input('status') == 0){
            $query->where('status', $request->input('status'));
        }
        if ($request->input('sort_by') && $request->input('sort_direction')) {
            $query->orderBy($request->input('sort_by'), $request->input('sort_direction'));
        } else {
            $query->orderByDesc('id');
        }
        return $query->paginate($paginate);
    }


    public function createNewWarehouse(StoreWarehouseRequest $request)
    {
        return self::query()->create($this->prepareNewWarehouseData($request));
    }

    private function prepareNewWarehouseData(StoreWarehouseRequest $request)
    {
        return [
            'name'          => $request->input('name'),
            'admin_comment' => $request->input('admin_comment'),
            'phone'         => $request->input('phone'),
            'city'          => $request->input('city'),
            'street_address'=> $request->input('street_address'),
            'status'        => $request->input('status'),
            'user_id'       => Auth::id(),
        ];
    }

    public function updateWarehouseInfo(UpdateWarehouseRequest $request, Warehouse $warehouse)
    {
        $updateWarehouseInfoData = [
            'name'        => $request->input('name') ?? $warehouse->name,
            'admin_comment' => $request->input('admin_comment')?? $warehouse->admin_comment,
            'phone'         => $request->input('phone')?? $warehouse->phone,
            'city'          => $request->input('city')?? $warehouse->city,
            'street_address'=> $request->input('street_address')?? $warehouse->street_address,
            'status'        => $request->input('status')?? $warehouse->status,
            'user_id' => Auth::id()
        ];
        $warehouse->update($updateWarehouseInfoData);

        return $warehouse;

        // return $warehouse->update($updateWarehouseInfoData);

    }
           public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
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
