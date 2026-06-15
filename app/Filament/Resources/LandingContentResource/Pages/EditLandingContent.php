<?php

namespace App\Filament\Resources\LandingContentResource\Pages;

use App\Filament\Resources\LandingContentResource;
use App\Filament\Resources\Pages\Concerns\RedirectsToResourceIndex;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLandingContent extends EditRecord
{
    use RedirectsToResourceIndex;

    protected static string $resource = LandingContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
