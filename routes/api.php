<?php

use App\Http\Controllers\AuthRegisterController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\TransactionsController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post('/register', [AuthRegisterController::class,'register']);
Route::post('/login',[AuthRegisterController::class,'login']);
Route::post('/logout',[AuthRegisterController::class,'logout']);


Route::apiResource('transactions',TransactionsController::class);
Route::apiResource('budgets',BudgetController::class);
// Route::apiResource('reports',ReportController::class);



