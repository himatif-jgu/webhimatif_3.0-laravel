<?php

namespace App\Filament\Resources\HistoryEntryResource\Pages;

use App\Filament\Resources\HistoryEntryResource;
use App\Filament\Resources\Pages\Concerns\RedirectsToResourceIndex;
use Filament\Resources\Pages\CreateRecord;

class CreateHistoryEntry extends CreateRecord
{
    use RedirectsToResourceIndex;

    protected static string $resource = HistoryEntryResource::class;
}
