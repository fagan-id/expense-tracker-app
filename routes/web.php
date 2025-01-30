<?php

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\AuthRegisterController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\wAuthRegisterController;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Return_;

// Welcome Navigation
Route::view('/home', 'home')->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/','welcome')->middleware('guest')->name('welcome');

// Main Navigation
Route::get('/dashboard',[MainController::class,'index'])->name('dashboard');
Route::get('/transactions',[MainController::class,'transactions'])->name('transactions');
Route::get('/settings',[MainController::class,'settings'])->name('transactions');


Route::get('/api/chart-data', [MainController::class, 'chartData']);


// Authentication
Route::controller(AuthRegisterController::class)->group(function () {
    // Authentication View
    Route::view('/login', 'auth.login')->middleware('guest')->name('login');
    Route::view('/register', 'auth.register')->middleware('guest')->name('register');
    Route::view('/forgot-password','auth.forgot-password')->name('password.request');

    // Handle Input Request
    Route::post('/login', 'login')->middleware('guest')->name('login.submit');
    Route::post('/register', 'register')->middleware('guest')->name('register.submit');
    Route::post('/logout', 'logout')->name('logout.submit');

    // Reset Password Handling
    Route::post('/forgot-password',[ResetPasswordController::class,'passwordEmail']);
    Route::get('/reset-password/{token}',[ResetPasswordController::class,'passwordReset'])->name('password.reset');
    Route::post('/reset-password',[ResetPasswordController::class,'passwordUpdate'] )->name('password.update');
});

// Transactions
Route::controller(TransactionsController::class)->group(function () {
    // View for Forms
    Route::get('/transactions/form', 'form')->name('transactions.form');
    ///TBA


    // Handle Input Request
    Route::post('/transactions/store','store')->name('transactions.store');
    Route::put('/transactions/update/{id}','update')->name('transactions.update');
    Route::post('/transactions/show/{id}','show')->name('transactions.show');
    Route::delete('/transactions/destroy/{id}','delete')->name('transactions.delete');
});

// Budget
Route::controller(BudgetController::class)->group(function () {
    // Handle Input Request
    Route::patch('/budget/update/{id}', 'update')->name('budget.update');
    Route::post('/budget/store', 'store')->name('budget.store'); // Tambahkan Route Store
});

// Google Login
Route::get('/auth/google/redirect',[GoogleAuthController::class, 'redirect']);
Route::get('/auth/google/callback',[GoogleAuthController::class, 'callback']);
