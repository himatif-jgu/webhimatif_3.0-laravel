<?php

namespace App\Filament\Resources\ContactInformationResource\Pages;

use App\Filament\Resources\ContactInformationResource;
use App\Filament\Resources\Pages\Concerns\RedirectsToResourceIndex;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditContactInformation extends EditRecord
{
    use RedirectsToResourceIndex;

    protected static string $resource = ContactInformationResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
