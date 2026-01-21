<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationMember extends Model
{
    protected $fillable = [
        'name',
        'role',
        'type',
        'photo',
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
        if ($this->photo && file_exists(storage_path('app/public/' . $this->photo))) {
            return asset('storage/' . $this->photo);
        }

        return asset('images/avatar.png');
    }

}
