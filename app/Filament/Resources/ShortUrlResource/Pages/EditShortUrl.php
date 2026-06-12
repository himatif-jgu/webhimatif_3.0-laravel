<?php

namespace App\Filament\Resources\ShortUrlResource\Pages;

use App\Filament\Resources\ShortUrlResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditShortUrl extends EditRecord
{
    protected static string $resource = ShortUrlResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->visible(fn (): bool => ShortUrlResource::canManageRecord($this->record)),
        ];
    }
}
