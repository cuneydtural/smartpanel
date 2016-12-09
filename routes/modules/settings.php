<?php

Route::resource('admin/settings', 'SettingController', [
    'only' => ['index', 'update']
]);

Route::post('admin/settings/upload/{id}', 'SettingController@upload')->name('settings.upload');
