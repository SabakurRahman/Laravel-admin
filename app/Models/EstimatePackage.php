<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\StoreEstimatePackageRequest;
use App\Http\Requests\UpdateEstimatePackageRequest;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EstimatePackage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 2;

    public const STATUS_LIST = [
        self::STATUS_ACTIVE   => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    /**
     * @param Builder $builder
     * @return Builder
     */
    final public function scopeActive(Builder $builder):Builder
    {
        return $builder->where('status', self::STATUS_ACTIVE);
    }

    public function getEstimatePackageList(Request $request)
    {
        $paginate = $request->input('per_page') ?? 10;
        $query    = self::query()->with(['user']);
        if ($request->input('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->input('slug')) {
            $query->where('slug', 'like', '%' . $request->input('slug') . '%');
        }
        if ($request->input('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->input('sort_by') && $request->input('sort_direction')) {
            $query->orderBy($request->input('sort_by'), $request->input('sort_direction'));
        } else {
            $query->orderByDesc('id');
        }
        return $query->paginate($paginate);
    }

    public function createNewEstimatePackage(StoreEstimatePackageRequest $request)
    {
        return self::query()->create($this->prepareNewEstimatePackageData($request));
    }

    private function prepareNewEstimatePackageData(StoreEstimatePackageRequest $request)
    {
        return [
            'name'    => $request->input('name'),
            'slug'    => $request->input('slug'),
            'status'  => $request->input('status'),
            'user_id' => Auth::id(),

        ];
    }

    public function updateEstimatePackageInfo(UpdateEstimatePackageRequest $request, EstimatePackage $estimatePackage)
    {
        $updateEstimatePackageInfoData = [
            'name'    => $request->input('name') ?? $estimatePackage->name,
            'slug'    => $request->input('slug') ?? $estimatePackage->slug,
            'status'  => $request->input('status') ?? $estimatePackage->status,
            'user_id' => Auth::id()
        ];

        $estimatePackage->update($updateEstimatePackageInfoData);

        return $estimatePackage;


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


    final public function createEstimatePackage(array $data)
    {
        return self::create($data);
    }

    final public function updateEstimatePackage(array $data, EstimatePackage $estimatePackage)
    {
        return $estimatePackage->update($data);
    }

    final public function deleteEstimatePackage(EstimatePackage $estimatePackage)
    {
        return $estimatePackage->delete();
    }


    public function getAllEstimate(bool $is_active = false)
    {
        $query = self::query();
        if ($is_active) {
            $query->active();
        }
        return $query->get();
    }


}
