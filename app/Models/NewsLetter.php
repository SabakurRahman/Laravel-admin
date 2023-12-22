<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\StoreNewsLetterRequest;
use App\Http\Requests\UpdateNewsLetterRequest;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NewsLetter extends Model
{
    use HasFactory;
    protected $guarded=[];

    public const STATUS_ACTIVE =1;
    public const STATUS_INACTIVE=2;

    public const STATUS_LIST=[
        self::STATUS_ACTIVE =>'Active',
        self::STATUS_INACTIVE   =>'Inactive',
    ];

    public function getNewsLetterList(Request $request){
        $paginate  = $request->input('per_page') ?? 10;
        $query     = self::query()->with(['user']);
        if ($request->input('name')){
            $query->where('name', 'like', '%'.$request->input('name').'%');
        }
        if ($request->input('email')){
            $query->where('email', 'like', '%'.$request->input('email').'%');
        }
        if ($request->input('ip')){
            $query->where('ip', 'like', '%'.$request->input('ip').'%');
        }
        
        if ($request->input('status')){
            $query->where('status', $request->input('status'));
        }
        if ($request->input('sort_by') && $request->input('sort_direction')) {
            $query->orderBy($request->input('sort_by'), $request->input('sort_direction'));
        } else {
            $query->orderByDesc('id');
        }
        return $query->paginate($paginate);
    }

    public function createNewNewsLetter(StoreNewsLetterRequest $request)
    {
        return self::query()->create($this->prepareNewNewsLetterData($request));
    }

    private function prepareNewNewsLetterData(StoreNewsLetterRequest $request)
    {
        return[
            'name'   => $request->input('name'),
            'email'  => $request->input('email'),
            'ip'     => $request->ip(),
            'status' => self::STATUS_ACTIVE,
            'user_id'=> Auth::id(),
            
        ];
    }

        public function updateNewsLetterInfo(UpdateNewsLetterRequest $request, NewsLetter $newsLetter)
    {
        $updateNewsLetterInfoData = [
            'name'   => $request->input('name') ?? $newsLetter->name,
            'email'  => $request->input('email') ?? $newsLetter->email,
            'ip'     => $request->ip(),
            'status' =>self::STATUS_ACTIVE,
            'user_id'=> Auth::id(),
        ];
        $newsLetter->update($updateNewsLetterInfoData);

        return $newsLetter;
    }
    
        public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return MorphMany
     */
    final public function activity_logs():MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }

}
