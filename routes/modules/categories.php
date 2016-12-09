<?php

Route::any('admin/categories/data', ['as' => 'categories.data',
    'uses' => 'CategoryController@data']);

Route::resource('admin/categories', 'CategoryController');

Route::post('admin/categories/multiple', ['as' => 'categories.multiple',
    'uses' => 'CategoryController@multiple']);

Route::post('admin/seed-category', ['as' => 'categories.seed',
    'uses' => 'CategoryController@seed']);

Route::get('admin/sort-category/{sort}', ['as' => 'categories.sort',
    'uses' => 'CategoryController@sortCategory']);

Route::get('admin/categories/locale/create/{id}', ['as' => 'categories.locale.create',
    'uses' => 'CategoryController@createLocale']);

Route::get('admin/categories/locale/edit/{id}', ['as' => 'categories.locale.edit',
    'uses' => 'CategoryController@editLocale']);

Route::post('admin/categories/locale/{id}', ['as' => 'categories.locale.store',
    'uses' => 'CategoryController@storeLocale']);

Route::put('admin/categories/locale/{id}', ['as' => 'categories.locale.update',
    'uses' => 'CategoryController@updateLocale']);

Route::get('admin/categories/locale/index/{id}', ['as' => 'categories.locale.index',
    'uses' => 'CategoryController@indexLocale']);

Route::get('admin/categories/locale/delete/{id}', ['as' => 'categories.locale.delete',
    'uses' => 'CategoryController@deleteLocale']);