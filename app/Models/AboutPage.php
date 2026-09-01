<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutPage extends Model
{
    protected $fillable = [
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
