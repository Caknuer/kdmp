<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessUnit extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'category',
        'icon',
        'thumbnail',
        'description',
        'services',
        'is_active',
        'order',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
