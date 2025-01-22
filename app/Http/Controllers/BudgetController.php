<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreBudgetRequest;
use App\Http\Requests\UpdateBudgetRequest;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class BudgetController extends Controller implements HasMiddleware
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
        return Budget::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'monthly_limit' => 'required|numeric',
        ]);

        // Get the current month and year
        $month = now()->month;
        $year = now()->year;

        $existingBudget = $request->user()->budgets()
            ->where('month', $month)
            ->where('year', $year)
            ->first();

        if ($existingBudget) {
            return response()->json([
                'message' => "A budget for this month already exists. Please use the update method!",
            ], 400);
        }

        // Add the month and year to the fields
        $fields['month'] = $month;
        $fields['year'] = $year;

        // if($request->user()->budgets){
        //     return ['message' => "Already Created a Budget for This Month, Please Use Update!"];
        // }


        $budgets = $request->user()->budgets()->create($fields);


        return [
            'message' => "Succesfully Created A Limit For This Month!",
            'budget' => $budgets,
            ];
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $budget = Budget::findOrFail($id);
        return ['budget'=>$budget];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $budget = Budget::findOrFail($id);
        Gate::authorize('changeBudget', $budget);


        $fields = $request->validate([
            'monthly_limit' => 'required|numeric'
        ]);

        $budget->update($fields);

        return ["message" => "Succesfully Updated Budgets for this Month!",
        "budget" => $budget];
    }
}
