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

Route::group(['middleware' => 'jwt', 'namespace' => 'Api'], function() {

    // Orders
    Route::group(['prefix' => 'orders'], function() {
        Route::get('/', 'OrderController@index');
        Route::get('/alerts/renovations', 'OrderController@alerts_renovations')->name('alerts.renovations');
        Route::get('/alerts', 'OrderController@alerts')->name('alerts');
    });


    // Inquires
    Route::group(['prefix' => 'inquires'], function() {
        Route::get('/', 'InquiresController@index');
        Route::get('/{id}', 'InquiresController@show');
        Route::post('/', 'InquiresController@store');
        Route::post('/add_reply/{id}', 'InquiresController@add_reply');

    });

    // Orders Under Work
    Route::group(['prefix' => 'orders_under_work'], function() {
        Route::get('/', 'OrderUnderWorkController@index');
        Route::post('/', 'OrderUnderWorkController@store');
        Route::get('/{id}', 'OrderUnderWorkController@show');
        Route::post('/status/{id}', 'OrderUnderWorkController@update_status');

    });

    // entry_and_exit
    Route::group(['prefix' => 'entry_and_exit'], function() {
        Route::post('/', 'EntryAndExitController@store');
    });

    // Categories
    Route::get('/categories', 'CategoryController@index');

    // Sub Categories
    Route::get('/sub_categories', 'SubCategoryController@index');

    // Statuses
    Route::get('/statuses', 'StatusController@index');

    // News
    Route::get('/news', 'NewsController@index');

    // Firebase post tokens for push notifications
    Route::post('/fire_token', 'AuthController@firebase_tokens');

    // Profile
    Route::group(['prefix' => 'profile'], function() {
        Route::get('/', 'AuthController@profile');
        Route::post('/', 'AuthController@update_profile');
    });


    // Roles
    Route::get('/roles', 'RoleController@index');

    // Alerts
    Route::group(['prefix' => 'alerts'], function() {
        Route::get('/news', 'AlertsController@news');
        Route::post('/news/{id}/seen', 'AlertsController@news_seen');

        Route::get('/orders', 'AlertsController@orders');
        Route::post('/orders/{id}/seen', 'AlertsController@orders_seen');


        Route::get('/orders_under_work', 'AlertsController@orders_under_work');
        Route::post('/orders_under_work/{id}/seen', 'AlertsController@orders_under_work_seen');

        Route::get('/inquires', 'AlertsController@inquires');
        Route::post('/inquires/{id}/seen', 'AlertsController@inquire_seen');
    });


});
