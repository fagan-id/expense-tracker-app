<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreBudgetRequest;
use App\Http\Requests\UpdateBudgetRequest;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // TB CHANGE
        return Budget::all();
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

        Budget::create($fields);
        return ['budget' => $fields];
    }

    /**
     * Display the specified resource.
     */
    public function show(Budget $budget)
    {
        return ['budget'=>$budget];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Budget $budget)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Budget $budget)
    {
        //
    }
}
