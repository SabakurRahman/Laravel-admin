<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Courier extends Model
{
    use HasFactory;
    protected $guarded = [];

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 2;
    public const STATUS_LIST = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    public function storeCourier(Request $request)
    {

        return self::query()->create($this->prepareCourierData($request));

    }


    public function updateCourier(Request $request, Courier $courier)
    {
          $data=  [
            'name'                       => $request->courier_name ??$courier->name,
            'inside_courier_charge'      =>  $request->inside_courier_charge ?? $courier->inside_courier_charge,
            'outside_courier_charge'    => $request->outside_courier_charge ?? $courier->outside_courier_charge,
            'inside_condition_charge'   =>  $request->inside_condition_charge ?? $courier->inside_condition_charge,
            'outside_condition_charge'  => $request->outside_condition_charge ??$courier->outside_condition_charge ,
            'inside_return_charge'      =>  $request->inside_return_charge ?? $courier->inside_return_charge,
            'outside_return_charge'     =>  $request->outside_return_charge ?? $courier->outside_return_charge,
             'status'                   => $request->status ?? $courier->status
        ];

          $courier->update($data);

          return $courier;


    }

    private function prepareCourierData($request)
    {
        return  [
           'name'                       => $request->courier_name,
           'inside_courier_charge'      => $request->inside_courier_charge,
            'outside_courier_charge'    => $request->outside_courier_charge,
            'inside_condition_charge'   => $request->inside_condition_charge,
            'outside_condition_charge'  => $request->outside_condition_charge,
            'inside_return_charge'      => $request->inside_return_charge,
            'outside_return_charge'     => $request->outside_return_charge,
            'status'                    => $request->status
             ];
    }

    public function getCourierWithAll()
    {
        return self::with('divisions','cities','zones')->orderByDesc('id')->paginate(10);

    }



    public function getCourierName()
    {
        return self::query()->with('divisions','cities','zones')->get();
    }

    public function cities()
    {
        return $this->belongsToMany(City::class, 'couriers_cities');
    }

    public function zones()
    {
        return $this->belongsToMany(Zone::class, 'courier_zone');
    }


    public function divisions()
    {
        return $this->belongsToMany(Division::class, 'courier_divisions');
    }




}
