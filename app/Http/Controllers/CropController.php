<?php

namespace App\Http\Controllers;

use App\File as Files;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Image;
use Illuminate\Support\Facades\Validator;
use File;

class CropController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function postUpload(Request $request)
    {
        $title = str_slug($request->title);

        $rules = array('img' => 'required|mimes:png,gif,jpeg,jpg');
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Yüklemek istediğiniz dosya formatı desteklenmiyor!',
            ], 200);
        }

        if ($request->hasFile('img')) {

            $photo = $request->file('img');
            $extension = $photo->getClientOriginalExtension();
            $temp = public_path('photos/crop/temp');
            $filename = $title.'-'.date('dmyh') . '.' . $extension;

            $image = Image::make($photo);
            $image->save($temp . '/' . $filename);

            return response()->json([
                'status' => 'success',
                'url' => '/photos/crop/temp/'.$filename,
                'width' => $image->width(),
                'height' => $image->height(),
            ], 200);

        }
    }

    public function postCrop(Request $request)
    {
        
        if ($request->has('imgUrl')) {

            $image_url = $request->imgUrl;
            $imgW = $request->imgW;
            $imgH = $request->imgH;
            $imgY1 = $request->imgY1;
            $imgX1 = $request->imgX1;
            $cropW = round($request->cropW);
            $cropH = round($request->cropH);
            $angle = $request->rotation;

            $destination_path = public_path('photos/crop/');
            $filename_array = explode('/', $image_url);
            $filename = $filename_array[sizeof($filename_array) - 1];

            $image = Image::make(public_path($image_url));
            $image->resize($imgW, $imgH)->rotate($angle)->crop($cropW, $cropH, $imgX1, $imgY1);
            $image->save($destination_path . $filename);
        }

        if ($image->save()) {

            $file_path = 'photos/crop/'.$filename;

            // Temp'i boşalt
            File::cleanDirectory('photos/crop/temp');

            // Veritabanına kaydet.
            Files::create([
                'name' => $filename,
                'mime' => File::mimeType($file_path),
                'extension' => File::extension($file_path),
                'size' => File::size($file_path),
                'path' => 'photos/crop/',
                'source_type' => 'users'
            ]);

            return response()->json([
                'status' => 'success',
                'url' => url($file_path)
            ], 200);

        } else {

            return response()->json([
                'status' => 'error',
                'message' => 'Crop işlemi sırasında hata oluştu!',
            ], 200);

        }

    }

}
