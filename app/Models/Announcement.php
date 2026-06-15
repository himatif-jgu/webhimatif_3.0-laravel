<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Announcement extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'content',
        'image',
        'category',
        'visibility',
        'audience',
        'is_pinned',
        'is_published',
        'published_at',
        'expires_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Announcement $announcement): void {
            if (blank($announcement->slug)) {
                $announcement->slug = self::uniqueSlug($announcement->title);
            }

            if (blank($announcement->created_by) && auth()->check()) {
                $announcement->created_by = auth()->id();
            }

            if (blank($announcement->updated_by) && auth()->check()) {
                $announcement->updated_by = auth()->id();
            }
        });

        static::updating(function (Announcement $announcement): void {
            if ($announcement->isDirty('title') && ! $announcement->isDirty('slug')) {
                $announcement->slug = self::uniqueSlug($announcement->title, $announcement->id);
            }

            if (auth()->check()) {
                $announcement->updated_by = auth()->id();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where(fn (Builder $query): Builder => $query
                ->whereNull('expires_at')
                ->orWhere('expires_at', '>=', now()));
    }

    public function scopeVisibleOnLanding(Builder $query): Builder
    {
        return $query->whereIn('visibility', ['public', 'landing_only']);
    }

    public function scopeVisibleOnDashboard(Builder $query): Builder
    {
        return $query->whereIn('visibility', ['public', 'dashboard_only']);
    }

    public function scopeOrderedForDisplay(Builder $query): Builder
    {
        return $query
            ->orderByDesc('is_pinned')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at');
    }

    private static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title) ?: Str::random(8);
        $slug = $baseSlug;
        $counter = 2;

        while (self::query()
            ->when($ignoreId, fn (Builder $query): Builder => $query->whereKeyNot($ignoreId))
            ->where('slug', $slug)
            ->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
