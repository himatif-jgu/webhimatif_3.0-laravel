<?php

namespace App\Filament\Resources\TeamUnitResource\Pages;

use App\Filament\Resources\TeamUnitResource;
use App\Filament\Resources\Pages\Concerns\RedirectsToResourceIndex;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTeamUnit extends EditRecord
{
    use RedirectsToResourceIndex;

    protected static string $resource = TeamUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
