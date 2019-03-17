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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', 'Apis\AuthController@register');
Route::post('/login', 'Apis\AuthController@login');

//Products Routes
Route::get('products', 'ProductController@index');
Route::post('product', 'ProductController@store');
Route::put('product', 'ProductController@store');
Route::delete('product/{id}', 'ProductController@destroy');

#Images Routes
Route::get('image/{id}', 'ImageController@getImagesForProducts');
Route::post('image', 'ImageController@store');
Route::delete('image/{id}', 'ImageController@destroy');