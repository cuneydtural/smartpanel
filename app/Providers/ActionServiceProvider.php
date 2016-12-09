<?php

namespace App\Providers;

use App\Article;
use App\Category;
use App\Observers\ArticleObserver;
use App\Observers\CategoryObserver;
use Illuminate\Support\ServiceProvider;
use App\Observers\UserObserver;
use App\Observers\SettingObserver;
use App\Observers\RoleObserver;
use App\Setting;
use App\User;

class ActionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Setting::observe(SettingObserver::class);
        Category::observe(CategoryObserver::class);
        Article::observe(ArticleObserver::class);
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
