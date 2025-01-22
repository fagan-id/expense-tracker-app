<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    // SUBJECT TO CHANGE

    /** @use HasFactory<\Database\Factories\BudgetFactory> */
    use HasFactory;

    protected $fillable = [
        'monthly_limit',
        'month',
        'year'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
