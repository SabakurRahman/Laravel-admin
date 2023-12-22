<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Division extends Model
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

    final public function getAllDivision()
    {
        return $this->orderBy('id', 'desc')->paginate(10);
    }
    public function getTotalDivision()
    {
        return $this->orderBy('id', 'desc')->get();
    }

    public function getDivision()
    {
        return self::query()->pluck('name', 'id');

    }

    public function storeDivision(Request $request)
    {
        return self::query()->create($this->prepareDivisionData($request));
    }
    private function prepareDivisionData(Request $request)
    {
        return[
           'name'     =>$request->name,
           'name_bn'  =>$request->name_bn,
            'status'  =>$request->status
        ];
    }



    public function updateDivision(Request $request, Division $division)
    {
        $data= [
            'name'     =>$request->name ??$division->name,
            'name_bn'  =>$request->name_bn ??$division->name_bn,
            'status'  =>$request->status ??$division->status
        ];

        return $division->update($data);

    }

    final public function getDivisionById($id)
    {
        return $this->where('id', $id)->first();
    }

    public function getDivisionAssoc()
    {
        return self::query()->pluck('name', 'id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function couriers()
    {
        return $this->belongsToMany(Courier::class, 'courier_divisions');
    }


    public function cities()
    {
        return $this->hasMany(City::class);
    }




}
