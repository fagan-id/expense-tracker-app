<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\returnSelf;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // TB CHANGE
        return Transactions::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'amount' => 'required|numeric',
            'type' =>  'required|in:income,expense',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        $fields['user_id'] = Auth::id();

        Transactions::create($fields);

        return ['transactions' => $fields];
    }

    /**
     * Display the specified resource.
     */
    public function show(Transactions $transactions)
    {
        return ['transaction' => $transactions];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transactions $transactions)
    {
        if ($transactions->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized access'], 403);
        }

        $fields = $request->validate([
            'amount' => 'required|numeric',
            'type' =>  'required|in:income,expense',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        $transactions->update($fields);

        return response()->json(["message" => "transactions updated succesfully!"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transactions $transactions)
    {
        $transactions->delete();
        return response()->json(["message" => "transactions deleted succesfully"]);
    }
}
