<?php

namespace App\Http\Resources;

use App\Models\Address;
use App\Models\City;
use App\Models\Division;
use App\Models\User;
use App\Models\Zone;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'phone' => $this->phone,
            'name' => $this->name,
            'division_name' => Division::where('id', $this->division_id)->first()->name ?? null,
            'city_name' => City::where('id', $this->city_id)->first()->name ?? null,
            'zone_name' => Zone::where('id', $this->zone_id)->first()->name ?? null,
            'street_address' => $this->street_address,
            'country_id' => $this->country_id,
            'address_type' => Address::ADDRESS_TYPE_LIST[$this->address_type] ?? null,
            'address_type_id' => $this->address_type,
            'is_default' => $this->is_default,
            'zip_code' => $this->zip_code,
            'created_at' => Carbon::parse($this->created_at)->format('l, F j, Y'),
            'updated_at' => Carbon::parse($this->updated_at)->format('l, F j, Y'),
        ];
    }
}
