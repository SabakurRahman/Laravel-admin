<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class City extends Model
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



    final public function getAllCity()
    {
        return self::query()->with('division')->orderByDesc('id')->paginate(10);
    }

    public function getTotalCity()
    {
        return self::query()->with('division')->orderByDesc('id')->get();
    }

    public function storeCity(Request $request)
    {
        return self::query()->create($this->prepareCityData($request));

    }
    private function prepareCityData(Request $request)
    {
        return[
          'name'           => $request->name,
          'name_bn'        => $request->name_bn,
          'division_id'    => $request->division_id,
           'status'        => $request->status
        ];
    }

    public function updateCity(Request $request, City $city)
    {
        $data = [
            'name'           => $request->name ?? $city->name,
            'name_bn'        => $request->name_bn ?? $city->name_bn,
            'division_id'    => $request->division_id ?? $city-> division_id,
            'status'         => $request->status ?? $city->status
        ];

        $city->update($data);
        return $city;
    }

    public function getCity()
    {
        return self::query()->pluck('name', 'id');
    }



    final public function getCityById($id)
    {
        return $this->where('id', $id)->first();
    }

    public function couriers()
    {
        return $this->belongsToMany(Courier::class, 'couriers_cities');
    }


    public function division()
    {
        return $this->belongsTo(Division::class);
    }




}
