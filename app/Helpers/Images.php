<?php

namespace App\Helpers;

use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use App\Models\Gambar as tbImages;
use File;

class Images {
    private static $errors;
    
    public static function upload($file, $title = null, $description = null, $dimension = null, $mergeDimension = false)
    {
        $path = public_path(env('RESOURCE_IMAGES_PATH', 'assets/images/'));
        $dimensions = env('RESOURCE_IMAGES_DIMENSIONS', '1280x720|800x600');

        if ($dimension !== null and $mergeDimension == false) $dimensions = $dimension;
        if ($dimension !== null and $mergeDimension == true) 
        {
            $dimensions = explode('|', $dimensions);
            $dimension = explode('|', $dimension);
            $dimensions = implode('|', $dimensions);
            $dimension = implode('|', $dimension);
            $dimensions = $dimension . '|' . $dimensions;
        }

        $dimensions = explode('|', $dimensions);

        dd($dimensions);

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