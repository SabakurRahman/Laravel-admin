<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\StoreFaqPageRequest;
use App\Http\Requests\UpdateFaqPageRequest;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class FaqPage extends Model
{
    use HasFactory;
    protected $guarded = [];

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 2;

    public const STATUS_LIST = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];


    public function createFaqPages(StoreFaqPageRequest $request)
    {
        return self::query()->create($this->prepareFaqPagesData($request));
    }

    private function prepareFaqPagesData(StoreFaqPageRequest $request)
    {
        return[
            'name'   => $request->input('name'),
            'slug'   => $request->input('slug'),
            'status' => $request->input('status'),
            'serial' => $request->input('serial'),
            'user_id' => Auth::id()
        ];
    }

    public function updateFaqPages(UpdateFaqPageRequest $request, FaqPage $faqPage)
    {
        $updateFaqData = [
            'name'   => $request->input('name')   ?? $faqPage->name,
            'slug'   => $request->input('slug')   ?? $faqPage->slug,
            'status' => $request->input('status') ?? $faqPage->status,
            'serial' => $request->input('serial') ?? $faqPage->serial,
            'user_id' => Auth::id()
        ];

       $faqPage->update($updateFaqData);
       return $faqPage;

    }

    public function allFaqPageList(Request $request)
    {
        $paginate  = $request->input('per_page') ?? 10;
        $query = self::query();
        if ($request->input('name')){
            $query->where('name', 'like', '%'.$request->input('name').'%');
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



    public function faqPages()
    {
        return self::query()->pluck('name', 'id');
    }

    public function faqPagesDetails(Faq $faq)
    {
        return self::find($faq);
    }
        public function user()
    {
        return $this->belongsTo(User::class);
    }

    final public function activity_logs():MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }


}
