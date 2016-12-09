<?php

Route::any('admin/subscribers/data', ['as' => 'subscribers.data',
    'uses' => 'SubscriberController@data']);

Route::resource('admin/subscribers', 'SubscriberController');

Route::post('admin/subscribers/multiple', ['as' => 'subscribers.multiple',
    'uses' => 'SubscriberController@multiple']);