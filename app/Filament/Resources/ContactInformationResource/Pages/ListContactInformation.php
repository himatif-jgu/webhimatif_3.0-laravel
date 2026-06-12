<?php

namespace App\Filament\Resources\ContactInformationResource\Pages;

use App\Filament\Resources\ContactInformationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListContactInformation extends ListRecords
{
    protected static string $resource = ContactInformationResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
