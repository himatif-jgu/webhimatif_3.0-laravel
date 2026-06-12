<?php

namespace App\Models;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ShortUrl extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'code',
        'original_url',
        'description',
        'clicks_count',
        'last_clicked_at',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'clicks_count' => 'integer',
        'last_clicked_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (ShortUrl $shortUrl): void {
            if (blank($shortUrl->user_id) && auth()->check()) {
                $shortUrl->user_id = auth()->id();
            }

            if (blank($shortUrl->code)) {
                $shortUrl->code = self::generateUniqueCode($shortUrl->title);
            }
        });

        static::saving(function (ShortUrl $shortUrl): void {
            if (filled($shortUrl->code)) {
                $shortUrl->code = Str::lower(Str::slug($shortUrl->code));
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function shortUrl(): string
    {
        return route('short-urls.redirect', $this->code);
    }

    public function qrCodeDataUri(): string
    {
        return (new QRCode(new QROptions([
            'outputType' => QRCode::OUTPUT_MARKUP_SVG,
            'scale' => 8,
        ])))->render($this->shortUrl());
    }

    public function qrCodeSvg(): string
    {
        $dataUri = $this->qrCodeDataUri();

        if (str_starts_with($dataUri, 'data:image/svg+xml;base64,')) {
            return base64_decode(substr($dataUri, strlen('data:image/svg+xml;base64,'))) ?: '';
        }

        return $dataUri;
    }

    public function isAvailable(): bool
    {
        if (! $this->is_active) {
            return false;
        }

        return ! $this->expires_at || now()->lte($this->expires_at);
    }

    private static function generateUniqueCode(?string $title = null): string
    {
        $baseCode = Str::lower(Str::slug((string) $title));
        $baseCode = $baseCode !== '' ? Str::limit($baseCode, 24, '') : Str::lower(Str::random(7));
        $code = $baseCode;
        $counter = 2;

        while (self::withTrashed()->where('code', $code)->exists()) {
            $suffix = '-' . $counter;
            $code = Str::limit($baseCode, 32 - strlen($suffix), '') . $suffix;
            $counter++;
        }

        return $code;
    }
}
