<?php

namespace App\Filament\Resources\LandingContentResource\Pages;

use App\Filament\Resources\LandingContentResource;
use App\Filament\Resources\Pages\Concerns\RedirectsToResourceIndex;
use Filament\Resources\Pages\CreateRecord;

class CreateLandingContent extends CreateRecord
{
    use RedirectsToResourceIndex;

    protected static string $resource = LandingContentResource::class;
}
