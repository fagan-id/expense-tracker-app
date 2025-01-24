<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\Middleware;

class MainController
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum')
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check()) {
            $transactions = Auth::user()->transactions;
            $budget =  Auth::user()->transactions;

            return view('components.dashboard',compact('transactions', 'budget'));
        }
        return redirect()->route('login');
    }

    public function transactions()
    {
        //TBA
        return view('transaction-plan');
    }

    public function settings()
    {
        //TBA
        return view('settings');
    }
}
