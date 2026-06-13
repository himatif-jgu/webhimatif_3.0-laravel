<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'npm',
        'batch_year',
        'team_unit_id',
        'phone',
        'is_active',
        'avatar',
        'gender',
        'birth_date',
        'address',
        'bio',
        'instagram_url',
        'linkedin_url',
        'website_url',
        'email',
        'google_id',
        'password',
        'last_seen_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'birth_date' => 'date',
            'is_active' => 'boolean',
            'password' => 'hashed',
            'last_seen_at' => 'datetime',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $panel->getId() === 'app'
            && $this->isActive()
            && $this->hasAnyRole([
                'admin',
                'ketua',
                'wakil_ketua',
                'sekretaris',
                'sekretaris_1',
                'sekretaris_2',
                'bendahara',
                'bendahara_1',
                'bendahara_2',
                'ketua_departemen',
                'wakil_ketua_departemen',
                'anggota_divisi',
                'dosen',
            ]);
    }

    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }

    public function assignedAttendanceEvents(): HasMany
    {
        return $this->hasMany(AttendanceEvent::class, 'assigned_to');
    }

    public function attendanceRecords(): HasMany
    {
        return $this->hasMany(AttendanceRecord::class);
    }

    public function teamUnit(): BelongsTo
    {
        return $this->belongsTo(TeamUnit::class);
    }

    /**
     * Encrypt route key to avoid exposing sequential IDs in URLs.
     */
    public function getRouteKey()
    {
        return encrypt($this->getKey());
    }

    public function isOnline(): bool
    {
        return \Cache::has("user-online-{$this->id}");
    }

    public function wasRecentlyOnline(): bool
    {
        if ($this->isOnline()) {
            return true;
        }

        if (!$this->last_seen_at) {
            return false;
        }

        return $this->last_seen_at->diffInMinutes(now()) <= 15;
    }

    public function lastSeenText(): string
    {
        if ($this->isOnline()) {
            return 'Online';
        }

        if (!$this->last_seen_at) {
            return 'Never';
        }

        $diffInMinutes = $this->last_seen_at->diffInMinutes(now());

        if ($diffInMinutes < 1) {
            return 'Just now';
        }

        if ($diffInMinutes < 60) {
            return $diffInMinutes . ' minute' . ($diffInMinutes > 1 ? 's' : '') . ' ago';
        }

        $diffInHours = $this->last_seen_at->diffInHours(now());
        if ($diffInHours < 24) {
            return $diffInHours . ' hour' . ($diffInHours > 1 ? 's' : '') . ' ago';
        }

        $diffInDays = $this->last_seen_at->diffInDays(now());
        if ($diffInDays < 7) {
            return $diffInDays . ' day' . ($diffInDays > 1 ? 's' : '') . ' ago';
        }

        return $this->last_seen_at->format('d M Y');
    }
}
