<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    public const STATUS_LIST = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    final public function getTagList(Request $request)
    {
        $paginate  = $request->input('per_page') ?? 10;
        $query     = self::query()->with(['user']);
        // dd($query);
        if ($request->input('name')){
            $query->where('name', 'like', '%'.$request->input('name').'%');
        }
        if ($request->input('status') || $request ->input('status') == 0 ){
            $query->where('status', $request->input('status'));
        }
        if ($request->input('sort_by') && $request->input('sort_direction')) {
            $query->orderBy($request->input('sort_by'), $request->input('sort_direction'));
        } else {
            $query->orderByDesc('id');
        }
        return $query->paginate($paginate);
    }

    final public function prepareTagData(array $input, Tag|null $tag= null)
    {
        return [
            'name'   => $input['name'],
            'status' => $input['status'],
            'user_id'=> Auth::id(),
        ];
    }

    final public function createTag(array $data): Tag
    {
        return self::query()->create($data);
    }


    final public function updateTag(Tag $tag, array $data)
    {
        $tag->update($data);
        return $tag;
    }

    final public function deleteTag(): bool
    {
        return $this->delete();
    }


    public function our_project()
    {
        return $this->belongsToMany(OurProject::class, 'our_projects_tag', 'tag_id', 'our_project_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
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
