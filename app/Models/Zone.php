<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Zone extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 2;

    public const STATUS_LIST = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    final public function scopeActive(Builder $builder):Builder
    {
        return $builder->where('status', self::STATUS_ACTIVE);
    }

    final public function getAllZone()
    {
        return $this->orderBy('id', 'desc')->paginate(10);
    }

    public function getTotalZone()
    {
        return $this->orderBy('id', 'desc')->get();

    }

    public function getAllZonesForDropdown()
    {
        return [];
    }

    public const IS_INSIDE_DHAKA = 3;
    public const IS_NOT_INSIDE_DHAKA = 4;
    public const IS_INSIDE_DHAKA_OR_NOT_LIST = [
        self::IS_INSIDE_DHAKA => 'YES',
        self::IS_NOT_INSIDE_DHAKA => 'NO',
    ];



    final public function getZoneById($id)
    {
        return $this->where('id', $id)->first();
    }

    public function couriers()
    {
        return $this->belongsToMany(Courier::class, 'courier_zone');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function storeZone(Request $request)
    {
        return self::query()->create($this->prepareZoneData($request));
    }

    private function prepareZoneData(Request $request)
    {

             return[
                 'name'              => $request->name,
                 'name_bn'           => $request->name_bn,
                 'city_id'           => $request->city_id,
                 'is_inside_dhaka'   => $request->	is_inside_dhaka,
                 'status'            => $request->status
             ];

    }

    public function updateZone(Request $request, Zone $zone)
    {
        $data = [
            'name'              => $request->name ?? $zone->name,
            'name_bn'           => $request->name_bn ?? $zone->name_bn,
            'city_id'           => $request->city_id ?? $zone->city_id,
            'is_inside_dhaka'   => $request->is_inside_dhaka ?? $zone->is_inside_dhaka,
            'status'            => $request->status ?? $zone->status
        ];
        $zone->update($data);

        return $zone;
    }




}
