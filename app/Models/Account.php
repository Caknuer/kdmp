<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'nama',
        'type',
        'created_at',
        'updated_at',
    ];
}
