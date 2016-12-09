<?php

Route::any('admin/photo-library/data', ['as' => 'photo-library.data',
    'uses' => 'PhotoLibraryController@data']);

Route::any('admin/photo-library/choose-data', ['as' => 'photo-library.choose.data',
    'uses' => 'PhotoLibraryController@chooseData']);

Route::resource('admin/photo-library', 'PhotoLibraryController');

Route::post('admin/photo-library/multiple', ['as' => 'photo-library.multiple',
    'uses' => 'PhotoLibraryController@multiple']);

Route::get('admin/choose-from-library', ['as' => 'choose.library',
    'uses' => 'PhotoLibraryController@choose']);