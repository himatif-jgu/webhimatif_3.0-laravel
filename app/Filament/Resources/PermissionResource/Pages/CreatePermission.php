<?php

namespace App\Filament\Resources\PermissionResource\Pages;

use App\Filament\Resources\PermissionResource;
use App\Filament\Resources\Pages\Concerns\RedirectsToResourceIndex;
use Filament\Resources\Pages\CreateRecord;

class CreatePermission extends CreateRecord
{
    use RedirectsToResourceIndex;

    protected static string $resource = PermissionResource::class;
}
