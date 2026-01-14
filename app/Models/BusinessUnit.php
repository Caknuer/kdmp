<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BusinessUnit extends Model
{
      protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'description',
        'is_active',
        'order',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
