<?php

use App\Http\Controllers\AuthRegisterController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\wAuthRegisterController;
use Illuminate\Support\Facades\Route;

// Welcome Navigation
Route::view('/home', 'home')->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/','welcome')->middleware('guest')->name('welcome');

// Main Navigation
Route::get('/dashboard',[MainController::class,'index'])->name('dashboard');
Route::get('/transactions',[MainController::class,'transactions'])->name('transactions');
Route::get('/settings',[MainController::class,'settings'])->name('transactions');


Route::controller(AuthRegisterController::class)->group(function () {
    // Authentication View
    Route::view('/login', 'auth.login')->middleware('guest')->name('login');
    Route::view('/register', 'auth.register')->middleware('guest')->name('register');

    // Handle Input Request
    Route::post('/login', 'login')->middleware('guest')->name('login.submit');
    Route::post('/register', 'register')->middleware('guest')->name('register.submit');
    Route::post('/logout', 'logout')->name('logout.submit');
});

Route::controller(TransactionsController::class)->group(function () {
    // View for Forms
    ///TBA


    // Handle Input Request
    Route::post('/transactions/store','store')->name('transactions.store');
    Route::put('/transactions/update/{id}','update')->name('transactions.update');
    Route::post('/transactions/show/{id}','show')->name('transactions.show');
    Route::delete('/transactions/destroy/{id}','delete')->name('transactions.delete');
});

Route::controller(BudgetController::class)->group(function () {
    // TBA
});

