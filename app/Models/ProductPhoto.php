<?php

namespace App\Models;

use Carbon\Carbon;
use App\Manager\Utility;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Manager\ImageUploadManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductPhoto extends Model
{
    use HasFactory;
    protected $guarded = [];

    public const PHOTO_UPLOAD_PATH = 'uploads/product';
    public const PHOTO_UPLOAD_PATH_THUMB = 'uploads/product_thumb/thumb/';
    public const PHOTO_WIDTH = 1000;
    public const PHOTO_HEIGHT = 1000;
    public const PHOTO_WIDTH_THUMB = 800;
    public const PHOTO_HEIGHT_THUMB = 800;


    final public function processImageUpload(Request $request, Product|Model $product): void
    {
         foreach ($request->photos as $photo) {
            // dd($photo);
            if ($photo && $photo['photo']) { 
                $this->storeProductPhoto($this->prepareProductPhotoData($photo, $product));
            }
        }
    }

        final public function storeProductPhoto(array $data): Builder|Model
    {
        return self::query()->create($data);
    }

    private function prepareProductPhotoData( $request, Product|Model $product)
    {
        return [
            'product_id'   => $product->id,
            'variation_id' => null,
            'title'        => $request['title'],
            'alt_text'     => $request['alt_text'],
            'serial'       => $request['serial'],
            'photo'        => (new ImageUploadManager)->file($request['photo'])
                    ->name(Utility::prepare_name($request['title']))
                    ->path(self::PHOTO_UPLOAD_PATH)
                    ->height(self::PHOTO_HEIGHT)
                    ->width(self::PHOTO_WIDTH)
                    ->upload(),
        ];
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}