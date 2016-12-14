<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Http\Request;
use Image;

class UploadController extends Controller
{
    public static $image_extensions = ['jpg', 'jpeg', 'png', 'gif', 'svg'];

    /**
     * @param $request
     * @param $options
     * @return mixed
     */
    public static function imageUpload($request, $options = null)
    {

        if (!$request->hasFile('image')) {
            return ['error_message' => 'Dosya yüklenemedi!'];
        }

        // Fotoğraf Değişkenleri
        $file_extension = $request->file('image')->extension();
        $original_name = explode(".", $request->file('image')->getClientOriginalName());
        $path = (isset($options['folder'])) ? 'photos/' . $options['folder'] . '/' : 'photos/';
        $thumb_path = (isset($options['folder'])) ? 'photos/thumbs/' . $options['folder'] . '/' : 'photos/thumbs/';
        $title = (isset($options['title'])) ? str_slug($options['title']) : str_slug($original_name[0]);
        $file_name = $title . '-' . uniqid() . '.' . $file_extension;

        if (in_array($file_extension, self::$image_extensions)) {

            $image = Image::make($request->file('image'));
            
            if (!empty($options['size'])) {
                $image->fit($options['size'][0], $options['size'][1]);
            }

            $image->save(public_path($path . $file_name));

            //Thumb
            $thumb_image = Image::make(public_path($path . $file_name));
            $thumb_image->resize(250, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $thumb_image->save(public_path($thumb_path . $file_name));

            File::create([
                'name' => $file_name,
                'mime' => $request->file('image')->getMimeType(),
                'extension' => $file_extension,
                'size' => $request->file('image')->getSize(),
                'path' => $path,
                'thumb_path' => $thumb_path,
                'source_type' => isset($options['source_type']) ? $options['source_type'] : '',
            ]);

            return ['url' => $file_name];

        } else {
            return ['error_message' => 'Yasaklı dosya uzantısı gönderdiniz!'];
        }
    }

    public static function multipleImageUpload($request, $options = null)
    {
        foreach($request->file('image') as $image) {

            // Fotoğraf Değişkenleri
            $file_extension = $image->extension();
            $original_name = explode(".", $image->getClientOriginalName());
            $path = (isset($options['folder'])) ? 'photos/' . $options['folder'] . '/' : 'photos/';
            $thumb_path = (isset($options['folder'])) ? 'photos/thumbs/' . $options['folder'] . '/' : 'photos/thumbs/';
            $title = (isset($options['title'])) ? str_slug($options['title']) : str_slug($original_name[0]);
            $file_name = $title . '-' . uniqid() . '.' . $file_extension;

            // İzin verilen dosya uzantıları kontrolü
            if (in_array($file_extension, self::$image_extensions)) {

                $original = Image::make($image);

               if (!empty($options['size'])) {
                    $original->fit($options['size'][0], $options['size'][1], function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }

                $original->save(public_path($path . $file_name));

                //Thumb kaydet
                $thumb = Image::make($image);
                $thumb->fit(340, 245, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $thumb->save(public_path($thumb_path . $file_name));

                // Files tablosuna kaydediyoruz.
                $file = File::create([
                    'name' => $file_name,
                    'mime' => $image->getMimeType(),
                    'extension' => $file_extension,
                    'size' => $image->getSize(),
                    'path' => $path,
                    'thumb_path' => $thumb_path,
                    'source_type' => isset($options['source_type']) ? $options['source_type'] : '',
                ]);

                // file_id'leri dizi olarak attach için gönderiyoruz.
                $data[] =  $file->id;
            }
        }
        //foreach end
        return $data;
    }

}
