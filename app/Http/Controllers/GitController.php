<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Collective\Remote\RemoteFacade as SSH;

class GitController extends Controller
{
    public function update() {

        SSH::run(array(
            'cd /var/www/laravel',
            'git fetch origin',
            'git reset --hard origin/master',
            'php artisan migrate'
        ));

        $notify[] = ['message' => 'Git güncellemeleri tamamlandı.', 'alert' => 'success'];

        return redirect()->route('admin.dashboard.index')->withNotify($notify);
    }
}
