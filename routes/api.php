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
Route::group(['middleware' => 'role:super_admin'], function() {
    Route::post('/admin', function() {
        return 'Welcome Admin';
    });
    Route::get('admin/changeUC/{id}', 'UserController@changeUC');
    Route::post('admin/user/{id}/change_status', 'UserController@change_status_U');
    Route::get('admin/item/{id}/change_status', 'ItemController@change_statusI');
    Route::get('admin/items', 'ItemController@AllItemAdmin');
    Route::delete('admin/item/delete/{id}', 'ItemController@deleteAdmin');
    Route::post('admin/categories', 'CategorieController@store');
    Route::delete('admin/categories/delete/{id}', 'CategorieController@delete');
    Route::get('admin/categories/{id}', 'CategorieController@show');
    Route::put('admin/categories/{id}', 'CategorieController@update');
    Route::post('admin/cities/', 'CitieController@store');
    Route::delete('admin/cities/{id}', 'CitieController@delete');
    Route::get('admin/cities', 'CitieController@index');
    Route::put('admin/cities/{id}', 'CitieController@update');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('admin/user', 'UserController@index');

    Route::put('item/{id}/change_availability', 'ItemController@change_availability');
    Route::delete('item/delete/{id}', 'ItemController@delete');
    Route::put('item/{id}', 'ItemController@update');
    Route::post('item', 'ItemController@store');
    Route::post('editprofile', 'UserController@editprofile');
    Route::put('user/{id}',  'UserController@update');


});
Route::get('test', 'UserController@test');

Route::get('cities', 'CitieController@index');
Route::get('categories', 'CategorieController@index');
Route::get('user/company', 'UserController@getcompany');


Route::get('item', 'ItemController@index');
Route::get('item/{id}', 'ItemController@show');
Route::get('showByname', 'UserController@showByname');

Route::get('me', 'AuthController@me');
Route::post('login', 'AuthController@login');
Route::post('signup', 'AuthController@signup');
Route::get('user/{id}', 'UserController@showByid');
Route::get('IU/{id}', 'ItemController@itemsshowByiduser');
Route::post('adduseradmin/{id}', 'UserController@adduseradmin');

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
Route::get('/redirect', 'SocialAuthFacebookController@redirect');
Route::get('/callback', 'SocialAuthFacebookController@callback');
