<?php

namespace App\Models;

use App\Http\Requests\StoreOrderRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderAddress extends Model
{
    use HasFactory;

    protected $guarded = [];


    /**
     * @param Request $request
     * @param Order|Model $order
     * @return void
     */
    final public function storeApiOrderAddress(Request $request, Order|Model $order): void
    {

        $address_id = [];

        if ($request->input('shipping_address_id')) {
            $address_id[] = $request->input('shipping_address_id');
        }
        if ($request->input('billing_address_id')) {
            $address_id[] = $request->input('billing_address_id');
        }

        $user_addresses = (new Address())->getAddressByIdIn($address_id);

        foreach ($user_addresses as $user_address) {
            if ($request->input('shipping_address_id') == $request->input('billing_address_id')) {
                $user_address->address_type = Address::ADDRESS_TYPE_ALL;
            }
            self::query()->create($this->prepareOrderAddressData($user_address, $order));
        }
    }


    /**
     * @param Address|Model $address
     * @param Order|Model $order
     * @return array
     */
    public function prepareOrderAddressData(Address|Model $address, Order|Model $order): array
    {
        return [
            'order_id'       => $order?->id,
            'user_id'        => $order?->user_id,
            'name'           => $address?->name,
            'street_address' => $address?->street_address,
            'phone'          => $address?->phone,
            'division_id'    => $address?->division_id,
            'city_id'        => $address?->city_id,
            'zone_id'        => $address?->zone_id,
            'country_id'     => $address?->country_id,
            'status'         => $address?->status,
            'zip_code'       => $address?->zip_code,
            'address_type'   => $address?->address_type,
            'landmark'       => $address?->landmark,
        ];
    }

    public function storeOrderAddress(Request|StoreOrderRequest $request, Model|Builder $order)
    {
        return self::query()->create($this->prepareAddressData($request, $order));

    }

    private function prepareAddressData(Request|StoreOrderRequest $request, Model|Builder $order)
    {
        return [
            'order_id'       => $order->id,
            'user_id'        => Auth::id(),
            'street_address' => $request->address,
            'phone'          => $request->phone_number,
            'division_id'    => $request->division_id,
            'city_id'        => $request->city_id,
            'zone_id'        => $request->zone_id
        ];
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function cities()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
