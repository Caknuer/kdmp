<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlyFinanceReport extends Model
{
    protected $fillable = [
        'month',
        'income',
        'expense',
        'balance',
        'is_published',
        'note',
    ];
}
