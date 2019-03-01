<?php

namespace App\Helpers;

use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use App\Models\Gambar as tbImages;

class Images {
    
    public static function upload($file, $title = null, $description = null)
    {
        $path = public_path(env('RESOURCE_IMAGES_PATH', 'assets/images/'));
        $dimensions = explode(',', env('RESOURCE_IMAGES_DIMENSIONS', '245,300,500'));

        $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        Image::make($file)->save($path . '/' . 'original' . '/' . $fileName);

        $saveDB = tbImages::create([
            'path' => $fileName,
            'judul' => $title === null ? $fileName : $title,
            'deskripsi' => $description
        ]);

        foreach ($dimensions as $row) {
            $canvas = Image::canvas($row, $row);
            $resizeImage  = Image::make($file)->resize($row, null, function($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            $canvas->insert($resizeImage, 'center');
            $canvas->save($path . '/' . $row . '/' . $fileName);

            return (object) [
                'nama'  => $fileName,
                'id'    => $saveDB->id,
                'judul' => $saveDB->title,
                'deskripsi' => $description,
            ];
        }
    }
}