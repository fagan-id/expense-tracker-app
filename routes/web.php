<?php

use App\Http\Controllers\AuthRegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\wAuthRegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/',[MainController::class,'index'])->name('dashboard');


Route::controller(AuthRegisterController::class)->group(function () {

    // View
    Route::view('/login', 'auth.login')->name('login');
    Route::view('/register', 'auth.register')->name('register');

    // Handle Input Request
    Route::post('/login', 'login')->name('login.submit');
    Route::post('/register', 'register')->name('register.submit');
    Route::post('/logout', 'logout')->name('logout.submit');
});
