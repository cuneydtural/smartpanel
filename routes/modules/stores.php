<?php

Route::any('admin/stores/data', ['as' => 'stores.data',
    'uses' => 'StoreController@data']);

Route::resource('admin/stores', 'StoreController');

Route::post('admin/stores/multiple', ['as' => 'stores.multiple',
    'uses' => 'StoreController@multiple']);