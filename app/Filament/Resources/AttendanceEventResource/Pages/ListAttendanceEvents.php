<?php

namespace App\Filament\Resources\AttendanceEventResource\Pages;

use App\Filament\Resources\AttendanceEventResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAttendanceEvents extends ListRecords
{
    protected static string $resource = AttendanceEventResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
