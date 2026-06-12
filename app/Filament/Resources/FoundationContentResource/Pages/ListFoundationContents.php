<?php

namespace App\Filament\Resources\FoundationContentResource\Pages;

use App\Filament\Resources\FoundationContentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFoundationContents extends ListRecords
{
    protected static string $resource = FoundationContentResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
