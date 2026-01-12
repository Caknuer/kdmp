<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'tagline',
        'logo',
        'favicon',
        'email',
        'phone',
        'address',
        'facebook',
        'instagram',
        'youtube',
        'tiktok',
        'about',
    ];

    public static function current(): self
    {
        return static::firstOrCreate(
            ['id' => 1],
            [
                'site_name' => 'KDMP Wonokerto',
                'tagline' => 'Koperasi Desa Merah Putih',
            ]
        );
    }

    protected $primaryKey = 'id';
    public $incrementing = true;

}
