<?php

namespace App\Manager;

use http\Client\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ImageUploadManagerForVariation
{
    public const DEFAULT_IMAGE = 'images/default.webp';
    public const SUPPORTED_IMAGE_TYPE = ['jpg', 'png', 'jpeg', 'webp'];
    public const SUPPORTED_PDF_TYPE = ['pdf'];
    public const SUPPORTED_DOC_TYPE = ['xls', 'csv', 'xlsx'];
    public const FILE_TYPE_IMAGE = 'image';
    public const FILE_TYPE_PDF = 'pdf';
    public const FILE_TYPE_DOC = 'doc';

    /**
     * @param string $name
     * @param int $width
     * @param int $height
     * @param string $path
     * @param string $file
     * @return string
     */
    final public static function uploadImage(string $name, int $width, int $height, string $path, string $file): string
    {
        $image_file_name = $name . '.webp';
        Image::make($file)->fit($width, $height)->save(public_path($path) . $image_file_name, 50, 'webp');
        return $image_file_name;
    }

    final public static function uploadFile(UploadedFile $file, string $name, string $path, string|null $previous_file): string
    {
        $extension = self::getFileExtension($file);
        $name      .= '.' . $extension;
        $file->move(public_path($path), $name);
        if (!empty($previous_file)){
            self::deletePhoto($path, $previous_file);
        }
        return $name;
    }

    /**
     * @param string $path
     * @param string|null $img
     * @return void
     */
    final public static function deletePhoto(string $path, string|null $img): void
    {
        $path = public_path($path) . $img;
        if (!empty($img) && file_exists($path)) {
            unlink($path);
        }
    }

    /**
     * @param string $path
     * @param string|null $image
     * @return string
     */
    final public static function prepareImageUrl(string $path, string|null $image): string
    {
        $url = url($path . $image);
        if (empty($image) || !File::exists(public_path($path . $image))) {
            $url = url(self::DEFAULT_IMAGE);
        }
        return $url;
    }


    public static function processImageUpload(
        string      $file,
        string      $name,
        string      $path,
        int         $width,
        int         $height,
        string      $path_thumb = null,
        int         $width_thumb = 0,
        int         $height_thumb = 0,
        string|null $existing_photo = ''
    ): string
    {
        if (!empty($existing_photo)) {
            self::deletePhoto($path, $existing_photo);
            if (!empty($path_thumb)) {
                self::deletePhoto($path_thumb, $existing_photo);
            }
        }
        self::createDirectory($path);
        $photo_name = self::uploadImage($name, $width, $height, $path, $file);
        if (!empty($path_thumb)) {
            self::createDirectory($path_thumb);
            self::uploadImage($name, $width_thumb, $height_thumb, $path_thumb, $file);
        }
        return $photo_name;
    }

    public static function createDirectory(string $path): void
    {
        $path = public_path($path);
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
    }

    public static function getImageHeightWidth()
    {

    }

    /**
     * @param UploadedFile|string $file
     * @param bool $is_file
     * @return string
     */
    public static function getFileExtension(UploadedFile|string $file, bool $is_file = true): string
    {
        $extension = '';
        if ($is_file) {
            $extension = $file->getClientOriginalExtension();
        } else {
            $extension = explode('.', $file);
            $extension = array_pop($extension);
        }
        return $extension;
    }

    /**
     * @param UploadedFile|string $file
     * @param string $extension
     * @return string
     */
    public static function getFileType(UploadedFile|string $file, string $extension = ''): string
    {
        if (empty($extension) && !is_string($file)) {
            $extension = self::getFileExtension($file);
        }
        $file_type = '';
        if (in_array($extension, self::SUPPORTED_IMAGE_TYPE, false)) {
            $file_type = self::FILE_TYPE_IMAGE;
        } elseif (in_array($extension, self::SUPPORTED_PDF_TYPE, false)) {
            $file_type = self::FILE_TYPE_PDF;
        } elseif (in_array($extension, self::SUPPORTED_DOC_TYPE, false)) {
            $file_type = self::FILE_TYPE_DOC;
        }
        return $file_type;
    }

}