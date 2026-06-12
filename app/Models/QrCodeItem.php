<?php

namespace App\Models;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Data\QRMatrix;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class QrCodeItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'public_token',
        'type',
        'payload',
        'foreground_color',
        'background_color',
        'size',
        'views_count',
        'last_viewed_at',
        'is_active',
    ];

    protected $casts = [
        'size' => 'integer',
        'views_count' => 'integer',
        'last_viewed_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (QrCodeItem $item): void {
            if (blank($item->user_id) && auth()->check()) {
                $item->user_id = auth()->id();
            }

            if (blank($item->public_token)) {
                $item->public_token = Str::random(40);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function imageUrl(): string
    {
        return route('qr-codes.svg', $this->public_token);
    }

    public function qrCodeDataUri(): string
    {
        return (new QRCode(new QROptions([
            'outputType' => QRCode::OUTPUT_MARKUP_SVG,
            'scale' => max(4, min(12, (int) ceil($this->size / 60))),
            'moduleValues' => $this->moduleValues(),
        ])))->render($this->payload);
    }

    public function qrCodeSvg(): string
    {
        $dataUri = $this->qrCodeDataUri();

        if (str_starts_with($dataUri, 'data:image/svg+xml;base64,')) {
            $svg = base64_decode(substr($dataUri, strlen('data:image/svg+xml;base64,'))) ?: '';

            return $this->addCenterLogo($svg);
        }

        return $this->addCenterLogo($dataUri);
    }

    public function qrCodeSvgDataUri(): string
    {
        return 'data:image/svg+xml;base64,' . base64_encode($this->qrCodeSvg());
    }

    private function moduleValues(): array
    {
        $light = $this->background_color ?: '#ffffff';
        $dark = $this->foreground_color ?: '#111827';

        return [
            QRMatrix::M_NULL => $light,
            QRMatrix::M_DARKMODULE_LIGHT => $light,
            QRMatrix::M_DATA => $light,
            QRMatrix::M_FINDER => $light,
            QRMatrix::M_SEPARATOR => $light,
            QRMatrix::M_ALIGNMENT => $light,
            QRMatrix::M_TIMING => $light,
            QRMatrix::M_FORMAT => $light,
            QRMatrix::M_VERSION => $light,
            QRMatrix::M_QUIETZONE => $light,
            QRMatrix::M_LOGO => $light,
            QRMatrix::M_FINDER_DOT_LIGHT => $light,
            QRMatrix::M_DARKMODULE => $dark,
            QRMatrix::M_DATA_DARK => $dark,
            QRMatrix::M_FINDER_DARK => $dark,
            QRMatrix::M_SEPARATOR_DARK => $dark,
            QRMatrix::M_ALIGNMENT_DARK => $dark,
            QRMatrix::M_TIMING_DARK => $dark,
            QRMatrix::M_FORMAT_DARK => $dark,
            QRMatrix::M_VERSION_DARK => $dark,
            QRMatrix::M_QUIETZONE_DARK => $dark,
            QRMatrix::M_LOGO_DARK => $dark,
            QRMatrix::M_FINDER_DOT => $dark,
        ];
    }

    private function addCenterLogo(string $svg): string
    {
        $logoPath = public_path('assets/landing/images/logo-himatif.png');

        if (! is_file($logoPath) || ! preg_match('/viewBox="([^"]+)"/', $svg, $matches)) {
            return $svg;
        }

        $viewBox = array_map('floatval', preg_split('/\s+/', trim($matches[1])));

        if (count($viewBox) !== 4 || $viewBox[2] <= 0 || $viewBox[3] <= 0) {
            return $svg;
        }

        [$minX, $minY, $width, $height] = $viewBox;
        $logoSize = min($width, $height) * 0.22;
        $padding = $logoSize * 0.18;
        $backgroundSize = $logoSize + ($padding * 2);
        $backgroundX = $minX + (($width - $backgroundSize) / 2);
        $backgroundY = $minY + (($height - $backgroundSize) / 2);
        $logoX = $minX + (($width - $logoSize) / 2);
        $logoY = $minY + (($height - $logoSize) / 2);
        $logoData = base64_encode((string) file_get_contents($logoPath));

        $overlay = sprintf(
            '<rect x="%s" y="%s" width="%s" height="%s" rx="%s" fill="#ffffff"/><image href="data:image/png;base64,%s" x="%s" y="%s" width="%s" height="%s" preserveAspectRatio="xMidYMid meet"/>',
            $backgroundX,
            $backgroundY,
            $backgroundSize,
            $backgroundSize,
            $padding,
            $logoData,
            $logoX,
            $logoY,
            $logoSize,
            $logoSize,
        );

        return str_replace('</svg>', $overlay . '</svg>', $svg);
    }
}
