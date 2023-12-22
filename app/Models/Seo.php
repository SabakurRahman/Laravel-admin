<?php

namespace App\Models;

use App\Manager\Utility;
use Spatie\Permission\Guard;
use App\Manager\ImageUploadManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seo extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const Seo_PHOTO_UPLOAD_PATH = 'uploads/seo/';
    public const SEO_PHOTO_WIDTH = 600;
    public const SEO_PHOTO_HEIGHT = 600;

    final public function prepareSeoData($request ,Seo|null $seo=null)
    {
        return [
            'title' => $request->meta_title,
            'title_bn' => $request->meta_title_bn,
            'keywords' => $request->meta_keywords,
            'keywords_bn' => $request->meta_keywords_bn,
            'description' => $request->meta_description,
            'description_bn' => $request->meta_description_bn,
            'og_image' => !empty($request->og_image) || !empty($request->cover_photo) || !empty($request->photo) ? (new ImageUploadManager)->file($request->og_image ?? $request->cover_photo ?? $request->photo)
            ->name(Utility::prepare_name('meta' . $request->meta_title))
            ->path(self::Seo_PHOTO_UPLOAD_PATH)
            ->height(self::SEO_PHOTO_WIDTH)
            ->width(self::SEO_PHOTO_HEIGHT)
            ->upload() :null,
        ];

    }


    public function updateSeoData($request, Seo $seo)
    {
        $seo_data = [
            'title' =>  $request->meta_title ?? $seo->title ,
            'title_bn' => $request->meta_title_bn ?? $seo->title_bn,
            'keywords' => $request->meta_keywords ?? $seo->keywords,
            'keywords_bn' => $request->meta_keywords_bn ?? $seo->keywords_bn,
            'description' => $request->meta_description ?? $seo->description,
            'description_bn' => $request->meta_description_bn ?? $seo->description_bn,

        ];



        $og_image = $seo->og_image;

        if ($request->hasFile('og_image')) {
            if ($og_image) {
                ImageUploadManager::deletePhoto(self::Seo_PHOTO_UPLOAD_PATH, $seo->og_image);
            }
            $og_image = (new ImageUploadManager)->file($request->og_image)
                ->name(Utility::prepare_name('meta' . $request->meta_title))
                ->path(self::Seo_PHOTO_UPLOAD_PATH)
                ->height(self::SEO_PHOTO_WIDTH)
                ->width(self::SEO_PHOTO_HEIGHT)
                ->upload();

        }
        $seo_data['og_image'] =  $og_image;

        return $seo_data;

    }


    final public function updateSeo($request, Seo $seo)
    {

        $seo_data = $this->updateSeoData($request, $seo);
        return  $seo_data;
    }


    public function seoable()
    {
        return $this->morphTo();
    }


}
