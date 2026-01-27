<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class memtransaksi extends Model
{
    protected $fillable = [
        'member_id',
        'type',
        'amount',
        'date',
        'description',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
