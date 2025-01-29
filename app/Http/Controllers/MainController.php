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
            $user = Auth::user();
            
            // Mengambil semua transaksi user
            $transactions = $user->transactions()->orderBy('date', 'desc')->orderBy('time', 'desc')->get();

            // Menghitung total pemasukan (income) bulan ini
            $totalIncome = $user->transactions()
                ->where('type', 'income')
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->sum('amount');

            // Menghitung total pengeluaran (expense) bulan ini
            $totalExpense = $user->transactions()
                ->where('type', 'expense')
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->sum('amount');

            // Mengambil batas pengeluaran bulan ini dari BudgetController
            $budget = $user->budgets()
                ->where('month', now()->month)
                ->where('year', now()->year)
                ->first();

            $monthlyLimit = $budget ? $budget->monthly_limit : 0;

            // Menghitung total uang bulan ini (sisa uang bulan ini)
            $total_Money = $totalIncome - $totalExpense;

            return view('components.dashboard', compact(
                'transactions', 
                'totalIncome', 
                'totalExpense', 
                'monthlyLimit', 
                'total_Money'
            ));
        }
        return redirect()->route('login');
    }


    public function transactions()
    {
        if (Auth::check()) {
            $incomeTransactions = Auth::user()->transactions()
                ->where('type', 'income')
                ->orderBy('date', 'desc') 
                ->get();

            $expenseTransactions = Auth::user()->transactions()
                ->where('type', 'expense')
                ->orderBy('date', 'desc')
                ->get();
            
            $totalIncome = $incomeTransactions->sum('amount');
            $totalExpense = $expenseTransactions->sum('amount');
            $totalBalance = $totalIncome - $totalExpense;

            $budget = Auth::user()->budgets()->where('month', now()->month)->where('year', now()->year)->first();
            
            $isOverLimit = false;
            if ($budget && $totalExpense > $budget->monthly_limit) {
                $isOverLimit = true;
            }

            return view('components.transaction-plan', [
                'incomeTransactions' => $incomeTransactions,
                'expenseTransactions' => $expenseTransactions,
                'totalBalance' => $totalBalance,
                'budget' => $budget,
                'isOverLimit' => $isOverLimit
            ]);
        }

        return redirect()->route('login');
    }


    public function settings()
    {
        //TBA
        return view('components.settings');
    }
}
