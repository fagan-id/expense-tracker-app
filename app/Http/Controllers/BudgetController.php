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
            'monthly_limit' => 'required|numeric|min:0',
        ]);

        $month = now()->month;
        $year = now()->year;

        // Cek apakah user sudah memiliki budget bulan ini
        $existingBudget = $request->user()->budgets()
            ->where('month', $month)
            ->where('year', $year)
            ->first();

        if ($existingBudget) {
            return response()->json([
                'success' => false,
                'message' => "Budget bulan ini sudah ada. Silakan gunakan update!",
            ], 400);
        }

        // Simpan Budget Baru
        $fields['month'] = $month;
        $fields['year'] = $year;

        $budget = $request->user()->budgets()->create($fields);

        return response()->json([
            'success' => true,
            'message' => "Budget berhasil disimpan!",
            'budget' => $budget
        ]);
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
        $budget = Budget::find($id);

        if (!$budget) {
            return response()->json(['success' => false, 'message' => 'Budget belum tersedia untuk bulan ini. Silakan tambahkan terlebih dahulu.'], 404);
        }

        $validated = $request->validate([
            'monthly_limit' => 'required|numeric|min:0'
        ]);

        $budget->update(['monthly_limit' => $validated['monthly_limit']]);

        return response()->json(['success' => true, 'message' => 'Budget berhasil diperbarui!', 'new_limit' => $budget->monthly_limit]);
    }

}
