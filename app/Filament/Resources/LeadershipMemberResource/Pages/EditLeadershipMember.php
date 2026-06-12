<?php

namespace App\Filament\Resources\LeadershipMemberResource\Pages;

use App\Filament\Resources\LeadershipMemberResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLeadershipMember extends EditRecord
{
    protected static string $resource = LeadershipMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
