<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('croppic/upload', ['as' => 'api.croppic.upload',
    'uses' => 'CropController@postUpload']);

Route::post('croppic/crop', ['as' => 'api.croppic.crop',
    'uses' => 'CropController@postCrop']);

Route::get('/get-districts/{city_id}', [ 'uses' => 'ApiController@queryDistricts',
    'as' => 'api.districts.get' ]);

Route::get('/get-stores/{type_id}/{city_id}', [ 'uses' => 'ApiController@queryStores',
    'as' => 'api.stores.get' ]);

Route::get('articles-json', function() {
    $articles = \App\Article::all();
    return response()->json($articles);
});