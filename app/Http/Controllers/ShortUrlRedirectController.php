<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\RedirectResponse;

class ShortUrlRedirectController extends Controller
{
    public function __invoke(string $code): RedirectResponse
    {
        $shortUrl = ShortUrl::where('code', $code)->firstOrFail();

        abort_unless($shortUrl->isAvailable(), 404);

        $shortUrl->forceFill([
            'clicks_count' => $shortUrl->clicks_count + 1,
            'last_clicked_at' => now(),
        ])->save();

        return redirect()->away($shortUrl->original_url);
    }
}
