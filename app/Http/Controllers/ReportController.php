<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function monthly(Request $request)
    {
        $year = $request->query('y', Carbon::now()->year);

        $transactions = Transactions::whereUserId(Auth::id())
            ->whereYear('date', $year)
            ->get()
            ->groupBy(fn($transaction) => Carbon::parse($transaction->date)->format('m'));

        $summary = [];
        foreach ($transactions as $month => $transactionGroup) {
            $summary[$month] = $this->processTransactions($transactionGroup);
        }

        if ($request->expectsJson()) {
            return response()->json($summary);
        }

        // Aggregate the summary into a single report
        $reportData = $this->aggregateReport($summary);

        // Set date range for the full year
        $month = $request->query('m', Carbon::now()->month);
        $from = Carbon::create($year, $month, 1)->startOfMonth();
        $to = Carbon::create($year, $month, 1)->endOfMonth();

        return $this->generatePdf($reportData, $from, $to);
    }

    public function yearly(Request $request)
    {
        $transactions = Transactions::whereUserId(Auth::id())->get()
            ->groupBy(fn($transaction) => Carbon::parse($transaction->date)->format('Y'));

        $summary = [];
        foreach ($transactions as $year => $transactionGroup) {
            $summary[$year] = $this->processTransactions($transactionGroup);
        }

        if ($request->expectsJson()) {
            return response()->json($summary);
        }

        // Aggregate the summary into a single report
        $reportData = $this->aggregateReport($summary);

        // Get actual date range from transactions
        $from = Carbon::now()->startOfYear();
        $to = Carbon::now()->endOfYear();

        return $this->generatePdf($reportData, $from, $to);
    }

    private function processTransactions($transactions)
    {
        $incomeTransactions = $transactions->where('type', 'income');
        $expenseTransactions = $transactions->where('type', 'expense');

        return [
            'total_income' => $incomeTransactions->sum('amount'),
            'total_expense' => $expenseTransactions->sum('amount'),
            'profit' => $incomeTransactions->sum('amount') - $expenseTransactions->sum('amount'),
            'income_summary' => $this->buildCategorySummary($incomeTransactions->groupBy('category')),
            'expense_summary' => $this->buildCategorySummary($expenseTransactions->groupBy('category')),
        ];
    }

    private function aggregateReport($summary)
    {
        $totalIncome = 0;
        $totalExpense = 0;
        $incomeSummary = [];
        $expenseSummary = [];

        foreach ($summary as $data) {
            $totalIncome += $data['total_income'];
            $totalExpense += $data['total_expense'];

            foreach ($data['income_summary'] as $income) {
                $incomeSummary[$income['name']] = ($incomeSummary[$income['name']] ?? 0) + $income['amount'];
            }

            foreach ($data['expense_summary'] as $expense) {
                $expenseSummary[$expense['name']] = ($expenseSummary[$expense['name']] ?? 0) + $expense['amount'];
            }
        }

        return [
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'profit' => $totalIncome - $totalExpense,
            'income_summary' => array_map(fn($name, $amount) => ['name' => $name, 'amount' => $amount], array_keys($incomeSummary), array_values($incomeSummary)),
            'expense_summary' => array_map(fn($name, $amount) => ['name' => $name, 'amount' => $amount], array_keys($expenseSummary), array_values($expenseSummary)),
        ];
    }

    private function buildCategorySummary($groups)
    {
        return collect($groups)->map(fn($transactions, $category) => [
            'name' => $category ?? 'Uncategorized',
            'amount' => $transactions->sum('amount'),
        ])->values()->toArray();
    }

    private function generatePdf($reportData, $from, $to)
    {
        $pdf = Pdf::loadView('components.report', compact('reportData', 'from', 'to'));
        return $pdf->download('aturin_transaction_report.pdf');
    }
}
