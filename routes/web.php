<?php

use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'guest'], function() {
    Route::redirect('/admin', '/admin/login');
    Route::post('/admin/login', 'Auth\LoginController@login')->name('login');
    Route::get('/admin/login', function() {
        return view('auth.login');
    })->name('admin_login');
});


Route::get('/home', function() {
    return "home";
})->name('frontend.home');

