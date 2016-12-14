<?php

Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect' ]], function() {

    // Client/Frontend Routes
    require base_path('routes/frontend.php');

    // Authenticate
    require base_path('routes/modules/auth.php');
});


// Back-end Routes

Route::group(['middleware' => ['sentinel.auth', 'hasAccess', 'localeSessionRedirect', 'localizationRedirect' ],
    'prefix' => LaravelLocalization::setLocale(), 'as' => 'admin.'], function () {

    // Forbidden
    Route::get('admin/forbidden', ['as' => 'errors.forbidden',
        'uses' => 'Auth\SessionController@forbidden']);

    // Git Update
    Route::get('admin/git-update', ['as' => 'git.update',
        'uses' => 'GitController@update']);

    // Logs
    require base_path('routes/modules/logs.php');

    // Dashboard (Index/Google Analytics)
    require base_path('routes/modules/dashboard.php');
    
    // Settings
    require base_path('routes/modules/settings.php');

    // Users
    require base_path('routes/modules/users.php');

    // Roles
    require base_path('routes/modules/roles.php');

    // Photo Library
    require base_path('routes/modules/photo_library.php');

    // Category
    require base_path('routes/modules/categories.php');

    // Slides
    require base_path('routes/modules/slides.php');

    // Articles
    require base_path('routes/modules/articles.php');

    // Forms
    require base_path('routes/modules/forms.php');

    // Stores
    require base_path('routes/modules/stores.php');

    // Subscribers
    require base_path('routes/modules/subscribers.php');

    // Report
    require base_path('routes/modules/reports.php');

    // Products
    require base_path('routes/modules/products.php');

    // Campaigns
    require base_path('routes/modules/campaigns.php');

});

