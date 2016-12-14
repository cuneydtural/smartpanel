<?php

namespace App\Http\Controllers;

use App\DataTables\Scopes\SortScopeWithLocale;
use App\DataTables\SlidesDataTable;
use App\Setting;
use App\Slide;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SlideController extends Controller
{

    public $settings;

    /**
     * SlideController constructor.
     */
    public function __construct()
    {
        return $this->settings = Setting::where('locale', App::getLocale())->first();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.slides.index');
    }

    /**
     * @param SlidesDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function data(SlidesDataTable $dataTable)
    {
        return $dataTable->addScope(new SortScopeWithLocale)->render('admin.slides.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slides.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $slide = Slide::create([
            'title' => $request->input('title'),
            'desc' => $request->input('desc'),
            'photo' => '',
            'url' => $request->input('url'),
            'active' => $request->input('active'),
            'url_type' => $request->input('url_type'),
            'list_id' => 0,
            'locale' => App::getLocale()
        ]);

        if($request->hasFile('image')) {

            $image = UploadController::imageUpload($request, [
                'title' => $request->input('title'),
                'source_type' => 'slide',
                'size' => [$this->settings->slide_w, $this->settings->slide_h],
            ]);

            if (isset($image['url'])) {
                $slide->photo = $image['url'];
                $slide->save();
                $notify[] = ['message' => 'Fotoğraf yüklendi', 'alert' => 'success'];
            } else {
                $notify[] = ['message' => $image['error_message'], 'alert' => 'danger'];
            }
        }

        $notify[] = ['message' => 'Slide eklendi', 'alert' => 'success'];
        return redirect()->route('admin.slides.index')->withNotify($notify);

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
            return redirect()->route('admin.slides.index');
        }

        if($sort == 'sort') {
            if($request->has('arrayorder')) {
                $i=0;
                $array_order = $request->input('arrayorder');
                foreach($array_order as $slide_id) {
                    Slide::where("id", $slide_id)->update(['list_id' => $i]);
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
            return redirect()->route('admin.slides.index')->withNotify($notify);
        } else {
            return redirect()->route('admin.slides.index');
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
        $slide = Slide::findorFail($id);
        return view('admin.slides.create', compact('slide'));
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
        $slide = Slide::findorFail($id);
        $slide->update($request->all());

        if($request->hasFile('image')) {

            $image = UploadController::imageUpload($request, [
                'title' => $request->input('title'),
                'source_type' => 'slide',
                'size' => [$this->settings->slide_w, $this->settings->slide_h],
            ]);

            if (isset($image['url'])) {
                $slide->photo = $image['url'];
                $slide->save();
                $notify[] = ['message' => 'Fotoğraf yüklendi', 'alert' => 'success'];
            } else {
                $notify[] = ['message' => $image['error_message'], 'alert' => 'danger'];
            }
        }

        $notify[] = ['message' => 'Slide güncellendi', 'alert' => 'success'];
        return back()->withNotify($notify);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slide = Slide::findorFail($id);
        $slide->delete();

        $notify[] = ['message' => 'Slide başarıyla silindi.', 'alert' => 'success'];
        Session::flash('notify', $notify);

        return route('admin.slides.index');
    }

    public function multiple(Request $request) {

        $status = $request->input('status');
        $item_ids = $request->input('item_id');

        if($status && $item_ids) {

            parse_str($item_ids, $item_arr);
            $slides = Slide::find($item_arr['item']);

            switch ($status) {
                case 'passive':
                    $active = 0;
                    $notify = 'Slide pasif edilmiştir.';
                    break;
                case 'active':
                    $active = 1;
                    $notify = 'Slide aktif edilmiştir.';
                    break;
                case 'destroy':
                    $active = null;
                    $notify = 'Slide silinmiştir.';
            }

            foreach ($slides as $slide) {
                if (is_null($active)) {
                    $slide->delete();
                } else {
                    $slide->active = $active;
                    $slide->save();
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

    /**
     * @param Request $request
     * @return string
     */
    public function ajax(Request $request)
    {
        if ($request->ajax()) {
            $slide = Slide::findorFail($request->input('slide_id'));
            $slide->photo = $request->input('file_name');
            $slide->save();
            return ($slide) ? 'success' : 'error';
        } else {
            return 'error';
        }
    }
}
