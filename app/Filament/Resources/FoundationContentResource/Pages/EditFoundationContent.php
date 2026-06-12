<?php

namespace App\Filament\Resources\FoundationContentResource\Pages;

use App\Filament\Resources\FoundationContentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFoundationContent extends EditRecord
{
    protected static string $resource = FoundationContentResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
