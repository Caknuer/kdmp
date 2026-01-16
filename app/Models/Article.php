<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'thumbnail',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'datetime'
    ];

    protected static function booted()
    {
        static::creating(function ($articles) {
            if (empty($articles->slug)) {
                $articles->slug = Str::slug($articles->title);
            }
        });
    }
}
