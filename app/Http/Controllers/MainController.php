<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\Middleware;
use Carbon\Carbon;


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
    public function index(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $monthYear = $request->query('month_year', now()->format('Y-m'));
            $selectedMonth = date('m', strtotime($monthYear));
            $selectedYear = date('Y', strtotime($monthYear));

            // Mengambil transaksi berdasarkan bulan dan tahun yang dipilih
            $transactions = $user->transactions()
                ->whereMonth('date', $selectedMonth)
                ->whereYear('date', $selectedYear)
                ->orderBy('date', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            $totalIncome = $user->transactions()
                ->where('type', 'income')
                ->whereMonth('date', $selectedMonth)
                ->whereYear('date', $selectedYear)
                ->sum('amount');

            $totalExpense = $user->transactions()
                ->where('type', 'expense')
                ->whereMonth('date', $selectedMonth)
                ->whereYear('date', $selectedYear)
                ->sum('amount');

            $budget = $user->budgets()
                ->where('month', $selectedMonth)
                ->where('year', $selectedYear)
                ->first();

            $monthlyLimit = $budget ? $budget->monthly_limit : 0;
            $total_Money = $totalIncome - $totalExpense;

            return view('components.dashboard', compact(
                'transactions', 'totalIncome', 'totalExpense', 'monthlyLimit', 'total_Money'
            ));
        }
        return redirect()->route('login');
    }

    public function chartData(Request $request)
    {
        $user = Auth::user();
        $filter = $request->query('filter', 'daily');
        $monthYear = $request->query('month_year', now()->format('Y-m'));

        if (!preg_match('/^\d{4}-\d{2}$/', $monthYear)) {
            return response()->json(['error' => 'Invalid month_year format'], 400);
        }

        [$year, $month] = array_map('intval', explode('-', $monthYear));
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $transactions = $user->transactions()
            ->whereYear('date', $year)
            ->get();

        $labels = collect();
        $incomeData = collect();
        $expenseData = collect();
        $limitData = collect();

        if ($filter === 'daily') {
            $labels = collect(range(0, 23))->map(fn($h) => sprintf('%02d:00', $h));

            $incomeData = $labels->map(fn($hour) => 
                $transactions->where('type', 'income')
                    ->whereBetween('created_at', [
                        $startDate->copy()->addHours((int) $hour),
                        $startDate->copy()->addHours((int) $hour + 1)
                    ])
                    ->sum('amount')
            );

            $expenseData = $labels->map(fn($hour) => 
                $transactions->where('type', 'expense')
                    ->whereBetween('created_at', [
                        $startDate->copy()->addHours((int) $hour),
                        $startDate->copy()->addHours((int) $hour + 1)
                    ])
                    ->sum('amount')
            );
        } elseif ($filter === 'weekly') {
            $startOfWeek = $startDate->copy()->startOfWeek();
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
            $daysInMonth = $startDate->daysInMonth;
            $labels = collect(range(1, $daysInMonth))->map(fn($d) => sprintf('%02d', $d));

            $incomeData = $labels->map(fn($day) => 
                $transactions->where('type', 'income')
                    ->whereBetween('date', [
                        $startDate->copy()->addDays($day - 1)->startOfDay(),
                        $startDate->copy()->addDays($day - 1)->endOfDay()
                    ])
                    ->sum('amount')
            );

            $expenseData = $labels->map(fn($day) => 
                $transactions->where('type', 'expense')
                    ->whereBetween('date', [
                        $startDate->copy()->addDays($day - 1)->startOfDay(),
                        $startDate->copy()->addDays($day - 1)->endOfDay()
                    ])
                    ->sum('amount')
            );
        } elseif ($filter === 'yearly') {
            $labels = collect(range(1, 12))->map(fn($m) => Carbon::create($year, $m, 1)->format('F'));

            $incomeData = $labels->map(fn($label, $index) => 
                $transactions->where('type', 'income')
                    ->whereBetween('date', [
                        Carbon::create($year, $index + 1, 1)->startOfMonth(),
                        Carbon::create($year, $index + 1, 1)->endOfMonth()
                    ])
                    ->sum('amount')
            );

            $expenseData = $labels->map(fn($label, $index) => 
                $transactions->where('type', 'expense')
                    ->whereBetween('date', [
                        Carbon::create($year, $index + 1, 1)->startOfMonth(),
                        Carbon::create($year, $index + 1, 1)->endOfMonth()
                    ])
                    ->sum('amount')
            );

            $limitData = $labels->map(fn($label, $index) => 
                $user->budgets()
                    ->where('month', $index + 1)
                    ->where('year', $year)
                    ->first()?->monthly_limit ?? 0
            );
        }

        return response()->json([
            'labels' => $labels,
            'income' => $incomeData,
            'expense' => $expenseData,
            'limit' => $limitData,
        ]);
    }

    public function transactions(Request $request)
    {
        if (Auth::check()) {
            $selectedMonthYear = $request->input('month_year', now()->format('Y-m'));
            $selectedDate = \Carbon\Carbon::createFromFormat('Y-m', $selectedMonthYear);
            $month = $selectedDate->month;
            $year = $selectedDate->year;

            $incomeTransactions = Auth::user()->transactions()
                ->where('type', 'income')
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            $expenseTransactions = Auth::user()->transactions()
                ->where('type', 'expense')
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            $totalIncome = $incomeTransactions->sum('amount');
            $totalExpense = $expenseTransactions->sum('amount');
            $totalBalance = $totalIncome - $totalExpense;

            $budget = Auth::user()->budgets()
                ->where('month', $month)
                ->where('year', $year)
                ->first();

                // dd($budget);

            $isOverLimit = $budget && $totalExpense > $budget->monthly_limit;

            return view('components.transaction-plan', [
                'incomeTransactions' => $incomeTransactions,
                'expenseTransactions' => $expenseTransactions,
                'totalBalance' => $totalBalance,
                'budget' => $budget,
                'isOverLimit' => $isOverLimit,
                'selectedMonthYear' => $selectedMonthYear
            ]);
        }

        return redirect()->route('login');
    }

    public function settings()
    {
        $user = auth()->user();

        // Hitung total income dan total expense
        $totalIncome = $user->transactions()->where('type', 'income')->sum('amount');
        $totalExpense = $user->transactions()->where('type', 'expense')->sum('amount');

        // Daftar pertanyaan FAQ
        $faqs = [
            "What is Aturin ?" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
            "Lorem ipsum dolor sit amet ?" => null,
            "What is sigma boy?" => null,
            "What is Mahasigma ?" => null
        ];

        return view('components.settings', compact('user', 'totalIncome', 'totalExpense', 'faqs'));
    }

}
