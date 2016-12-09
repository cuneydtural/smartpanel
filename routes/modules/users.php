<?php

Route::any('admin/users/data', ['as' => 'users.data',
    'uses' => 'UserController@data']);

Route::resource('admin/users', 'UserController');

Route::post('admin/users/multiple', ['as' => 'users.multiple',
    'uses' => 'UserController@multiple']);
