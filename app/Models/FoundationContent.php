<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FoundationContent extends Model
{
    protected $fillable = [
        'type',
        'title',
        'slug',
        'summary',
        'body',
        'image_path',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (FoundationContent $content): void {
            if (blank($content->slug)) {
                $content->slug = Str::slug($content->title);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
