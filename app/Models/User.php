<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
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
        'student_number',
        'batch_year',
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
        'division_id',
        'email',
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

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function socialMedia()
    {
        return $this->hasMany(SocialMedia::class)->orderBy('order');
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isActive(): bool
    {
        return (bool) $this->is_active;
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
