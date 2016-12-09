<?php

Route::any('admin/forms/data', ['as' => 'forms.data',
    'uses' => 'FormController@data']);

Route::resource('admin/forms', 'FormController');

Route::post('admin/forms/multiple', ['as' => 'forms.multiple',
    'uses' => 'FormController@multiple']);