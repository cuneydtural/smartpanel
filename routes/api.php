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

// Image Upload & Crop
Route::post('croppic/upload', ['as' => 'api.croppic.upload',
    'uses' => 'CropController@postUpload']);

Route::post('croppic/crop', ['as' => 'api.croppic.crop',
    'uses' => 'CropController@postCrop']);

// City & Districts
Route::get('/get-districts/{city_id}', [ 'uses' => 'ApiController@queryDistricts',
    'as' => 'api.districts.get' ]);

Route::get('/get-stores/{type_id}/{city_id}', [ 'uses' => 'ApiController@queryStores',
    'as' => 'api.stores.get' ]);

// Shopping Cart
Route::post('/shopping-cart/add-to-cart', ['as' => 'api.shoppingcart.add',
    'uses' => 'Frontend\ShoppingCartController@addToCart']);

Route::get('/shopping-cart/load-cart', ['as' => 'api.shoppingcart.load',
    'uses' => 'Frontend\ShoppingCartController@loadCart']);

Route::post('/shopping-cart/remove-cart-item', ['as' => 'api.shoppingcart.remove.cart.item',
    'uses' => 'Frontend\ShoppingCartController@removeCartItem']);
