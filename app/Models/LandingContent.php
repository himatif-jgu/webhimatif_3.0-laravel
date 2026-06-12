<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class LandingContent extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'section',
        'key',
        'eyebrow',
        'title',
        'subtitle',
        'body',
        'image_path',
        'button_label',
        'button_url',
        'sort_order',
        'is_active',
        'published_at',
        'settings',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'published_at' => 'datetime',
        'settings' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (LandingContent $content): void {
            if (blank($content->key)) {
                $content->key = Str::slug($content->section . '-' . $content->title);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($query): void {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }
}
