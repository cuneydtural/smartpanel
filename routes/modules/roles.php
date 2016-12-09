<?php

Route::any('admin/roles/data', ['as' => 'roles.data',
    'uses' => 'RoleController@data']);

Route::resource('admin/roles', 'RoleController');

Route::post('admin/roles/multiple', ['as' => 'roles.multiple',
    'uses' => 'RoleController@multiple']);