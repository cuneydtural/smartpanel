<?php

Route::any('admin/products/data', ['as' => 'products.data',
    'uses' => 'ProductController@data']);

Route::resource('admin/products', 'ProductController');

Route::post('admin/products/multiple', ['as' => 'products.multiple',
    'uses' => 'ProductController@multiple']);

Route::post('admin/products/photo/delete', ['as' => 'products.photo.delete',
    'uses' => 'ProductController@deletePhoto']);

Route::post('admin/products/ajax', ['as' => 'products.ajax',
    'uses' => 'ProductController@ajax']);

Route::get('admin/products/showcase/set/{pivot_id}/{source_id}', ['as' => 'products.showcase.set',
    'uses' => 'ProductController@setShowcase']);
