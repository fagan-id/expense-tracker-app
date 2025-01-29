<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionsFactory> */
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'amount',
        'category',
        'type',
        'date',
        'description',
        'user_id'
    ];

    protected $casts = [
        'date' => 'datetime'
    ];

    public function getTimeAttribute()
    {
        return $this->date->format('H:i:s'); // Mengambil bagian waktu dari date
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
