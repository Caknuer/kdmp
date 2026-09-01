<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    protected $casts = [
        'is_active' => 'boolean',
        'order'     => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('name', 'asc');
    }

    /**
     * Get resolved thumbnail URL.
     *
     * @return string|null
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        if (! $this->thumbnail) {
            return null;
        }

        $path = ltrim($this->thumbnail, '/');

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
