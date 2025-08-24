<?php
// app/Models/Department.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name', 'description', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'department_id');
    }

    public function tickets()
    {
        return $this->hasManyThrough(
            Ticket::class,
            User::class,
            'department_id', // FK di users
            'created_by',    // FK di tickets
            'id',           // PK di departments
            'id'            // PK di users
        );
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
