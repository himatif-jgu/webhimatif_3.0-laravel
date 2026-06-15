<?php

namespace App\Filament\Resources\Pages\Concerns;

trait RedirectsToResourceIndex
{
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
