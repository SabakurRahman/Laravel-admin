<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JsonException;

class ActivityLog extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function getAllActivityLog(Request $request)
    {
        $paginate  = $request->input('per_page') ?? 20;
        $query = self::query();



        return $query->paginate($paginate);
    }

    public function getDistinctData(string $column)
    {
        return self::query()->distinct($column)->pluck($column, $column);
    }


    /**
     * @throws JsonException
     */
    public function storeActivityLog($request, $original, $changed, $model)
    {
        $model->activity_logs()->create($this->perepareData($request, $original, $changed));
    }

    /**
     * @throws JsonException
     */
    private function perepareData($request, $original, $changed):array
    {
        if (!empty($changed)){
            unset($changed['updated_at']);
            $old_data = array_intersect_key($original, $changed);
        }else{
            $old_data = $original;
        }
        return [
            'user_id'  => Auth::id(),
            'note'     => $request->input('note'),
            'ip'       => $request->ip(),
            'action'   => $request->method(),
            'route'    => $request->route()?->getName(),
            'method'   => $request->method(),
            'agent'    => $request->userAgent(),
            'old_data' => json_encode($old_data, JSON_THROW_ON_ERROR),
            'new_data' => json_encode($changed, JSON_THROW_ON_ERROR),
        ];
    }

    final public function logable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
