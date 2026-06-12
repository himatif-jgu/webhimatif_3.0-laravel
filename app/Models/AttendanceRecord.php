<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceRecord extends Model
{
    protected $fillable = [
        'attendance_event_id',
        'user_id',
        'npm',
        'attendee_name',
        'status',
        'source',
        'checked_in_at',
        'checked_in_by',
        'notes',
    ];

    protected $casts = [
        'checked_in_at' => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(AttendanceEvent::class, 'attendance_event_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function checkedInBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checked_in_by');
    }
}
