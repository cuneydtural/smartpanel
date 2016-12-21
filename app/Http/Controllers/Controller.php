<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $locale;
    protected $shoppingCartId;
    protected $random;
    
    public function __construct()
    {
        $this->locale = config('app.locale');
        //$this->random = md5(rand().'_'.date('YmdHis'));

        // Cookie İşlemleri yapılabilir.
        //$this->shoppingCartId = $this->random;
    }
}

