<?php
/**
 * Created by PhpStorm.
 * User: cuneydtural
 * Date: 28/08/16
 * Time: 03:38
 */

namespace App\Observers;

use Cartalyst\Sentinel\Sentinel;

class Observer
{

    protected $profile;

    public function __construct(Sentinel $sentinel)
    {
        $this->profile = $sentinel->getUser();
    }

}