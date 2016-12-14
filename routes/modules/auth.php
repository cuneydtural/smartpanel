<?php

Route::get('admin/login', ['as' => 'admin.login',
    'uses' => 'Auth\SessionController@getLogin']);

Route::post('admin/login', ['as' => 'admin.login',
    'uses' => 'Auth\SessionController@postLogin']);

Route::get('admin/logout', ['as' => 'admin.logout',
    'uses' => 'Auth\SessionController@getLogout']);