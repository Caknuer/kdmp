<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Busines extends Model
{
    protected $table = 'business_units'; // sesuaikan dengan nama tabel di database

    protected $fillable = [
        'name',
        'slug',
        'description',
        'thumbnail',
    ];
}
