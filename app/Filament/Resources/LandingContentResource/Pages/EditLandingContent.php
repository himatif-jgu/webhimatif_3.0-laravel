<?php

namespace App\Filament\Resources\LandingContentResource\Pages;

use App\Filament\Resources\LandingContentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLandingContent extends EditRecord
{
    protected static string $resource = LandingContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
