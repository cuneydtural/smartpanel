<?php

namespace App\Providers;

use App\Http\ViewComposers\NavComposer;
use App\Http\ViewComposers\ProfileComposer;
use Illuminate\Support\ServiceProvider;
use App\Http\ViewComposers\TwitterComposer;
use App\Http\ViewComposers\SettingsComposer;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        // Settings
        view()->composer('*', SettingsComposer::class);

        // Back-end
        view()->composer(['admin.includes.header', 'admin.includes.sidebar'], ProfileComposer::class);

        // Front-end
        //view()->composer(['frontend.includes.header', 'frontend.includes.footer'], NavComposer::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
