<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\AuthRegisterController;
use App\Http\Controllers\TransactionsController;

Route::post('/register', [AuthRegisterController::class,'register']);
Route::post('/login',[AuthRegisterController::class,'login']);
Route::post('/logout',[AuthRegisterController::class,'logout'])->middleware('auth:sanctum');


Route::apiResource('transactions',TransactionsController::class);
Route::apiResource('budgets',BudgetController::class);
// Route::apiResource('reports',ReportController::class);



