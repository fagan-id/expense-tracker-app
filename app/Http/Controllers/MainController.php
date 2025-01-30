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
            $transactions = $user->transactions()->orderBy('date', 'desc')->get();

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

    public function chartData(Request $request)
    {
        $user = Auth::user();
        $filter = $request->query('filter', 'daily');

        $transactions = $user->transactions()->get();
        $labels = collect();
        $incomeData = collect();
        $expenseData = collect();

        if ($filter === 'daily') {
            // Ambil jam dari created_at
            $labels = collect(range(0, 23))->map(fn($h) => sprintf('%02d:00', $h));

            $incomeData = $labels->map(fn($hour) => 
                $transactions->where('type', 'income')
                    ->whereBetween('created_at', [
                        now()->startOfDay()->addHours(intval(substr($hour, 0, 2))),
                        now()->startOfDay()->addHours(intval(substr($hour, 0, 2)) + 1)
                    ])
                    ->sum('amount')
            );

            $expenseData = $labels->map(fn($hour) => 
                $transactions->where('type', 'expense')
                    ->whereBetween('created_at', [
                        now()->startOfDay()->addHours(intval(substr($hour, 0, 2))),
                        now()->startOfDay()->addHours(intval(substr($hour, 0, 2)) + 1)
                    ])
                    ->sum('amount')
            );

        } elseif ($filter === 'weekly') {
            $startOfWeek = now()->startOfWeek();
            $labels = collect(range(0, 6))->map(fn($d) => $startOfWeek->copy()->addDays($d)->format('l'));

            $incomeData = $labels->map(fn($label, $index) => 
                $transactions->where('type', 'income')
                    ->whereBetween('date', [
                        $startOfWeek->copy()->addDays($index)->startOfDay(),
                        $startOfWeek->copy()->addDays($index)->endOfDay()
                    ])
                    ->sum('amount')
            );

            $expenseData = $labels->map(fn($label, $index) => 
                $transactions->where('type', 'expense')
                    ->whereBetween('date', [
                        $startOfWeek->copy()->addDays($index)->startOfDay(),
                        $startOfWeek->copy()->addDays($index)->endOfDay()
                    ])
                    ->sum('amount')
            );

        } elseif ($filter === 'monthly') {
            $daysInMonth = now()->daysInMonth;
            $labels = collect(range(1, $daysInMonth))->map(fn($d) => sprintf('%02d', $d));

            $incomeData = $labels->map(fn($day) => 
                $transactions->where('type', 'income')
                    ->whereBetween('date', [
                        now()->startOfMonth()->addDays($day - 1)->startOfDay(),
                        now()->startOfMonth()->addDays($day - 1)->endOfDay()
                    ])
                    ->sum('amount')
            );

            $expenseData = $labels->map(fn($day) => 
                $transactions->where('type', 'expense')
                    ->whereBetween('date', [
                        now()->startOfMonth()->addDays($day - 1)->startOfDay(),
                        now()->startOfMonth()->addDays($day - 1)->endOfDay()
                    ])
                    ->sum('amount')
            );

        } elseif ($filter === 'yearly') {
            $labels = collect(range(1, 12))->map(fn($m) => now()->startOfYear()->addMonths($m - 1)->format('F'));

            $incomeData = $labels->map(fn($label, $index) => 
                $transactions->where('type', 'income')
                    ->whereBetween('date', [
                        now()->startOfYear()->addMonths($index)->startOfMonth(),
                        now()->startOfYear()->addMonths($index)->endOfMonth()
                    ])
                    ->sum('amount')
            );

            $expenseData = $labels->map(fn($label, $index) => 
                $transactions->where('type', 'expense')
                    ->whereBetween('date', [
                        now()->startOfYear()->addMonths($index)->startOfMonth(),
                        now()->startOfYear()->addMonths($index)->endOfMonth()
                    ])
                    ->sum('amount')
            );
        }

        $monthlyLimit = $user->budgets()
            ->where('month', now()->month)
            ->where('year', now()->year)
            ->first()?->monthly_limit ?? 0;

        return response()->json([
            'labels' => $labels,
            'income' => $incomeData,
            'expense' => $expenseData,
            'limit' => $labels->map(fn() => $monthlyLimit),
        ]);
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
