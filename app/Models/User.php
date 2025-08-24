<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nip',
        'name',
        'email',
        'no_hp',
        'password',
        'role',
        'department_id', // ganti dari 'department'
        'position',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Override untuk login menggunakan NIP
    public function getAuthIdentifierName()
    {
        return 'nip';
    }

    // Relationships
    public function createdTickets()
    {
        return $this->hasMany(Ticket::class, 'created_by');
    }

    public function assignedTickets()
    {
        return $this->hasMany(Ticket::class, 'assigned_to');
    }

    public function approvedTickets()
    {
        return $this->hasMany(Ticket::class, 'approved_by');
    }

    // Relasi ke Department
    public function departmentRef()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isApproval()
    {
        return $this->role === 'approval';
    }

    public function isPegawai()
    {
        return $this->role === 'pegawai';
    }

    public function getFullNameWithNipAttribute()
    {
        return $this->name . ' (' . $this->nip . ')';
    }

    // Accessor untuk nama department (backward compatibility)
    public function getDepartmentNameAttribute()
    {
        return $this->departmentRef->name ?? '-';
    }

    // Accessor untuk department (jika masih ada kode yang menggunakan $user->department)
    public function getDepartmentAttribute()
    {
        return $this->departmentRef->name ?? null;
    }
}
