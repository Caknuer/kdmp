<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'name',
        'nik',
        'address',
        'phone',
        'access_code',
        'ktp_file',
        'is_active',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
