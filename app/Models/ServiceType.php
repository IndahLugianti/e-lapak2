<?php
// app/Models/ServiceType.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'requires_file',
        'file_requirements',
        'is_active',
        'estimated_days',
    ];

    protected $casts = [
        'requires_file' => 'boolean',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
