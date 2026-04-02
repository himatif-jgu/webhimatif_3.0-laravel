<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Meeting extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'description', 'type', 'meeting_date',
        'location', 'qr_code_token', 'is_active', 'created_by'
    ];

    protected $casts = [
        'meeting_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function attendances(): HasMany
    {
        return $this->hasMany(MeetingAttendance::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    public function scopeUpcoming(Builder $query): void
    {
        $query->where('meeting_date', '>=', now());
    }

    // Helpers
    public function isOpen(): bool
    {
        // Contoh logika: Buka jika active DAN belum lewat 24 jam dari jadwal
        return $this->is_active && $this->meeting_date->diffInHours(now(), false) < 24;
    }
}
