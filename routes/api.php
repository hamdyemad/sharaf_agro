<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



Route::post('/login', 'Api\AuthController@login')->name('login');

Route::group(['middleware' => 'jwt'], function() {
    Route::get('/orders', 'Api\OrderController@index');
    Route::get('/inquires', 'Api\InquiresController@index');
    Route::get('/categories', 'Api\CategoryController@index');
    Route::get('/sub_categories', 'Api\SubCategoryController@index');
    Route::get('/statuses', 'Api\StatusController@index');
    Route::get('/news', 'Api\NewsController@index');

    Route::post('/fire_token', 'Api\AuthController@firebase_tokens');

    Route::get('/profile', 'Api\AuthController@profile');
    Route::post('/profile', 'Api\AuthController@update_profile');

    // Roles
    Route::get('/roles', 'Api\RoleController@index');
});
