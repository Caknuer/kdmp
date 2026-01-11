<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'date',
        'amount',
        'type',
        'description',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
