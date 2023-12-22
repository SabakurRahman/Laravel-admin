<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Address extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const ADDRESS_TYPE_BILLING = 1;
    public const ADDRESS_TYPE_SHIPPING = 2;
    public const ADDRESS_TYPE_OFFICE = 3;
    public const ADDRESS_TYPE_ALL = 4;
    public const  ADDRESS_TYPE_LIST = [
        self::ADDRESS_TYPE_BILLING  => 'Billing Address',
        self::ADDRESS_TYPE_SHIPPING => 'Shipping Address',
        self::ADDRESS_TYPE_OFFICE   => 'Office Address',
        self::ADDRESS_TYPE_ALL   => 'All',
    ];

    public const INSIDE_DHAKA = 1;
    public const OUTSIDE_DHAKA = 2;


    public const SHIPPING_METHOD = [
        self::INSIDE_DHAKA  => 'Inside Dhaka',
        self::OUTSIDE_DHAKA => 'Outside Dhaka'
    ];


    public const IS_DEFAULT_ADDRESS = 1;
    public const IS_NOT_DEFAULT_ADDRESS = 2;
    public const IS_DEFAULT_LIST = [
        self::IS_DEFAULT_ADDRESS => 'Default',
        self::IS_NOT_DEFAULT_ADDRESS => 'Not Default',
    ];


    final public function prepareAddressData(Request $request, Address|null $address = null)
    {
        return [
            'address_type'   => $request->input('address_type'),
            'name'           => $request->input('name'),
            'is_default'     => $request->input('is_default'),
            'country_id'     => $request->input('country_id'),
            'division_id'    => $request->input('division_id'),
            'city_id'        => $request->input('city_id'),
            'zone_id'        => $request->input('zone_id'),
            'phone'          => $request->input('phone'),
            'street_address' => $request->input('street_address'),
            'landmark'       => $request->input('landmark'),
            'zip_code'       => $request->input('zip_code'),
        ];

    }


    final public function getAllAddress()
    {
        return $this->orderBy('id', 'desc')->get();
    }

    final public function getAddressById($id)
    {
        return $this->where('id', $id)->first();
    }


    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function divition()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    final public function getAllAddressByUserId($user_id)
    {
        return $this->where('user_id', $user_id)->orderBy('id', 'desc')->get();
    }


    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function addressable()
    {
        return $this->morphTo();
    }

    final public function updatefunction($address_data, Address $address)
    {
        return $address->update($address_data);
    }

    /**
     * @param array $ids
     * @return Collection
     */
    final public function getAddressByIdIn(array $ids): Collection
    {
        return self::query()->findMany($ids);
    }
}
