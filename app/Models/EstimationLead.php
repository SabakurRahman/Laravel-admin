<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use JsonException;

class EstimationLead extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    public const STATUS_LIST = [
        self::STATUS_ACTIVE   => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    public function getEstimationLeadsList(Request $request)
    {
        $paginate = $request->input('per_page') ?? 10;
        $query    = self::query();
        if ($request->input('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->input('phone')) {
            $query->where('phone', 'like', '%' . $request->input('phone') . '%');
        }
        if ($request->input('email')) {
            $query->where('email', 'like', '%' . $request->input('email') . '%');
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

    /**
     * @throws JsonException
     */
    final public function storeEstimationLead(Request $request, array $response_data): void
    {
        $estimation_lead = [
            'name'   => $request->input('user_data.name'),
            'email'  => $request->input('user_data.email'),
            'phone'  => $request->input('user_data.phone'),
            'data'   => json_encode($request->all(), JSON_THROW_ON_ERROR),
            'status' => self::STATUS_ACTIVE,
            'response' => json_encode($response_data, JSON_THROW_ON_ERROR)
        ];
        self::query()->create($estimation_lead);
    }
}
