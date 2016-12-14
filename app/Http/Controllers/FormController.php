<?php

namespace App\Http\Controllers;

use App\DataTables\FormsDataTable;
use App\DataTables\Scopes\SortScope;
use App\Form;
use Illuminate\Http\Request;
use Session;
use App\Http\Requests;

class FormController extends Controller
{


    /**
     * @param FormsDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function data(FormsDataTable $dataTable)
    {
        return $dataTable->addScope(new SortScope)->render('admin.forms.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.forms.index');
    }
    
    /**
     * @param $sort
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function show($sort, Request $request)
    {
        $list = ['active', 'passive', 'all'];

        if (!in_array($sort, $list)) {
            return redirect()->route('admin.slides.index');
        }

        if($sort == 'sort') {
            if($request->has('arrayorder')) {
                $i=0;
                $array_order = $request->input('arrayorder');
                foreach($array_order as $form_id) {
                    Form::where("id", $form_id)->update(['list_id' => $i]);
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
            return redirect()->route('admin.forms.index')->withNotify($notify);
        } else {
            return redirect()->route('admin.forms.index');
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
        $form = Form::find($id);
        return view('admin.forms.edit', compact('form'));

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

        $form = Form::findorFail($id);
        $updated = $form->update($request->all());

        if(isset($updated)) {
            $notify[] = ['message' => 'Form güncellendi.', 'alert' => 'success'];
        }else {
            $notify[] = ['message' => 'Güncelle yapılamadı!', 'alert' => 'error'];
        }
        return redirect()->route('admin.forms.index')->withNotify($notify);
    }

    /**
     * @param $id
     * @return string
     */
    public function destroy($id)
    {
        $form = Form::findorFail($id);
        $form->delete();
        $notify[] = ['message' => 'Seçili öğe silindi.', 'alert' => 'success'];
        Session::flash('notify', $notify);
        return route('admin.forms.index');
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
            $forms = Form::find($item_arr['item']);

            switch ($status) {
                case 'passive':
                    $active = 0;
                    $notify = 'Seçili öğeler, cevaplanmadı olarak işaretlendi.';
                    break;
                case 'active':
                    $active = 1;
                    $notify = 'Seçili öğeler, cevaplandı olarak işaretlendi.';
                    break;
                case 'destroy':
                    $active = null;
                    $notify = 'Seçili öğeler silinmiştir.';
            }

            foreach ($forms as $form) {
                if (is_null($active)) {
                    $form->delete();
                } else {
                    $form->active = $active;
                    $form->save();
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
