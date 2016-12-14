<?php

namespace App\Http\ViewComposers;

use App\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class SettingsComposer
{
    protected $settings;

    /**
     * SettingsComposer constructor.
     */
    public function __construct()
    {
        if (Schema::hasTable('settings')) {
            $this->settings = Cache::remember('settings', 10, function () {
                return Setting::where('locale', config('app.locale'))->first();
            });
        }
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        if($this->settings) {
            $view->with('settings', $this->settings);
        }
    }
}