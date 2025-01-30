<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use function PHPUnit\Framework\returnSelf;

class TransactionsController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum',except: ['index','show'])
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // TB CHANGE
        return Transactions::all();
    }

    public function form(Request $request)
    {
        $incomeTransactions = Transactions::where('type', 'income')->orderBy('date', 'desc')->get();
        $expenseTransactions = Transactions::where('type', 'expense')->orderBy('date', 'desc')->get();

        return view('components.form-transaction', [
            'type' => $request->query('type'),
            'incomeTransactions' => $incomeTransactions,
            'expenseTransactions' => $expenseTransactions,
        ]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'amount' => 'required|numeric',
            'category' => 'required|in:Transportation,Entertainment,Utilities,Food & Beverages,Health Care,Education,Investment,Others',
            'type' =>  'required|in:income,expense',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        try {
            $post = $request->user()->transactions()->create($fields);

            $message = $fields['type'] === 'income' ? 'Income successfully added' : 'Expense successfully added';

            return response()->json([
                'success' => true,
                'message' => $message,
                'transaction' => $post
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add transaction. Please try again.',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $transactions = Transactions::findOrFail($id);

        return ['transaction' => $transactions];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $transactions = Transactions::findOrFail($id);

        Gate::authorize('modify', $transactions);

        $fields = $request->validate([
            'amount' => 'required|numeric',
            'category' => 'required|in:Transportation,Entertainment,Utilities,Food & Beverages,Health Care,Education,Investment,Others',
            'type' =>  'required|in:income,expense',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        $transactions->update($fields);

        // Handle API Request
        if ($request->expectsJson()) {
            return ["message" => "Transactions succesfully Updated",
            "transactions" => $transactions];
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $transactions = Transactions::findOrFail($id);

        Gate::authorize('modify', $transactions);

        $transactions->delete();
        return response()->json(["message" => "transactions deleted succesfully"]);
    }
}
