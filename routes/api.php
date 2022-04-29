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

    // Inquires
    Route::group(['prefix' => 'inquires'], function() {
        Route::get('/', 'Api\InquiresController@index');
        Route::get('/{id}', 'Api\InquiresController@show');
        Route::post('/', 'Api\InquiresController@store');
    });

    // Orders Under Work
    Route::group(['prefix' => 'orders_under_work'], function() {
        Route::get('/', 'Api\OrderUnderWorkController@index');
        Route::post('/', 'Api\OrderUnderWorkController@store');
        Route::get('/{id}', 'Api\OrderUnderWorkController@show');
    });

    // Categories
    Route::get('/categories', 'Api\CategoryController@index');

    // Sub Categories
    Route::get('/sub_categories', 'Api\SubCategoryController@index');

    // Statuses
    Route::get('/statuses', 'Api\StatusController@index');

    // News
    Route::get('/news', 'Api\NewsController@index');

    // Firebase post tokens for push notifications
    Route::post('/fire_token', 'Api\AuthController@firebase_tokens');

    // Profile
    Route::group(['prefix' => 'profile'], function() {
        Route::get('/', 'Api\AuthController@profile');
        Route::post('/', 'Api\AuthController@update_profile');
    });


    // Roles
    Route::get('/roles', 'Api\RoleController@index');
});
