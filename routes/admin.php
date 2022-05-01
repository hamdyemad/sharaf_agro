<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;



Route::group(['middleware' => ['web', 'auth','notBanned']], function() {


    Route::group(['namespace' => 'Auth'], function() {
        // Logout User
        Route::post('/logout', 'LoginController@logout')->name('logout');
    });
    Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {
        // Render perticular view file by foldername and filename and all passed in only one controller at a time
        // Route::get('/{folder}/{file}', 'LexaAdmin@index');
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

        Route::post('/firebase_tokens', 'SettingsController@firebase_tokens')->name('firebase_tokens');

        // News
        Route::group(['prefix' => 'news', 'as' => 'news.'], function() {
            // For Customers Only
            Route::get('/all-news', 'NewsController@all_news')->name('all_news');
            Route::get('/', 'NewsController@index')->name('index');
            Route::post('/', 'NewsController@store')->name('store');
            Route::get('/create', 'NewsController@create')->name('create');
            Route::get('/{new}', 'NewsController@show')->name('show');
            Route::get('/edit/{new}', 'NewsController@edit')->name('edit');
            Route::patch('/{new}', 'NewsController@update')->name('update');
            Route::delete('/{new}', 'NewsController@destroy')->name('destroy');
        });



        // Categories
        Route::group(['prefix' => 'categories', 'as' => 'categories.'], function() {
            Route::get('/', 'CategoryController@index')->name('index');
            Route::post('/', 'CategoryController@store')->name('store');
            Route::get('/create', 'CategoryController@create')->name('create');
            Route::get('/edit/{category}', 'CategoryController@edit')->name('edit');
            Route::patch('/{category}', 'CategoryController@update')->name('update');
            Route::delete('/{category}', 'CategoryController@destroy')->name('destroy');
        });

        // Sub Categories
        Route::group(['prefix' => 'sub_categories', 'as' => 'sub_categories.'], function() {
            Route::get('/', 'SubCategoryController@index')->name('index');
            Route::post('/', 'SubCategoryController@store')->name('store');
            Route::get('/create', 'SubCategoryController@create')->name('create');
            Route::get('/edit/{sub_category}', 'SubCategoryController@edit')->name('edit');
            Route::patch('/{sub_category}', 'SubCategoryController@update')->name('update');
            Route::delete('/{sub_category}', 'SubCategoryController@destroy')->name('destroy');
            Route::post('/all', 'SubCategoryController@all')->name('all');
        });

        // Statuses
        Route::group(['prefix' => 'statuses', 'as' => 'statuses.'], function() {
            Route::get('/', 'StatusController@index')->name('index');
            Route::post('/', 'StatusController@store')->name('store');
            Route::get('/create', 'StatusController@create')->name('create');
            Route::get('/edit/{status}', 'StatusController@edit')->name('edit');
            Route::get('/{status}', 'StatusController@show')->name('show');
            Route::patch('/{status}', 'StatusController@update')->name('update');
            Route::delete('/{status}', 'StatusController@destroy')->name('destroy');
        });
        // Users
        Route::group(['prefix' => 'users', 'as' => 'users.'], function() {
            Route::get('/', 'UserController@index')->name('index');
            Route::post('/', 'UserController@store')->name('store');
            Route::get('/create', 'UserController@create')->name('create');
            Route::get('/profile/{user}', 'UserController@profile')->name('profile');
            Route::patch('/profile/{user}', 'UserController@update_profile')->name('update_profile');
            Route::post('/banned/{user}', 'UserController@banned')->name('banned');
            Route::get('/edit/{user}', 'UserController@edit')->name('edit');
            Route::patch('/{user}', 'UserController@update')->name('update');
            Route::delete('/{user}', 'UserController@destroy')->name('destroy');
        });

        // Customers
        Route::group(['prefix' => 'customers', 'as' => 'customers.'], function() {
            Route::get('/', 'CustomerController@index')->name('index');
            Route::post('/', 'CustomerController@store')->name('store');
            Route::get('/create', 'CustomerController@create')->name('create');
            Route::post('/banned/{user}', 'CustomerController@banned')->name('banned');
            Route::get('/edit/{user}', 'CustomerController@edit')->name('edit');
            Route::patch('/{user}', 'CustomerController@update')->name('update');
            Route::delete('/{user}', 'CustomerController@destroy')->name('destroy');
        });
        // Customers Balances
        Route::group(['prefix' => 'balances', 'as' => 'balances.'], function() {
            Route::get('/', 'CustomerBalanceController@index')->name('index');
            Route::get('/export-balances', 'CustomerBalanceController@export')->name('export');
            Route::post('/', 'CustomerBalanceController@store')->name('store');
            Route::get('/create', 'CustomerBalanceController@create')->name('create');
            Route::get('/edit/{balance}', 'CustomerBalanceController@edit')->name('edit');
            Route::patch('/{balance}', 'CustomerBalanceController@update')->name('update');
            Route::delete('/{balance}', 'CustomerBalanceController@destroy')->name('destroy');
        });

        // Roles
        Route::group(['prefix' => 'roles', 'as' => 'roles.'], function() {
            Route::get('/', 'RoleController@index')->name('index');
            Route::post('/', 'RoleController@store')->name('store');
            Route::get('/create', 'RoleController@create')->name('create');
            Route::get('/edit/{role}', 'RoleController@edit')->name('edit');
            Route::patch('/{role}', 'RoleController@update')->name('update');
            Route::delete('/{role}', 'RoleController@destroy')->name('destroy');
        });

        // Settings
        Route::group(['prefix' => 'settings', 'as' => 'settings.'], function() {
            Route::get('/edit', 'SettingsController@edit')->name('edit');
            Route::patch('/update', 'SettingsController@update')->name('update');
        });

        // Orders
        Route::group(['prefix' => 'orders', 'as' => 'orders.'], function() {
            Route::get('/', 'OrderController@index')->name('index');
            Route::get('/alerts', 'OrderController@alerts')->name('alerts');
            Route::get('/alerts/renovations', 'OrderController@alerts_renovations')->name('alerts.renovations');
            Route::get('/export-orders', 'OrderController@export')->name('export');
            Route::post('/', 'OrderController@store')->name('store');
            Route::get('/create', 'OrderController@create')->name('create');
            Route::get('/edit/{order}', 'OrderController@edit')->name('edit');
            Route::get('/show/{order}', 'OrderController@show')->name('show');
            Route::patch('/{order}', 'OrderController@update')->name('update');
            Route::delete('/{order}', 'OrderController@destroy')->name('destroy');

            // Under Work It's Commented on blade
            Route::post('/status', 'OrderController@store')->name('status_update');
        });

        // Orders Under Work
        Route::group(['prefix' => 'orders_under_work', 'as' => 'orders_under_work.'], function() {
            Route::get('/', 'OrderUnderWorkController@index')->name('index');
            Route::post('/', 'OrderUnderWorkController@store')->name('store');
            Route::get('/alerts', 'OrderUnderWorkController@alerts')->name('alerts');
            Route::get('/create', 'OrderUnderWorkController@create')->name('create');
            Route::get('/edit/{order}', 'OrderUnderWorkController@edit')->name('edit');
            Route::get('/show/{order}', 'OrderUnderWorkController@show')->name('show');
            Route::patch('/{order}', 'OrderUnderWorkController@update')->name('update');
            Route::delete('/{order}', 'OrderUnderWorkController@destroy')->name('destroy');

            // Under Work It's Commented on blade
            Route::post('/status', 'OrderUnderWorkController@update_status')->name('update_status');
        });

        // Inquires
        Route::group(['prefix' => 'inquires', 'as' => 'inquires.'], function() {
            Route::get('/', 'InquireController@index')->name('index');
            Route::post('/', 'InquireController@store')->name('store');
            Route::get('/create', 'InquireController@create')->name('create');
            Route::get('/edit/{inquire}', 'InquireController@edit')->name('edit');
            Route::get('/show/{inquire}', 'InquireController@show')->name('show');
            Route::patch('/{inquire}', 'InquireController@update')->name('update');
            Route::delete('/{inquire}', 'InquireController@destroy')->name('destroy');

            // Under Work It's Commented on blade
            Route::post('/status', 'InquireController@update_status')->name('update_status');
        });

    });
});
