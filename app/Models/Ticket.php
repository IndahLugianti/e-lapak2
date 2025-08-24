<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class Ticket extends Model
{
    use HasFactory;

    // Use ticket_number as route key instead of id
    public function getRouteKeyName()
    {
        return 'ticket_number';
    }

    protected $fillable = [
        'ticket_number',
        'title',
        'description',
        'priority',
        'status',
        'category',
        'created_by',
        'assigned_to',
        'approved_by',
        'approved_at',
        'approval_notes',
        'processed_at',
        'completed_at',
        'service_type_id',
        'file_pendukung',
        'completion_file',
    ];

    protected $casts = [
        'processed_at' => 'datetime',
        'completed_at' => 'datetime',
        'approved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Helper methods untuk format tanggal yang aman
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at ? $this->created_at->format('d/m/Y') : '-';
    }

    public function getFormattedCreatedTimeAttribute()
    {
        return $this->created_at ? $this->created_at->format('H:i') : '-';
    }

    public function getFormattedProcessedAtAttribute()
    {
        return $this->processed_at ? $this->processed_at->format('d/m H:i') : '-';
    }

    public function getFormattedCompletedAtAttribute()
    {
        return $this->completed_at ? $this->completed_at->format('d/m H:i') : '-';
    }

    public function getFormattedApprovedAtAttribute()
    {
        return $this->approved_at ? $this->approved_at->format('d/m/Y H:i') : '-';
    }

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }

    // Helper methods
    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'pengajuan' => 'bg-warning',
            'proses' => 'bg-info',
            'selesai' => 'bg-success',
            default => 'bg-secondary'
        };
    }

    public function getStatusText()
    {
        return match($this->status) {
            'pengajuan' => 'Pengajuan',
            'proses' => 'Proses',
            'selesai' => 'Selesai',
            default => 'Unknown'
        };
    }

    public function hasFile()
    {
        return !empty($this->file_pendukung);
    }

    public function fileExists()
    {
        return $this->hasFile() && Storage::disk('public')->exists('tickets/' . $this->file_pendukung);
    }

    public function getFileUrl()
    {
        if ($this->hasFile()) {
            return asset('storage/tickets/' . $this->file_pendukung);
        }
        return null;
    }

    public function hasCompletionFile()
    {
        return !empty($this->completion_file);
    }

    public function completionFileExists()
    {
        return $this->hasCompletionFile() && Storage::disk('public')->exists('tickets/completion/' . $this->completion_file);
    }

    public function getCompletionFileUrl()
    {
        if ($this->hasCompletionFile()) {
            return asset('storage/tickets/completion/' . $this->completion_file);
        }
        return null;
    }
}
