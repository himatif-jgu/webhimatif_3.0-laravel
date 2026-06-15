<?php

namespace App\Filament\Resources\AttendanceRecordResource\Pages;

use App\Filament\Resources\AttendanceRecordResource;
use App\Filament\Resources\Pages\Concerns\RedirectsToResourceIndex;
use Filament\Resources\Pages\CreateRecord;

class CreateAttendanceRecord extends CreateRecord
{
    use RedirectsToResourceIndex;

    protected static string $resource = AttendanceRecordResource::class;
}
