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
            $totalIncome = $transactions->where('type','income')->sum('amount');
            $totalExpense = $transactions->where('type','expense')->sum('amount');
            $budget =  Auth::user()->budgets->first();

            //TBA for Insights

            return view('components.dashboard',compact('transactions', 'budget','totalIncome','totalExpense'));
        }
        return redirect()->route('login');
    }

    public function transactions()
    {
        $transactions = Auth::user()->transactions;

        $income = $transactions->where('type','income');
        $expense = $transactions->where('type','expense');

        $totalIncome = $transactions->where('type','income')->sum('amount');
        $totalExpense = $transactions->where('type','expense')->sum('amount');
        $totalMoney = $totalIncome-$totalExpense; //TBA

        $budget =  Auth::user()->budgets->first();


        return view('components.transaction-plan',compact('income','expense','totalIncome','totalExpense','totalMoney','budget'));
    }

    public function settings()
    {
        $user = Auth::user();
        return view('components.settings',compact('user'));
    }
}
