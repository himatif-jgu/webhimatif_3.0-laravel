<?php

namespace App\Filament\Resources\AttendanceEventResource\Pages;

use App\Filament\Resources\AttendanceEventResource;
use App\Filament\Resources\Pages\Concerns\RedirectsToResourceIndex;
use Filament\Resources\Pages\CreateRecord;

class CreateAttendanceEvent extends CreateRecord
{
    use RedirectsToResourceIndex;

    protected static string $resource = AttendanceEventResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();
        $data['assigned_to'] = auth()->id();

        return $data;
    }
}
