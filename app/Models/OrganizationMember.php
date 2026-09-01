<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class OrganizationMember extends Model
{
    protected $fillable = [
        'name_p',
        'role',
        'type',
        'photo_p',
        'bio',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /* Scope */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePengurus($query)
    {
        return $query->where('type', 'pengurus');
    }

    public function scopePengawas($query)
    {
        return $query->where('type', 'pengawas');
    }

    public function getPhotoUrlAttribute()
    {
        if (! $this->photo_p) {
            return null;
        }

        $path = ltrim($this->photo_p, '/');

        // External URL
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // Storage public file
        $storagePath = storage_path('app/public/' . $path);
        if (file_exists($storagePath)) {
            return asset('storage/' . $path);
        }

        // Public path directly
        if (file_exists(public_path($path))) {
            return asset($path);
        }

        return asset('storage/' . $path);
    }
}
