<?php

use Illuminate\Support\Str;

if (! function_exists('active_class')) {
    function active_class(array $patterns, string $active = 'active'): string
    {
        foreach ($patterns as $pattern) {
            if (route_pattern_matches($pattern)) {
                return $active;
            }
        }

        return '';
    }
}

if (! function_exists('is_active_route')) {
    function is_active_route(array $patterns): string
    {
        foreach ($patterns as $pattern) {
            if (route_pattern_matches($pattern)) {
                return 'true';
            }
        }

        return 'false';
    }
}

if (! function_exists('show_class')) {
    function show_class(array $patterns, string $class = 'show'): string
    {
        foreach ($patterns as $pattern) {
            if (route_pattern_matches($pattern)) {
                return $class;
            }
        }

        return '';
    }
}

if (! function_exists('route_pattern_matches')) {
    function route_pattern_matches(string $pattern): bool
    {
        $pattern = ltrim($pattern, '/');

        if ($pattern === '' || $pattern === '/') {
            return request()->path() === '/' || request()->is('/');
        }

        return request()->is($pattern);
    }
}
