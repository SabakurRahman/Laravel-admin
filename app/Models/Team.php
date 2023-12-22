<?php

namespace App\Models;

use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Manager\ImageUploadManager;
use App\Manager\Utility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Request;

class Team extends Model
{
    use HasFactory;


    protected $guarded =[];

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 2;

    public const STATUS_LIST = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    public const PHOTO_UPLOAD_PATH = 'uploads/team/';
    public const PHOTO_UPLOAD_PATH_THUMB = 'uploads/team/thumb/';
    public const PHOTO_WIDTH = 600;
    public const PHOTO_HEIGHT = 600;
    public const PHOTO_WIDTH_THUMB = 150;
    public const PHOTO_HEIGHT_THUMB = 150;
    public function storeTeam(StoreTeamRequest $request)
    {
        return self::query()->create($this->prepareTeamData($request));
    }

    private function prepareTeamData(StoreTeamRequest $request)
    {
        return [
            'name'        =>$request->input('name'),
            'title'       => $request->input('title'),
            'description' => $request->input('description'),
            'status'      =>$request->input('status'),
            'photo'       => (new ImageUploadManager)->file($request->file('photo'))
                ->name(Utility::prepare_name($request->input('name')))
                ->path(self::PHOTO_UPLOAD_PATH)
                ->height(self::PHOTO_HEIGHT)
                ->width(self::PHOTO_WIDTH)
                ->upload(),

        ];
    }

    public function TeamList(Request $request )
    {
        $paginate  = $request->input('per_page') ?? 10;
        $query = self::query();
        if ($request->input('name')){
            $query->where('name', 'like', '%'.$request->input('name').'%');
        }
        if ($request->input('title')){
            $query->where('title', 'like', '%'.$request->input('title').'%');
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



    public function updateTeam(UpdateTeamRequest $request, Team $team)
    {
        $updateTeamData = [
            'name'   =>$request->input('name')  ?? $team->name,
            'title'   =>$request->input('title')  ?? $team->title,
            'description' =>$request->input('description')?? $team->description,
            'status'   =>$request->input('status')  ?? $team->status
        ];
        $photo=$team->photo;

        if($request->hasFile('photo'))
        {
            if($photo){
                ImageUploadManager::deletePhoto(self::PHOTO_UPLOAD_PATH, $team->photo);
            }

            $photo  = (new ImageUploadManager)->file($request->file('photo'))
                ->name(Utility::prepare_name($request->input('name')))
                ->path(self::PHOTO_UPLOAD_PATH)
                ->height(self::PHOTO_HEIGHT)
                ->width(self::PHOTO_WIDTH)
                ->upload();

        }
        $updateTeamData['photo'] = $photo;
         $team->update($updateTeamData);
         return $team;


    }

    public function getTeamData()
    {
        return self::query()->where('status',self::STATUS_ACTIVE)->get();
    }


    final public function activity_logs():MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }
}
