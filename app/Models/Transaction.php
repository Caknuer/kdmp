<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
   protected $fillable = [
        'member_id','transaction_for','date','type','category','description','amount'
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];

    public static function sourceOptions(): array
    {
        return [
            'tabungan_anggota' => 'Tabungan Anggota',
            'penghasilan' => 'Penghasilan',
            'operasional_unit_bisnis' => 'Operasional Unit Bisnis',
        ];
    }

    public function getCategoryLabelAttribute(): string
    {
        if (!$this->category) {
            return '-';
        }

        return self::sourceOptions()[$this->category] ?? ucfirst(str_replace(['_', '-'], [' ', ' '], $this->category));
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
