<?php

namespace App\Filament\Resources\AttendanceRecordResource\Pages;

use App\Filament\Resources\AttendanceRecordResource;
use App\Filament\Resources\Pages\Concerns\RedirectsToResourceIndex;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAttendanceRecord extends EditRecord
{
    use RedirectsToResourceIndex;

    protected static string $resource = AttendanceRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->visible(fn (): bool => AttendanceRecordResource::canDelete($this->record)),
        ];
    }
}
