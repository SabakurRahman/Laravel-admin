<?php

namespace App\Http\Controllers;

use App\Http\Resources\AddressListResource;
use App\Http\Resources\CityListResource;
use App\Http\Resources\DivisionListResource;
use App\Http\Resources\ZoneListResource;
use App\Manager\CommonResponse;
use App\Models\Address;
use App\Models\City;
use App\Models\Division;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
    public function index()
    {
        $commonResponse = new CommonResponse();
        try {
            $divisions = Division::query()->active()->select('id', 'name', 'status')->get();
            $cities    = City::query()->active()->select('id', 'name', 'status', 'division_id')->get();
            $zone      = Zone::query()->active()->select('id', 'name', 'status', 'city_id')->get();

            $commonResponse->data           = [
                'division' => DivisionListResource::collection($divisions),
                'city'     => CityListResource::collection($cities),
                'zone'     => ZoneListResource::collection($zone),
            ];
            $commonResponse->status_message = __('Location data fetched successfully');
        } catch (\Throwable $e) {
            Log::info('LOCATION_LIST_DATA_FETCHED_FAILED', ['data' => $e]);
            $commonResponse->status_message = 'Failed! ' . $e->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();
    }
}
