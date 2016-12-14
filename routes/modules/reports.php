<?php

Route::get('admin/reports', ['as' => 'reports.index',
    'uses' => 'ReportController@index']);

Route::post('admin/reports', ['as' => 'reports.query',
    'uses' => 'ReportController@query']);