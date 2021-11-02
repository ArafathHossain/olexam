<?php

namespace App\Helper;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

/**
 * 
 *Photo Upload Trait
 */
trait PhotoUploadTrait
{
    public function UploadOne($uploadfile, $path, array $size, $name = '', $old = '', $optimization = 80)
    {
        $name = empty($name) ? Str::random(10) . '_' . time() : $name;
        $photo_name = $name  . '.' . $uploadfile->getClientOriginalExtension();
        $path_name = public_path() . DIRECTORY_SEPARATOR . $path;
        if (!File::isDirectory($path_name)) {
            File::makeDirectory($path_name, 0777, true, true);
        }
        if (!empty($old) && File::exists($old)) {
            File::delete($old);
        }
        if (!empty($size)) {
            Image::make($uploadfile)->resize($size[0], $size[1])->save($path_name . DIRECTORY_SEPARATOR . $photo_name, $optimization);
        } else {
            Image::make($uploadfile)->save($path_name . DIRECTORY_SEPARATOR . $photo_name, $optimization);
        }
        return $path . '/' . $photo_name;
    }
    public function Upload64Bit($uploadfile, $path, array $size, $name = '')
    {
        $name = empty($name) ? Str::random(10) . '_' . time() : $name;

        $ext = explode('/', explode(':', substr($uploadfile, 0, strpos($uploadfile, ';')))[1])[1];
        $photo_name = $name  . '.' . $ext;

        $path_name = public_path() . DIRECTORY_SEPARATOR . $path;
        if (!File::isDirectory($path_name)) {
            File::makeDirectory($path_name, 0777, true, true);
        }
        if (!empty($size)) {
            Image::make($uploadfile)->resize($size[0], $size[1])->save($path_name . DIRECTORY_SEPARATOR . $photo_name, 80);
        } else {
            Image::make($uploadfile)->save($path_name . DIRECTORY_SEPARATOR . $photo_name, 80);
        }
        return $path . '/' . $photo_name;
    }

    public function VideoUpload($uploadfile, $path, $name = '')
    {
        $name = empty($name) ? Str::random(10) . '_' . time() : $name;
        $path_name = public_path() . DIRECTORY_SEPARATOR . $path;
        if (!File::isDirectory($path_name)) {
            File::makeDirectory($path_name, 0777, true, true);
        }
        $video_name =  $name . '.' . $uploadfile->getClientOriginalExtension();
        $uploadfile->move($path_name . DIRECTORY_SEPARATOR, $video_name);
        return $path . '/' . $video_name;
    }
}
