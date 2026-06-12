<?php

namespace App\Filament\Resources\HistoryEntryResource\Pages;

use App\Filament\Resources\HistoryEntryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHistoryEntries extends ListRecords
{
    protected static string $resource = HistoryEntryResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
