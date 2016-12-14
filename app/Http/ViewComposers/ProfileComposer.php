<?php

namespace App\Http\ViewComposers;
use App\User;
use Cartalyst\Sentinel\Sentinel;
use Illuminate\View\View;

class ProfileComposer
{
    protected $profile;

    /**
     * ProfileComposer constructor.
     * @param Sentinel $sentinel
     */
    public function __construct(Sentinel $sentinel)
    {
        $this->profile = User::with(['actions'=>function($query) {
            return $query->take(9)->orderBy('id', 'desc');
        }])->findorFail($sentinel->getUser()->id);
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('profile', $this->profile);
    }
}