<?php

namespace App\Models;


use App\Models\Tag;
use App\Models\ProjectPhoto;
use Illuminate\Http\Request;
use App\Models\ProjectCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Requests\StoreOurProjectRequest;
use App\Http\Requests\UpdateOurProjectRequest;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OurProject extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const STATUS_ACTIVE   = 1;
    public const STATUS_INACTIVE = 0;

    public const STATUS_LIST  = [
        self::STATUS_ACTIVE   => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];
    public const TYPE_OFFICE = 1;
    public const TYPE_HOME   = 2;

    public const TYPE_LIST = [
        self::TYPE_OFFICE  => 'Office Interior',
        self::TYPE_HOME    => 'Home Interior',
    ];
    public const SHOW_ON_HOME_PAGE       = 1;
    public const NOT_SHOW_ON_HOME_PAGE  = 2;

    public const SHOW_ON_HOME_PAGE_LIST = [
        self::SHOW_ON_HOME_PAGE       => 'Yes',
        self::NOT_SHOW_ON_HOME_PAGE   => 'No',
    ];

      public function getOurProjectsList(Request $request)
    {
        // dd($request->all());
        $paginate  = $request->input('per_page') ?? 10;
        $query     = self::query()->with(['user']);
        if ($request->input('name')){
            $query->where('name', 'like', '%'.$request->input('name').'%');
        }
        if ($request->input('slug')){
            $query->where('slug', 'like', '%'.$request->input('slug').'%');
        }
        if ($request->input('client_name')){
            $query->where('client_name', 'like', '%'.$request->input('client_name').'%');
        }
        if ($request->input('project_location')){
            $query->where('project_location', 'like', '%'.$request->input('project_location').'%');
        }
        if ($request->input('status') !== null) {
            $query->where('status', $request->input('status'));
        }
        if ($request->input('total_area')){
            $query->where('total_area', $request->input('total_area'));
        }
        if ($request->input('type')){
            $query->where('type', $request->input('type'));
        }
        if ($request->input('is_show_on_home_page')){
            $query->where('is_show_on_home_page', $request->input('is_show_on_home_page'));
        }
        if ($request->input('sort_by') && $request->input('sort_direction')) {
            $query->orderBy($request->input('sort_by'), $request->input('sort_direction'));
        } else {
            $query->orderByDesc('id');
        }
        // dd($query);
        return $query->paginate($paginate);
    }

        public function createNewOurProject(StoreOurProjectRequest $request)
    {
        $ourproject=self::query()->create($this->prepareNewOurProjectData($request));
        $seoData = (new Seo)->prepareSeoData($request);
        $ourproject->seos()->create($seoData);

        return $ourproject;


    }
        private function prepareNewOurProjectData(StoreOurProjectRequest $request)
    {
        $data = [
            'name'                  => $request->input('name'),
            'slug'                  => $request->input('slug'),
            'project_description'   => $request->input('project_description'),
            'project_location'      => $request->input('project_location'),
            'total_area'            => $request->input('total_area'),
            'total_cost'            => $request->input('total_cost'),
            'client_name'           => $request->input('client_name'),
            'project_category_id'   => $request->input('project_category_id'),
            'type'                  => $request->input('type'),
            'total_area'            => $request->input('total_area'),
            'status'                => $request->input('status'),
            'is_show_on_home_page' => $request->input('is_show_on_home_page'),
            'user_id'               => Auth::id(),
        ];
        // if ($request->hasFile('photo')) {
        //     $photo = (new ImageUploadManager)->file($request->file('photo'))
        //         ->name(Utility::prepare_name($request->input('slug')))
        //         ->path(self::PHOTO_UPLOAD_PATH)
        //         ->height(self::PHOTO_HEIGHT)
        //         ->width(self::PHOTO_WIDTH)
        //         ->upload();

        //     $data['photo'] = $photo;
        // }
        return $data;
    }
        public function updateOurProjectInfo(UpdateOurProjectRequest $request, OurProject $ourProject)
    {
        $updateOurProjectInfoData = [
            'name'                  => $request->input('name') ?? $ourProject->name,
            'slug'                  => $request->input('slug')?? $ourProject->slug,
            'project_description'   => $request->input('project_description')?? $ourProject->project_description,
            'project_location'      => $request->input('project_location')?? $ourProject->project_location,
            'total_area'            => $request->input('total_area')?? $ourProject->total_area,
            'total_cost'            => $request->input('total_cost')?? $ourProject->total_cost,
            'client_name'           => $request->input('client_name')?? $ourProject->client_name,
            'project_category_id'   => $request->input('project_category_id')?? $ourProject->project_category_id,
            'type'                  => $request->input('type')?? $ourProject->type,
            'total_area'            => $request->input('total_area')?? $ourProject->total_area,
            'status'                => $request->input('status')?? $ourProject->status,
            'is_show_on_home_page'  => $request->input('is_show_on_home_page')?? $ourProject->is_show_on_home_page,
            'user_id'               => Auth::id()
        ];

         $ourProject->update($updateOurProjectInfoData);
        if ($ourProject->seos) {
            $seoData = (new Seo)->updateSeo($request, $ourProject->seos);
            $ourProject->seos()->update($seoData);
        } else {
            $seoData = (new Seo)->prepareSeoData($request);
            $ourProject->seos()->create($seoData);
        }

        return $ourProject;

    }



    

    final public function getOurProjectsbyCategory($request){
        $query = self::query();
        $category= ProjectCategory::where('slug',$request->slug)->first();

            $query->where('project_category_id', $category->id);

            return $query->orderBy('id', 'desc')->get();


    }


    final public function getOurProjectsBySlug($slug)
    {
        $query = self::query();
        $query->where('slug', $slug);
        return $query->with('photos_all')->first();
    }

    final public  function getRelatedProject($id,$slug)
    {
          return self::query()->where('project_category_id',$id)
              ->where('slug','!=',$slug)
              ->take(3)->get();
    }


//     final public function createOurProjects(array $data)
//     {
//         return self::create($data);
//     }

//     final public function updateOurProjects(array $data, OurProject $our_projects): bool
//     {
//         return $our_projects->update($data);
//     }

//    final public function deleteOurProjects($id)
//     {
//         return self::where('id', $id)->delete();
//     }


    final public function getOurProjectsById($id)
    {
        return self::where('id', $id)->first();
    }

    public function project_category()
    {
        return $this->belongsTo(ProjectCategory::class);
    }


    public function photos_all()
    {
        return $this->hasMany(ProjectPhoto::class, 'our_project_id');
    }

    public function primary_photo()
    {
        return $this->hasOne(ProjectPhoto::class, 'our_project_id')->where('is_primary', 1);
    }

    public function tags()
    {
       return $this->BelongsToMany(Tag::class, 'our_projects_tags', 'our_project_id', 'tag_id');

    }
    public function seos(){
        return $this->morphOne(Seo::class, 'seoable');
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



