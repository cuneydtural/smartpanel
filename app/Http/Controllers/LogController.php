<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

use App\Http\Requests;

class LogController extends Controller
{
    public function worker() {
        $title = 'Queue Worker Process';
        $logs = Storage::disk('logs')->get('worker.log');
        return view('admin.logs.index', compact('logs', 'title'));
    }

    public function laravel() {
        $title = 'Laravel Logları';
        $logs = Storage::disk('logs')->get('laravel.log');
        return view('admin.logs.index', compact('logs', 'title'));
    }

    public function deleteLog() {

        Storage::disk('logs')->delete(['laravel.log', 'worker.log']);
        Storage::disk('logs')->put('laravel.log', '*');
        Storage::disk('logs')->put('worker.log', '*');

        $notify[] = ['message' => 'Log kayıtları temizlendi.', 'alert' => 'success'];
        return back()->withNotify($notify);
    }

}
