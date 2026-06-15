<?php

namespace App\Filament\Resources\FoundationContentResource\Pages;

use App\Filament\Resources\FoundationContentResource;
use App\Filament\Resources\Pages\Concerns\RedirectsToResourceIndex;
use Filament\Resources\Pages\CreateRecord;

class CreateFoundationContent extends CreateRecord
{
    use RedirectsToResourceIndex;

    protected static string $resource = FoundationContentResource::class;
}
