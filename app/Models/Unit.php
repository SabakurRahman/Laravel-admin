<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreUnitRequest;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\UpdateUnitRequest;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
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
     * @param Builder $query
     * @return Builder
     */
    final public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }


    public function getUnitList(Request $request)
    {
        $paginate = $request->input('per_page') ?? 10;
        $query    = self::query()->with(['user']);
        if ($request->input('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->input('short_name')) {
            $query->where('short_name', 'like', '%' . $request->input('short_name') . '%');
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

    public function createNewUnit(StoreUnitRequest $request)
    {
        return self::query()->create($this->prepareNewUnitData($request));
    }

    private function prepareNewUnitData(StoreUnitRequest $request)
    {
        $data = [
            'name'       => $request->input('name'),
            'short_name' => $request->input('short_name'),
            'status'     => $request->input('status'),
            'user_id'    => Auth::id(),

        ];
        return $data;
    }

    public function updateUnitInfo(UpdateUnitRequest $request, Unit $unit)
    {
        $updateUnitInfoData = [
            'name'       => $request->input('name') ?? $unit->name,
            'short_name' => $request->input('short_name') ?? $unit->short_name,
            'status'     => $request->input('status') ?? $unit->status,
            'user_id'    => Auth::id(),
        ];
        $unit->update($updateUnitInfoData);

        return $unit;

        //   return $socialMedia->update($updateSocialMediaInfoData);

    }

    // final public function prepareUnitData($request, Unit|null $unit = null)
    // {
    //     $data = [
    //         'name' => $request->name??$unit->name,
    //         'short_name' => $request->short_name??$unit->short_name,
    //         'status' => $request->status??$unit->status,
    //     ];

    //     return $data;
    // }

    // final public function storeData($data)
    // {
    //     return $this->create($data);
    // }

    final  public function updatedata($data, Unit $unit)
    {
        return $unit->update($data);
    }

    final public function deleteUnitData(Unit $unit)
    {
        return $unit->delete();
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

    public function getAssoc(bool $is_active = false)
    {
        $query = self::query();
        if ($is_active) {
            $query->active();
        }
        return $query->pluck('name', 'id');
    }


}
