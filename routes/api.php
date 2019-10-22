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
Route::get('categories', 'CategorieController@index');
Route::get('cities', 'CitieController@index');



Route::post('item', 'ItemController@store');
Route::get('item', 'ItemController@index');
Route::get('item/{id}', 'ItemController@show');
Route::put('item/{id}', 'ItemController@update');
Route::delete('item/delete/{id}', 'ItemController@delete');
Route::put('item/{id}/change_availability', 'ItemController@change_availability');
Route::get('showByname', 'UserController@showByname');


Route::post('login', 'AuthController@login');
Route::post('signup', 'AuthController@signup');
Route::put('user/{id}',  'UserController@update');
Route::get('user/{id}', 'UserController@showByid');
Route::get('user', 'UserController@index');

//Route::get('postt', 'postController@getcomment');

Route::post('fileUpload', 'PostController@fileUpload');
Route::group([

    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'

], function ($router) {
    Route::put('user/{id}/{update}',  'UserController@update');

    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');

});
