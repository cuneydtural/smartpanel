<?php

namespace App\Http\Controllers;

use App\Form;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator;

class ReportController extends Controller
{

    public $start;
    public $end;
    public $type;
    public $title;

    public function query(Request $request) {

        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'days' => 'required|integer',
        ]);

        if (!$validator->fails()) {

            $this->start = Carbon::now()->subDays($request->input('days'));
            $this->end = Carbon::now();
            $this->type = $request->input('type');
            $this->title = Form::getFormType($this->type);

            $result = Form::whereBetween('created_at', [$this->start, $this->end])
                ->where('type', $this->type)->get()->count();

            $notify[] = ['message' => 'Sorgulama tamamlandı!', 'alert' => 'success'];
            return view('admin.reports.index', compact('result'))->withNotify($notify)->withTitle($this->title);

        } else {

            $notify[] = ['message' => 'Sorgulama yapılamadı. Eksik seçim yaptınız!', 'alert' => 'error'];
            return redirect()->route('admin.reports.index')->withNotify($notify);
        }

    }

    public function index() {
        return view('admin.reports.index');
    }
}
