<?php

Route::any('admin/slides/data', ['as' => 'slides.data',
    'uses' => 'SlideController@data']);

Route::resource('admin/slides', 'SlideController');

Route::post('admin/slides/multiple', ['as' => 'slides.multiple',
    'uses' => 'SlideController@multiple']);

Route::post('slides/ajax', ['as' => 'slides.ajax',
    'uses' => 'SlideController@ajax']);
