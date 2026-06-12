<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryEntry extends Model
{
    protected $fillable = [
        'type',
        'title',
        'body',
        'period',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
