<?php

namespace App\Filament\Resources\LeadershipMemberResource\Pages;

use App\Filament\Resources\LeadershipMemberResource;
use App\Filament\Resources\Pages\Concerns\RedirectsToResourceIndex;
use Filament\Resources\Pages\CreateRecord;

class CreateLeadershipMember extends CreateRecord
{
    use RedirectsToResourceIndex;

    protected static string $resource = LeadershipMemberResource::class;
}
