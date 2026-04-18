<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

Class AboutPage extends Model
{
    protected $fillable = [
        'slug',
        'profil_singkat',
        'visi',
        'misi',
        'nilai',
    ];

    protected $casts = [
        'misi' => 'array',
        'nilai' => 'array',
    ];
}
