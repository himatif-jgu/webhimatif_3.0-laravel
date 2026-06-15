<?php

namespace App\Filament\Resources\ContactInformationResource\Pages;

use App\Filament\Resources\ContactInformationResource;
use App\Filament\Resources\Pages\Concerns\RedirectsToResourceIndex;
use Filament\Resources\Pages\CreateRecord;

class CreateContactInformation extends CreateRecord
{
    use RedirectsToResourceIndex;

    protected static string $resource = ContactInformationResource::class;
}
