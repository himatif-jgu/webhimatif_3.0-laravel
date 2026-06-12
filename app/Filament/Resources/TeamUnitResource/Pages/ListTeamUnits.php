<?php

namespace App\Filament\Resources\TeamUnitResource\Pages;

use App\Filament\Resources\TeamUnitResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTeamUnits extends ListRecords
{
    protected static string $resource = TeamUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
