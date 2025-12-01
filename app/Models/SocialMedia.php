<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialMedia extends Model
{
    protected $fillable = [
        'user_id',
        'platform',
        'url',
        'order',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function platforms(): array
    {
        return [
            'instagram' => 'Instagram',
            'linkedin' => 'LinkedIn',
            'twitter' => 'Twitter',
            'facebook' => 'Facebook',
            'github' => 'GitHub',
            'website' => 'Website',
        ];
    }

    public function getIconAttribute(): string
    {
        $icons = [
            'instagram' => 'instagram',
            'linkedin' => 'linkedin',
            'twitter' => 'twitter',
            'facebook' => 'facebook',
            'github' => 'github',
            'website' => 'globe',
        ];

        return $icons[$this->platform] ?? 'link';
    }
}
