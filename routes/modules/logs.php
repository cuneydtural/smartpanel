<?php

Route::get('admin/logs/worker', ['as' => 'logs.worker',
    'uses' => 'LogController@worker']);

Route::get('admin/logs/laravel', ['as' => 'logs.laravel',
    'uses' => 'LogController@laravel']);

Route::get('admin/logs/delete', ['as' => 'logs.delete',
    'uses' => 'LogController@deleteLog']);