<?php

namespace App\Http\Controllers;

use App\DataTables\PhotoLibraryChooseDataTable;
use App\DataTables\PhotoLibraryDataTable;
use App\DataTables\Scopes\ChoosePhotoScope;
use App\DataTables\Scopes\SortScope;
use App\File as Files;
use Illuminate\Http\Request;
use Session;
use App\Http\Requests;
use File;

class PhotoLibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.photo_library.index');
    }


    /**
     * @param PhotoLibraryDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function data(PhotoLibraryDataTable $dataTable)
    {
        return $dataTable->addScope(new SortScope)->render('admin.photo_library.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.photo_library.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->hasFile('image')) {

            $image = UploadController::imageUpload($request, [
                'source_type' => 'photo.library'
            ]);

            if (isset($image['url'])) {
                return response()->json([
                    'status' => 'success',
                    'message' => '('.$image['url'].') fotoğraf yüklendi',
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Üzgünüz! İşlem yapılamadı',
                ]);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Üzgünüz! İşlem yapılamadı',
            ]);
        }
    }


    /**
     * @param $sort
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function show($sort, Request $request)
    {
        $list = ['sort', 'list', 'desc', 'active', 'passive', 'all'];

        if (!in_array($sort, $list)) {
            return redirect()->route('admin.photo-library.index');
        }

        if($sort == 'sort') {
            if($request->has('arrayorder')) {
                $i=0;
                $array_order = $request->input('arrayorder');
                foreach($array_order as $lib_id) {
                    Files::where("id", $lib_id)->update(['list_id' => $i]);
                    $i++;
                }
                return response()->json([
                    'status' => 'success',
                    'message' => 'Sıralama değiştirildi.'
                ]);
            }
        } elseif($sort) {
            Session::put('sort', $sort);
            $notify[] = ['message' => 'Filtreleme seçeneği değiştirildi', 'alert' => 'success'];
            return redirect()->route('admin.photo-library.index')->withNotify($notify);
        } else {
            return redirect()->route('admin.photo-library.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $file = Files::findorFail($id);

        $path = $file->path.$file->name;
        $thumb_path = $file->thumb_path.$file->name;
        $files = [$path, $thumb_path];

        File::delete($files);

        if(!File::exists($path)) {
            $file->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Dosya silindi',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Üzgünüz! İşlem yapılamadı',
            ]);
        }
    }

    public function multiple(Request $request)
    {
        $status = $request->input('status');
        $item_ids = $request->input('item_id');

        if($status && $item_ids) {

            parse_str($item_ids, $item_arr);
            $files = Files::find($item_arr['item']);
            $prefix = (count($files) > 1) ? 'Fotoğraflar' : 'Fotoğraf';

            switch ($status) {
                case 'passive':
                    $active = 0;
                    $notify = $prefix. ' pasif edilmiştir.';
                    break;
                case 'active':
                    $active = 1;
                    $notify = $prefix. ' aktif edilmiştir.';
                    break;
                case 'destroy':
                    $active = null;
                    $notify = $prefix. ' silinmiştir.';
            }

            foreach ($files as $file) {
                if (is_null($active)) {
                    // Diziye al
                    $delete_files = [$file->path.$file->name, $file->thumb_path.$file->name];
                    // Dosyaları sil
                    File::delete($delete_files);
                    // Files tablosundan kaldır
                    $file->delete();
                } else {
                    $file->active = $active;
                    $file->save();
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => $notify
            ]);

        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Üzgünüz! İşlem yapılamadı',
            ]);
        }
    }

    public function choose()
    {
        return view('admin.photo_library.choose');
    }


    /**
     * @param PhotoLibraryChooseDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function chooseData(PhotoLibraryChooseDataTable $dataTable)
    {
        return $dataTable->addScope(new ChoosePhotoScope)->render('admin.photo_library.choose');
    }
}
