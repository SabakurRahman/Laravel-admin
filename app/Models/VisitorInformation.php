<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class VisitorInformation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const VISITOR_INFO_SAVE_INTERVAL = 5;


    /**
     * @param Request $request
     * @return LengthAwarePaginator
     */
    final public function getAllVisitorInformation(Request $request): LengthAwarePaginator
    {
        $paginate = $request->input('per_page') ?? 20;
        $query    = self::query();
        if ($request->input('start_date')) {
            $query->where('created_at', '>=', Carbon::create($request->input('start_date'))->startOfDay());
        }
        if ($request->input('end_date')) {
            $query->where('created_at', '<=', Carbon::create($request->input('end_date'))->endOfDay());
        }
        if ($request->input('os')) {
            $query->where('os', $request->input('os'));
        }
        if ($request->input('browser')) {
            $query->where('browser', $request->input('browser'));
        }
        if ($request->input('device_type')) {
            $query->where('device_type', $request->input('device_type'));
        }
        if ($request->input('device')) {
            $query->where('device', $request->input('device'));
        }
        if ($request->input('ip')) {
            $query->where('ip', 'like', '%' . $request->input('ip') . '%');
        }
        if ($request->input('sort_by') && $request->input('sort_direction')) {
            $query->orderBy($request->input('sort_by'), $request->input('sort_direction'));
        } else {
            $query->orderByDesc('id');
        }
        return $query->paginate($paginate);
    }

    public function getDistinctOs()
    {
        return self::query()->select('os')->distinct('os')->get();
    }

    public function getDistinctBrowser()
    {
        return self::query()->select('browser')->distinct('browser')->get();
    }

    public function getDistinctDeviceType()
    {
        return self::query()->select('device_type')->distinct('device_type')->get();
    }

    public function getDistinctDevice()
    {
        return self::query()->select('device')->distinct('device')->get();
    }

    public function getVisitorStatistics()
    {
        $visitors = self::query()->select('created_at')->get();
        $endDate  = Carbon::now();
        return [
            'today'            => self::query()->whereDate('created_at', Carbon::now())->count(),
            'last_seven_days'  => self::query()->whereBetween('created_at', [$endDate->copy()->subDays(7), $endDate])->count(),
            'this_month'       => self::query()->whereMonth('created_at', Carbon::now()->month)->count(),
            'last_thirty_days' => self::query()->whereBetween('created_at', [$endDate->copy()->subDays(30), $endDate])->count(),
            'this_year'        => self::query()->whereYear('created_at', Carbon::now()->year)->count(),
            'all'              => $visitors->count(),
        ];
    }

    /**
     * @return BelongsTo
     */
    final public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
