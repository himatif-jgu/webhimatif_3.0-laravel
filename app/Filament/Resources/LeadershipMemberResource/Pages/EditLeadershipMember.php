<?php

namespace App\Filament\Resources\LeadershipMemberResource\Pages;

use App\Filament\Resources\LeadershipMemberResource;
use App\Filament\Resources\Pages\Concerns\RedirectsToResourceIndex;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLeadershipMember extends EditRecord
{
    use RedirectsToResourceIndex;

    protected static string $resource = LeadershipMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
