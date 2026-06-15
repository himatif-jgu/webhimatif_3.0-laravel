<?php

namespace App\Filament\Resources\AttendanceEventResource\Pages;

use App\Filament\Resources\AttendanceEventResource;
use App\Filament\Resources\Pages\Concerns\RedirectsToResourceIndex;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAttendanceEvent extends EditRecord
{
    use RedirectsToResourceIndex;

    protected static string $resource = AttendanceEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->visible(fn (): bool => AttendanceEventResource::canManageRecord($this->record)),
        ];
    }
}
