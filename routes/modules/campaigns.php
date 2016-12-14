<?php

Route::any('admin/campaigns/data', ['as' => 'campaigns.data',
    'uses' => 'CampaignController@data']);

Route::resource('admin/campaigns', 'CampaignController');

Route::post('admin/campaigns/multiple', ['as' => 'campaigns.multiple',
    'uses' => 'CampaignController@multiple']);

