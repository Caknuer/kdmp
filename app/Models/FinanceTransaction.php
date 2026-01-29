<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanceTransaction extends Model
{
    protected $table = 'finance_transactions';

    protected $fillable = [
        'date', 'type', 'category', 'description', 'amount',
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];
}
