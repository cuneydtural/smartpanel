<?php

Route::any('admin/articles/data', ['as' => 'articles.data',
    'uses' => 'ArticleController@data']);

Route::resource('admin/articles', 'ArticleController');

Route::post('admin/articles/multiple', ['as' => 'articles.multiple',
    'uses' => 'ArticleController@multiple']);

Route::post('admin/articles/photo/delete', ['as' => 'articles.photo.delete',
    'uses' => 'ArticleController@deletePhoto']);

Route::post('admin/articles/ajax', ['as' => 'articles.ajax',
    'uses' => 'ArticleController@ajax']);

Route::get('admin/articles/showcase/set/{pivot_id}/{source_id}', ['as' => 'articles.showcase.set',
    'uses' => 'ArticleController@setShowcase']);
