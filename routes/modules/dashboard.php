<?php

Route::get('admin/', ['as' => 'dashboard.index',
    'uses' => 'DashboardController@index']);

Route::get('admin/dashboard/{day}', ['as' => 'dashboard.show',
    'uses' => 'DashboardController@show']);

