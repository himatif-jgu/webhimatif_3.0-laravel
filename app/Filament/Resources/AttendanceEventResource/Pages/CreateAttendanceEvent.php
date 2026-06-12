<?php

namespace App\Filament\Resources\AttendanceEventResource\Pages;

use App\Filament\Resources\AttendanceEventResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAttendanceEvent extends CreateRecord
{
    protected static string $resource = AttendanceEventResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();
        $data['assigned_to'] = auth()->id();

        return $data;
    }
}
