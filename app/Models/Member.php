<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Member extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'code', 'name', 'nik', 'email', 'password', 'address', 'phone', 'gender', 'position', 'role', 'job', 'ktp_photo_path', 'foto_3x4_path', 'status', 'approved_at', 'registered_at', 'documents_uploaded', 'documents_uploaded_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'approved_at'   => 'datetime',
        'registered_at' => 'datetime',
        'documents_uploaded_at' => 'datetime',
        'documents_uploaded' => 'boolean',
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

