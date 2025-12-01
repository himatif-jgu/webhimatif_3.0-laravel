<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class UpdateLastSeen
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
            $cacheKey = "user-online-{$user->id}";
            $updateKey = "user-last-update-{$user->id}";
            
            $now = now();
            
            Cache::put($cacheKey, $now, now()->addMinutes(5));
            
            $lastUpdate = Cache::get($updateKey);
            if (!$lastUpdate || $now->diffInMinutes($lastUpdate) >= 5) {
                $user->update(['last_seen_at' => $now]);
                Cache::put($updateKey, $now, now()->addMinutes(10));
            }
        }

        return $next($request);
    }
}
