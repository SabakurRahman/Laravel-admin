<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\StoreEstimatePriceRequest;
use App\Http\Requests\UpdateEstimatePriceRequest;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class EstimatePrice extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function createNewEstimatePrice(StoreEstimatePriceRequest $request)
    {
        return self::query()->create($this->prepareNewEstimatePriceData($request));
    }

    private function prepareNewEstimatePriceData(StoreEstimatePriceRequest $request)
    {
        $es_unit       = Unit::find($request->input('unit_id'));
        $es_unit_price = UnitPrice::find($request->input('unit_price_id'));
        $es_package    = EstimatePackage::find($request->input('package_id'));


        $data = [
            'unit_price_id' => $request->input('unit_price_id'),
            'unit_id'       => $request->input('unit_id'),
            'package_id'    => $request->input('package_id'),
            'max_size'      => $request->input('max_size'),
            'min_size'      => $request->input('min_size'),
            'unit_price'    => $request->input('unit_price'),
            'user_id'       => Auth::id(),
        ];
        return $data;
    }


    final public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    final public function package()
    {
        return $this->belongsTo(EstimatePackage::class, 'package_id', 'id');
    }

    final public function unitPrice()
    {
        return $this->belongsTo(UnitPrice::class, 'unit_price_id', 'id');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return MorphMany
     */
    final public function activity_logs(): MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }

    public function storeEstimatePrice(Request $request, Model $unit_price)
    {
        $package_data = [];
        foreach ($request->input('package') as $key => $package) {
            $package_data[] = [
                'unit_price_id' => $unit_price->id,
                'unit_id'       => $package['unit_id'] ?? 0,
                'package_id'    => $key ?? 0,
                'price'         => $package['price'] ?? 0,
                'max_size'      => $package['max_size'] ?? 0,
                'min_size'      => $package['min_size'] ?? 0,
                'created_by'    => Auth::id(),
                'updated_by'    => Auth::id(),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ];
        }
        self::query()->insert($package_data);
    }
    public function updateEstimatePrice(Request $request, Model $unit_price)
    {
        foreach ($request->input('package') as $key => $package) {
            if (!empty($package['id'])){
                $estimate_price = self::query()->findOrFail($package['id']);
                if ($estimate_price){
                    $package_data_update = [
                        'unit_price_id' => $unit_price->id,
                        'unit_id'       => $package['unit_id'] ?? 0,
                        'package_id'    => $key ?? 0,
                        'price'         => $package['price'] ?? 0,
                        'max_size'      => $package['max_size'] ?? 0,
                        'min_size'      => $package['min_size'] ?? 0,
                        'created_by'    => Auth::id(),
                        'updated_by'    => Auth::id(),
                    ];
                    $estimate_price->update($package_data_update);
                }
            }else{
                $package_data = [
                    'unit_price_id' => $unit_price->id,
                    'unit_id'       => $package['unit_id'] ?? 0,
                    'package_id'    => $key ?? 0,
                    'price'         => $package['price'] ?? 0,
                    'max_size'      => $package['max_size'] ?? 0,
                    'min_size'      => $package['min_size'] ?? 0,
                    'created_by'    => Auth::id(),
                    'updated_by'    => Auth::id(),
                ];
                self::query()->create($package_data);
            }

        }
    }
}
