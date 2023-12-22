<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\StoreWebContentRequest;
use App\Http\Requests\UpdateWebContentRequest;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebContent extends Model
{
    use HasFactory;
    protected $guarded = [];

    public const LOCATION_HOMEPAGE = 1;
    public const LOCATION_PRODUCT  = 2;

    public const LOCATION_LIST = [
        self::LOCATION_HOMEPAGE => 'Homepage',
        self::LOCATION_PRODUCT  => 'Product',
    ];


        public function getWebCOntentList(Request $request)
    {
        $paginate  = $request->input('per_page') ?? 10;
        // $query     = self::query();
        $query     = self::query()->with(['user']);
        if ($request->input('title')){
            $query->where('title', 'like', '%'.$request->input('title').'%');
        }
        if ($request->input('location')){
            $query->where('location', 'like', '%'.$request->input('location').'%');
        }
        if ($request->input('sort_by') && $request->input('sort_direction')) {
            $query->orderBy($request->input('sort_by'), $request->input('sort_direction'));
        } else {
            $query->orderByDesc('id');
        }
        return $query->paginate($paginate);
    }


        public function createNewWebContentInfo(StoreWebContentRequest $request)
    {
        return self::query()->create($this->prepareNewWebContentData($request));
    }

    private function prepareNewWebContentData(StoreWebContentRequest $request)
    {
        return [
            'title'     => $request->input('title'),
            'content'   => $request->input('content'),
            'location'  => $request->input('location'),
            'user_id'   => Auth::id(),

        ];
    }

        public function updateWebContentInfo(UpdateWebContentRequest $request, WebContent $webContent)
    {
        $updateWebContentInfoData = [

            'title'=> $request->input('title')?? $webContent->title,
            'content'     => $request->input('content')?? $webContent->content,
            'location'   => $request->input('location')?? $webContent->location,
            'user_id'    => Auth::id()

        ];
        $webContent->update($updateWebContentInfoData);

        return $webContent;


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
