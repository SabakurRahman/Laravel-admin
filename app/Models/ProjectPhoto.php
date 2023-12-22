<?php

namespace App\Models;

use App\Manager\Utility;
use App\Models\OurProjects;
use Illuminate\Http\Request;
use App\Manager\ImageUploadManager;
use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectPhoto extends Model
{
    use HasFactory;

    protected $guarded = [];


    public const PHOTO_UPLOAD_PATH = 'uploads/project_photo';
    public const PHOTO_WIDTH = 600;
    public const PHOTO_HEIGHT = 600;

    public const primary = 1;
    public const secondary = 0;

    public const STATUS_LIST = [
        self::primary => 'Primary',
        self::secondary => 'Secondary',
    ];



    final public function uploadProjectPhoto($photo, $name)
    {

    }

    final public function deletePhoto($photo)
    {
        ImageUploadManager::deletePhoto(self::PHOTO_UPLOAD_PATH, $photo);
    }

    final public function storeProject_photos($photo, $name)
    {
        return (new ImageUploadManager)->file($photo)
        ->name(Utility::prepare_name('ProjectPhoto' . $name))
        ->path(self::PHOTO_UPLOAD_PATH)
        ->height(self::PHOTO_WIDTH)
        ->width(self::PHOTO_HEIGHT)
        ->upload();
    }

  final public function store_photo(array $data){
    return self::query()->create($data);
  }

  public function prepare_photo_data($request){
    $data = [
      'our_project_id' => $request->our_project_id,
      'title'          => $request->title,
      'serial'         => $request->serial,
      'is_primary'     => $request->is_primary
    ];
    return $data;
  }


  final public function delete_photo($id){
    return self::where('id', $id)->delete();
  }


 final public function updateprimarydata(ProjectPhoto $projectPhoto, $data){
  return $projectPhoto->update($data);
 }

  final public function updateprimary(ProjectPhoto $projectPhoto, $data){
    return $projectPhoto->update($data);
  }

  final public function updateProjectPhoto(array $data,$id){
    return self::query()->findOrFail($id)?->update($data);
  }

// *************************
  final public function processImageUpload(Request $request, OurProjects|Model $ourProject): void
    {

         foreach ($request->photos as $photo) {
            // dd($photo);
            if ($photo && $photo['photo']) {
                $this->storeOurProjectPhoto($this->prepareOurProjectPhotoData($photo, $ourProject));
            }
        }
    }

        final public function storeOurProjectPhoto(array $data): Builder|Model
    {
        return self::query()->create($data);
    }

    private function prepareOurProjectPhotoData( $request, OurProjects|Model $ourProject)

    {

        return [
            'our_project_id'=> $ourProject->id,
            'variation_id'  => null,
            'title'         => $request['title'],
            // 'alt_text'     => $request['alt_text'],
            'serial'        => $request['serial'],
            'is_primary'    => $request['is_primary'],
            'photo'         => (new ImageUploadManager)->file($request['photo'])
                    ->name(Utility::prepare_name($request['title']))
                    ->path(self::PHOTO_UPLOAD_PATH)
                    ->height(self::PHOTO_HEIGHT)
                    ->width(self::PHOTO_WIDTH)
                    ->upload(),

        ];
    }

    public function ourProject()
    {
        return $this->belongsTo(OurProjects::class);
    }

}
