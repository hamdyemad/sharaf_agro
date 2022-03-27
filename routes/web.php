<?php

use Illuminate\Support\Facades\Route;

Route::group([
'prefix' => LaravelLocalization::setLocale(),
'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath'
]], function() {
    Route::group(['middleware' => 'guest'], function() {
        Route::redirect('/admin', '/admin/login');
        Route::post('/admin/login', 'Auth\LoginController@login')->name('login');
        Route::get('/admin/login', function() {
            return view('auth.login');
        })->name('admin_login');
    });

    Route::get('/paymob/callback', 'Payments\PaymobController@callback');
    Route::get('/success', 'Payments\PaypalController@processSuccess')->name('processSuccess');
    Route::get('/cancel', 'Payments\PaypalController@processCancel')->name('processCancel');

    Route::group(['namespace' => 'FrontEnd', 'as' => 'frontend.'], function() {
        Route::middleware('guest')->group(function() {
            Route::get('/login', 'HomeController@login')->name('login');
            Route::get('/register', 'HomeController@register')->name('register');
            Route::post('/register', 'HomeController@signup')->name('signup');
        });
        Route::group(['middleware' => 'auth', 'notBanned'], function() {
            Route::get('/profile/{user}', 'ProfileController@show')->name('profile');
            Route::patch('/profile/{user}', 'ProfileController@update_profile')->name('update_profile');



            Route::get('/orders', 'OrderController@index')->name('orders');
            Route::post('/orders', 'OrderController@store')->name('orders.store');
            Route::get('/payments', 'OrderController@payments')->name('payments');
            Route::get('/orders/{order}', 'OrderController@show')->name('orders.show');
            Route::get('/{order}/order_confirmed', 'OrderController@order_confirmed')->name('order_confirmed');
            // Logout User
            Route::get('/logout', 'ProfileController@logout')->name('logout');
            Route::get('/typeof-recieve', 'HomeController@receiveType')->name('receive');
            Route::get('/payment', 'HomeController@payment')->name('payment');
            Route::post('/checkout', 'OrderController@checkout')->name('checkout');

        });
        Route::get('/', 'HomeController@index')->name('home');
        Route::get('/cart', 'CartController@index')->name('cart');


        Route::get('/product/{product}', 'HomeController@product')->name('product');
        Route::post('/products', 'HomeController@productsByName')->name('productsByName');
        Route::get('/{branch}', 'BranchController@show')->name('branch');
        Route::post('/addToCart', 'CartController@addToCart')->name('addToCart');
        Route::post('/updateCart', 'CartController@updateCart')->name('updateCart');
        Route::post('/removFromCart', 'CartController@removeCart')->name('removeCart');


    });
});



