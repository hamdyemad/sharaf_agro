<?php

use Illuminate\Support\Facades\Route;

Route::post('/admin/login', 'Auth\LoginController@login')->name('login');
Route::get('/admin/login', function() {
    return view('auth.login');
})->name('admin_login');
Route::redirect('/admin', '/admin/dashboard');


Route::group(['namespace' => 'FrontEnd', 'as' => 'frontend.'], function() {
    Route::middleware('guest')->group(function() {
        Route::get('/login', 'HomeController@login')->name('login');
        Route::get('/register', 'HomeController@register')->name('register');
        Route::post('/register', 'HomeController@signup')->name('signup');
    });
    Route::group(['middleware' => 'auth', 'notBanned'], function() {
        Route::get('/profile/{user}', 'ProfileController@show')->name('profile');
        Route::patch('/profile/{user}', 'ProfileController@update_profile')->name('update_profile');
        Route::get('/orders', 'ProfileController@orders')->name('orders');
        Route::get('/orders/{order}', 'ProfileController@orders_show')->name('orders.show');
        // Logout User
        Route::get('/logout', 'ProfileController@logout')->name('logout');
        Route::get('/typeof-recieve', 'HomeController@receiveType')->name('receive');
        Route::get('/payment', 'HomeController@payment')->name('payment');
        Route::post('/order', 'OrderController@store')->name('order_store');
    });
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/cart', 'CartController@index')->name('cart');


    Route::get('/product/{product}', 'HomeController@product')->name('product');
    Route::get('/{branch}', 'BranchController@show')->name('branch');
    Route::post('/addToCart', 'CartController@addToCart')->name('addToCart');
    Route::post('/updateCart', 'CartController@updateCart')->name('updateCart');
    Route::post('/removFromCart', 'CartController@removeCart')->name('removeCart');

});
