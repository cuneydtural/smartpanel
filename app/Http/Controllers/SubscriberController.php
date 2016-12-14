<?php

namespace App\Http\Controllers;

use App\DataTables\Scopes\SortScope;
use App\DataTables\SubscriberDataTable;
use App\Helpers\Helper;
use App\Subscriber;
use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;

class SubscriberController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.subscribers.index');
    }

    public function data(SubscriberDataTable $dataTable)
    {
        return $dataTable->addScope(new SortScope)->render('admin.subscribers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.subscribers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:subscribers',
        ]);

        if ($validator->fails()) {
            $notify[] = ['message' => 'Abone ekleme sırasında hata oluştu.', 'alert' => 'error'];
        } else {
            $subscriber = Subscriber::create($request->all());
            $notify[] = ['message' => 'Abone kaydedildi.', 'alert' => 'success'];
        }

        return redirect()->route('admin.subscribers.index')->withNotify($notify);
    }


    /**
     * @param Request $request
     * @param $sort
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, $sort)
    {
        $list = ListController::sortList();

        if (!in_array($sort, $list)) {
            return redirect()->route('admin.subscribers.index');
        }

        if($sort == 'sort') {
            if($request->has('arrayorder')) {
                $i=0;
                $array_order = $request->input('arrayorder');
                foreach($array_order as $subscriber_id) {
                    Subscriber::where("id", $subscriber_id)->update(['list_id' => $i]);
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
            return redirect()->route('admin.subscribers.index')->withNotify($notify);
        } else {
            return redirect()->route('admin.subscribers.index');
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
        $subscriber = Subscriber::findOrFail($id);
        return view('admin.subscribers.create', compact('subscriber'));
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
        $subscriber = Subscriber::findorFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:subscribers,email,'.$id
        ]);

        if ($validator->fails()) {
            $notify[] = ['message' => 'Hata oluştu.', 'alert' => 'error'];
        } else {
            $subscriber->update($request->all());
            $notify[] = ['message' => 'Abone bilgileri güncellendi', 'alert' => 'success'];
        }

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
        $subscriber = Subscriber::findorFail($id);
        $subscriber->delete();

        $notify[] = [
            'message' => 'Abone silindi',
            'alert' => 'success'];

        Session::flash('notify', $notify);
        return route('admin.subscribers.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function multiple(Request $request) {

        $status = $request->input('status');
        $item_ids = $request->input('item_id');

        if($status && $item_ids) {

            parse_str($item_ids, $item_arr);
            $subscribers = Subscriber::find($item_arr['item']);

            switch ($status) {
                case 'passive':
                    $active = 0;
                    $notify = 'Abone pasif edilmiştir.';
                    break;
                case 'active':
                    $active = 1;
                    $notify = 'Abone aktif edilmiştir.';
                    break;
                case 'destroy':
                    $active = null;
                    $notify = 'Abone silinmiştir.';
            }

            foreach ($subscribers as $subscriber) {
                if (is_null($active)) {
                    $subscriber->delete();
                } else {
                    $subscribers->active = $active;
                    $subscriber->save();
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => $notify
            ]);

        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Üzgünüz! İşlem yapılamadı!',
            ]);
        }

    }
}
