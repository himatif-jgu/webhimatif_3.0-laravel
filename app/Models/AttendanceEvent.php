<?php

namespace App\Models;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class AttendanceEvent extends Model
{
    protected $fillable = [
        'title',
        'activity_type',
        'description',
        'location',
        'starts_at',
        'ends_at',
        'check_in_opens_at',
        'check_in_closes_at',
        'qr_token',
        'created_by',
        'assigned_to',
        'is_active',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'check_in_opens_at' => 'datetime',
        'check_in_closes_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (AttendanceEvent $event): void {
            if (blank($event->qr_token)) {
                $event->qr_token = Str::random(40);
            }

            if (blank($event->created_by) && auth()->check()) {
                $event->created_by = auth()->id();
            }

            if (blank($event->assigned_to) && auth()->check()) {
                $event->assigned_to = auth()->id();
            }
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function records(): HasMany
    {
        return $this->hasMany(AttendanceRecord::class);
    }

    public function checkInUrl(): string
    {
        return route('attendance.check-in', $this->qr_token);
    }

    public function qrCodeDataUri(): string
    {
        return (new QRCode(new QROptions([
            'outputType' => QRCode::OUTPUT_MARKUP_SVG,
            'scale' => 8,
        ])))->render($this->checkInUrl());
    }

    public function qrCodeSvg(): string
    {
        $dataUri = $this->qrCodeDataUri();

        if (str_starts_with($dataUri, 'data:image/svg+xml;base64,')) {
            return base64_decode(substr($dataUri, strlen('data:image/svg+xml;base64,'))) ?: '';
        }

        return $dataUri;
    }

    public function isCheckInOpen(): bool
    {
        if (! $this->is_active) {
            return false;
        }

        $now = now();

        if ($this->check_in_opens_at && $now->lt($this->check_in_opens_at)) {
            return false;
        }

        if ($this->check_in_closes_at && $now->gt($this->check_in_closes_at)) {
            return false;
        }

        return true;
    }
}
