<?php

namespace App\Filament\Resources\QrCodeItemResource\Pages;

use App\Filament\Resources\QrCodeItemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditQrCodeItem extends EditRecord
{
    protected static string $resource = QrCodeItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->visible(fn (): bool => QrCodeItemResource::canManageRecord($this->record)),
        ];
    }
}
