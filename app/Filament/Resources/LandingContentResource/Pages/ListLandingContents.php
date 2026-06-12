<?php

namespace App\Filament\Resources\LandingContentResource\Pages;

use App\Filament\Resources\LandingContentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLandingContents extends ListRecords
{
    protected static string $resource = LandingContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
