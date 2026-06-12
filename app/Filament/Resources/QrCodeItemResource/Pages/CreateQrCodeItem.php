<?php

namespace App\Filament\Resources\QrCodeItemResource\Pages;

use App\Filament\Resources\QrCodeItemResource;
use Filament\Resources\Pages\CreateRecord;

class CreateQrCodeItem extends CreateRecord
{
    protected static string $resource = QrCodeItemResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
