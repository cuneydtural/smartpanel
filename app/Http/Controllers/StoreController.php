<?php

namespace App\Http\Controllers;

use App\DataTables\Scopes\StoreScope;
use App\DataTables\StoresDataTable;
use App\District;
use App\Store;
use Illuminate\Http\Request;
use Response;
use App\Http\Requests;
use Session;
use App\Http\Requests\Admin\StoreRequest;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.stores.index');
    }


    /**
     * @param StoresDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function data(StoresDataTable $dataTable)
    {
        return $dataTable->addScope(new StoreScope)->render('admin.stores.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.stores.create');
    }


    /**
     * @param StoreRequest $request
     * @return mixed
     */
    public function store(StoreRequest $request)
    {
        $store = Store::create($request->all());
        if($store->save()) {
            $notify[] = ['message' => 'Şube kaydedildi.', 'alert' => 'success'];
            return redirect()->route('admin.stores.index')->withNotify($notify);
        }
    }


    /**
     * @param $sort
     * @param Request $request
     * @return mixed
     */
    public function show($sort, Request $request)
    {
        $list = ['sort', 1, 2, 3, 'all'];

        if (!in_array($sort, $list)) {
            return redirect()->route('admin.stores.index');
        }

        if($sort == 'sort') {
            if($request->has('arrayorder')) {
                $i=0;
                $array_order = $request->input('arrayorder');
                foreach($array_order as $store_id) {
                    Store::where("id", $store_id)->update(['list_id' => $i]);
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
            return redirect()->route('admin.stores.index')->withNotify($notify);
        } else {
            return redirect()->route('admin.stores.index');
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
        $store = Store::findorFail($id);
        return view('admin.stores.create', compact('store'));
    }


    /**
     * @param StoreRequest $request
     * @param $id
     * @return mixed
     */
    public function update(StoreRequest $request, $id)
    {
        $store = Store::find($id);
        $store->update($request->all());
        $notify[] = ['message' => 'Şube güncellendi.', 'alert' => 'success'];
        return back()->withNotify($notify);
    }

    /**
     * @param $id
     * @return string
     */
    public function destroy($id)
    {
        $store = Store::findorFail($id);
        $store->delete();
        $notify[] = ['message' => 'Seçili öğe silindi.', 'alert' => 'success'];
        Session::flash('notify', $notify);
        return route('admin.stores.index');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function multiple(Request $request) {

        $status = $request->input('status');
        $item_ids = $request->input('item_id');

        if($status && $item_ids) {

            parse_str($item_ids, $item_arr);
            $articles = Store::find($item_arr['item']);

            switch ($status) {
                case 'passive':
                    $active = 0;
                    $notify = 'Şube pasif edilmiştir.';
                    break;
                case 'active':
                    $active = 1;
                    $notify = 'Şube aktif edilmiştir.';
                    break;
                case 'destroy':
                    $active = null;
                    $notify = 'Şube silinmiştir.';
            }

            foreach ($articles as $article) {
                if (is_null($active)) {
                    $article->delete();
                } else {
                    $article->active = $active;
                    $article->save();
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
}
