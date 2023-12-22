<?php

namespace App\Http\Controllers;

use App\Http\Resources\AddressListResource;
use App\Manager\CommonResponse;
use App\Models\Address;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $address;

    public function __construct()
    {
        $this->address = new Address();
    }

    final public function index()
    {
        try {
            $addresses = $this->address->getAllAddress();
            return view('address.index', compact('addresses'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    final  public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddressRequest $request)
    {
        $commonResponse = new CommonResponse();
        try {
            DB::beginTransaction();
            $user         = User::query()->findOrFail(Auth::user()->id);
            $address      = new Address();
            $address_data = $address->prepareAddressData($request);
            if ($request->is_default == Address::IS_DEFAULT_ADDRESS) {
                $user->addresses()->update(['is_default' => Address::IS_NOT_DEFAULT_ADDRESS]);
            }

            $user->addresses()->create($address_data);
            $latestAddress = $user->addresses()->latest()->first();
            DB::commit();
            $commonResponse->data           = new AddressListResource($latestAddress);
            $commonResponse->status_message = __('Address Added successfully');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::info('ADDRESS_UPDATE_FAILED', ['data' => $e]);
            $commonResponse->status_message = 'Failed! ' . $e->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    final public function update(UpdateAddressRequest $request, Address $address)
    {
        try {
            User::query()->findOrFail(Auth::id())->addresses()->update(['is_default'=> Address::IS_NOT_DEFAULT_ADDRESS]);
            $address_data = $this->address->prepareAddressData($request);
            $this->address->updatefunction($address_data, $address);
            return redirect()->back()->with('success', 'Address updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        $commonResponse = new CommonResponse();
        try {
            $address->delete();
            $commonResponse->status_message = __('Address deleted successfully');
        } catch (\Throwable $e) {
            Log::info('ADDRESS_DELETE_FAILED', ['data' => $e]);
            $commonResponse->status_message = 'Failed! ' . $e->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();
    }

    public function all_addresses()
    {
        $commonResponse = new CommonResponse();
        try {
            $user      = User::query()->findOrFail(Auth::user()->id);
            $addresses = $user->addresses()->get();

            $groupedAddresses   = $addresses->groupBy('address_type');
            $formattedAddresses = [];

            foreach ($groupedAddresses as $addressType => $addressList) {
                $formattedAddresses[isset(Address::ADDRESS_TYPE_LIST[$addressType]) ? strtolower(str_replace(' ', '_', Address::ADDRESS_TYPE_LIST[$addressType])) : null] = AddressListResource::collection($addressList);
            }
            $default_address                = $addresses->where('is_default', 1)->first();
            $formattedAddresses['default']  = !empty($default_address) ? new AddressListResource($default_address) : null;
            $commonResponse->data           = $formattedAddresses;
            $commonResponse->status_message = __('Address List for ' . $user->name . ' fetched successfully');
        } catch (\Throwable $e) {
            Log::info('ADDRESS_LIST_FAILED', ['data' => $e]);
            $commonResponse->status_message = 'Failed! ' . $e->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();
    }

    public function update_my_address(UpdateAddressRequest $request, Address $address)
    {
        $commonResponse = new CommonResponse();
        try {
            DB::beginTransaction();
            if ($request->input('is_default') == Address::IS_DEFAULT_ADDRESS){
                User::query()->findOrFail(Auth::id())->addresses()->update(['is_default'=> Address::IS_NOT_DEFAULT_ADDRESS]);
            }

            $address_data = $this->address->prepareAddressData($request);
            $this->address->updatefunction($address_data, $address);
            $commonResponse->status_message = __('Address updated successfully');
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::info('ADDRESS_UPDATE_FAILED', ['data' => $e]);
            $commonResponse->status_message = 'Failed! ' . $e->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();
    }


    public function make_address_default(Address $address)
    {
        $commonResponse = new CommonResponse();
        try {
            DB::beginTransaction();
            User::query()->findOrFail(Auth::id())->addresses()->update(['is_default'=> Address::IS_NOT_DEFAULT_ADDRESS]);
            $address->update(['is_default'=> Address::IS_DEFAULT_ADDRESS]);
            $commonResponse->status_message = __('Address made default successfully');
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::info('ADDRESS_MAKE_DEFAULT_FAILED', ['data' => $e]);
            $commonResponse->status_message = 'Failed! ' . $e->getMessage();
            $commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status         = false;
        }
        return $commonResponse->commonApiResponse();
    }
}
