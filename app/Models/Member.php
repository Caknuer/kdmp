<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'code', 'name', 'nik', 'email', 'address', 'phone', 'gender', 'position', 'role', 'job', 'ktp_photo_path', 'foto_3x4_path', 'status', 'approved_at', 'registered_at'
    ];

    protected $casts = [
        'approved_at'   => 'datetime',
        'registered_at' => 'datetime',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getBalanceAttribute(): float
    {
        $credit = $this->transactions()->where('type', 'credit')->sum('amount');
        $debit  = $this->transactions()->where('type', 'debit')->sum('amount');
        return (float) ($credit - $debit);
    }
}
