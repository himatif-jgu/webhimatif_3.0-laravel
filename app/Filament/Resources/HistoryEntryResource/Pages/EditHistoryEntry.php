<?php

namespace App\Filament\Resources\HistoryEntryResource\Pages;

use App\Filament\Resources\HistoryEntryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHistoryEntry extends EditRecord
{
    protected static string $resource = HistoryEntryResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
