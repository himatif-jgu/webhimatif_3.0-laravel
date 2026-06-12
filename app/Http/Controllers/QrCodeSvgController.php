<?php

namespace App\Http\Controllers;

use App\Models\QrCodeItem;
use Illuminate\Http\Response;

class QrCodeSvgController extends Controller
{
    public function __invoke(string $token): Response
    {
        $item = QrCodeItem::where('public_token', $token)->firstOrFail();

        abort_unless($item->is_active, 404);

        $item->forceFill([
            'views_count' => $item->views_count + 1,
            'last_viewed_at' => now(),
        ])->save();

        return response($item->qrCodeSvg(), 200, [
            'Content-Type' => 'image/svg+xml',
            'Cache-Control' => 'public, max-age=300',
        ]);
    }
}
