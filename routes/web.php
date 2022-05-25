<?php

use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'guest'], function() {
    Route::redirect('/', '/login');
    Route::post('/login', 'Auth\LoginController@login')->name('login');
    Route::get('/login', function() {
        return view('auth.login');
    })->name('admin_login');
});

