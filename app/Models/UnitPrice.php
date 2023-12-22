<?php

namespace App\Models;

use App\Models\Unit;
use App\Models\Estimate;
use App\Models\EstimateItem;
use Illuminate\Http\Request;
use App\Models\EstimateCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\StoreUnitPriceRequest;
use App\Http\Requests\UpdateUnitPriceRequest;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnitPrice extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const OFFICE_INTERIOR = 1;
    public const HOME_INTERIOR = 2;

    public const TYPE_LIST = [
        self::OFFICE_INTERIOR => 'Office Interior',
        self::HOME_INTERIOR   => 'Home Interior',
    ];

    final public function getUnitPriceList(Request $request)
    {
        $paginate = $request->input('per_page') ?? 10;
        $query    = self::query()->with(['user']);

        if ($request->input('estimate_category_id')) {
            $query->where('estimate_category_id', $request->input('estimate_category_id'));
        }
        if ($request->input('estimate_sub_category_id')) {
            $query->where('estimate_sub_category_id', $request->input('estimate_sub_category_id'));
        }
        if ($request->input('type') !== null) {
            $query->where('type', $request->input('type'));
        }
        if ($request->input('sort_by') && $request->input('sort_direction')) {
            $query->orderBy($request->input('sort_by'), $request->input('sort_direction'));
        } else {
            $query->orderByDesc('id');
        }
        return $query->paginate($paginate);
    }

    public function createNewUnitPrice(StoreUnitPriceRequest $request)
    {
        return self::query()->create($this->prepareNewUnitPriceData($request));
    }

    private function prepareNewUnitPriceData(StoreUnitPriceRequest $request)
    {
        return [
            'estimate_category_id'     => $request->input('estimate_category_id'),
            'estimate_sub_category_id' => $request->input('estimate_sub_category_id'),
            'type'                     => $request->input('type'),
            'user_id'                  => Auth::id(),
        ];
    }

    public function updateUnitPriceInfo(UpdateUnitPriceRequest $request, UnitPrice $unitPrice)
    {
        $updateUnitPriceInfoData = [
            'estimate_category_id'     => $request->input('estimate_category_id'),
            'estimate_sub_category_id' => $request->input('estimate_sub_category_id'),
            'type'                     => $request->input('type'),
        ];

        $unitPrice->update($updateUnitPriceInfoData);
        return $unitPrice;

    }


    final public function updateUnitPrice(array $data, UnitPrice $unitPrice)
    {
        return $unitPrice->update($data);
    }


    final public function estimateCategory()
    {
        return $this->belongsTo(EstimateCategory::class, 'estimate_category_id', 'id');
    }

    final public function estimateSubCategory()
    {
        return $this->belongsTo(EstimateCategory::class, 'estimate_sub_category_id', 'id');
    }

    final public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    final public function unitPrice()
    {
        return $this->belongsTo(UnitPrice::class, 'unit_price_id', 'id');
    }

    final public function package()
    {
        return $this->belongsTo(EstimatePackage::class, 'package_id', 'id');
    }

    public function estimatePrices()
    {
        return $this->hasMany(EstimatePrice::class, 'unit_price_id', 'id');
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


    final public function getPriceFromdata($request)
    {
        $category_ids     = $request->input('estimate_category_id[]', [2, 2]);
        $sub_category_ids = $request->input('estimate_sub_category_id[]', [3, 2]);
        $estimateCustomer = new Estimate();
        $estimateCus      = $estimateCustomer->createEstimate($estimateCustomer->prepareEstimateData($request));

        foreach ($category_ids as $key => $category_id) {
            $estimatevaue['estimate_category_id']     = $category_id;
            $estimatevaue['estimate_sub_category_id'] = $sub_category_ids[$key];


            $estimatevaue['type_id']     = $request->input('type_id');
            $estimatevaue['estimate_id'] = $estimateCus?->id;
            $estimatevaue['quantity']    = $request->input('quantity');

            $estimateitem  = new EstimateItem();
            $estimateitems = $estimateitem->createEstimateRecord($estimatevaue);
        }

        $unit_prices = self::query()
            ->where('type', $request->input('type_id'))
            ->whereIn('estimate_category_id', $category_ids)
            ->whereIn('estimate_sub_category_id', $sub_category_ids)
            ->get();


        return $unit_prices->groupBy(function ($data) {
            return $data?->estimateSubCategory?->name;
        })->map(function ($item) {
            return $item->map(function ($data_item) {
                return [
                    'category'     => $data_item?->estimateCategory?->name,
                    'sub_category' => $data_item?->estimateSubCategory?->name,
                    'unit'         => $data_item?->unit?->name,
                    'unit_price'   => $data_item?->unit_price,
                    'max_size'     => $data_item?->max_size,
                    'min_size'     => $data_item?->min_size,
                ];
            });
        });

        // $estimateracord=  new EstimateRecord();
        // $data =$estimateracord->createEstimateRecord($estimateracord->prepareEstimateRecoredData($request,$data));


    }

}
