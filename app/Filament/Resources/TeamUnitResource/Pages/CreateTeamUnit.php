<?php

namespace App\Filament\Resources\TeamUnitResource\Pages;

use App\Filament\Resources\TeamUnitResource;
use App\Filament\Resources\Pages\Concerns\RedirectsToResourceIndex;
use Filament\Resources\Pages\CreateRecord;

class CreateTeamUnit extends CreateRecord
{
    use RedirectsToResourceIndex;

    protected static string $resource = TeamUnitResource::class;
}
