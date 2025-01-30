<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $from = Carbon::parse(sprintf(
            '%s-%s-01',
            $request->query('y', Carbon::now()->year),
            $request->query('m', Carbon::now()->month)
        ));

        $to = $from->copy()->endOfMonth();

        $transactions = Transactions::whereUserId(Auth()->id)
            ->whereBetween('date', [$from, $to])
            ->get();

        return response()->json($this->processTransactions($transactions));
    }

    public function monthly(Request $request)
    {
        $year = $request->query('y', Carbon::now()->year);
        $transactions = Transactions::whereUserId(Auth()->id)
            ->whereYear('date', $year)
            ->get()
            ->groupBy(function ($transaction) {
                return Carbon::parse($transaction->date)->format('m');
            });

        $summary = [];
        foreach ($transactions as $month => $transactionGroup) {
            $summary[$month] = $this->processTransactions($transactionGroup);
        }

        return response()->json($summary);
    }

    public function yearly(Request $request)
    {
        $transactions = Transactions::whereUserId(Auth()->id)
            ->get()
            ->groupBy(function ($transaction) {
                return Carbon::parse($transaction->date)->format('Y');
            });

        $summary = [];
        foreach ($transactions as $year => $transactionGroup) {
            $summary[$year] = $this->processTransactions($transactionGroup);
        }

        return response()->json($summary);
    }

    private function processTransactions($transactions)
    {
        $incomeTransactions = $transactions->where('type', 'income');
        $expenseTransactions = $transactions->where('type', 'expense');

        $totalIncome = $incomeTransactions->sum('amount');
        $totalExpense = $expenseTransactions->sum('amount');
        $profit = $totalIncome - $totalExpense;

        return [
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'profit' => $profit,
            'income_summary' => $this->buildCategorySummary($incomeTransactions->groupBy('category')),
            'expense_summary' => $this->buildCategorySummary($expenseTransactions->groupBy('category')),
        ];
    }

    private function buildCategorySummary($groups)
    {
        $summary = [];
        foreach ($groups as $category => $transactions) {
            $summary[] = [
                'name' => $category ?? 'Uncategorized',
                'amount' => $transactions->sum('amount'),
            ];
        }
        return $summary;
    }
}
