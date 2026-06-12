<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class TeamUnit extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'subtitle',
        'description',
        'icon',
        'image_path',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (TeamUnit $unit): void {
            if (blank($unit->slug)) {
                $unit->slug = Str::slug($unit->name);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
