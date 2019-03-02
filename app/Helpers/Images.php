<?php

namespace App\Helpers;

use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use App\Models\Gambar as tbImages;
use File;

class Images {
    
    public static function upload($file, $title = null, $description = null)
    {
        $path = public_path(env('RESOURCE_IMAGES_PATH', 'assets/images/'));
        $dimensions = explode('|', env('RESOURCE_IMAGES_DIMENSIONS', '1280x720|800x600'));

        $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        self::checkPath($path);
        self::checkPath($path . '/' . 'original');

        Image::make($file)->save($path . '/' . 'original' . '/' . $fileName);

        $saveDB = tbImages::create([
            'path' => $fileName,
            'judul' => $title === null ? $fileName : $title,
            'deskripsi' => $description
        ]);

        foreach ($dimensions as $row) {
            $row = explode('x', $row);
            $canvas = Image::canvas($row[0], $row[1]);
            $resizeImage  = Image::make($file)->resize($row[0], $row[1], function($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            $canvas->insert($resizeImage, 'center');
            self::checkPath($path . '/' . $row[0] . 'x' . $row[1]);
            $canvas->save($path . '/' . $row[0] . 'x' . $row[1] . '/' . $fileName);
        }

        return (object) [
            'nama'  => $fileName,
            'id'    => $saveDB->id,
            'judul' => $saveDB->title,
            'deskripsi' => $description,
        ];
    }

    public static function checkPath($path)
    {
        if (!File::isDirectory($path)) {
            return File::makeDirectory($path, 0775, true);
        }
    }
}