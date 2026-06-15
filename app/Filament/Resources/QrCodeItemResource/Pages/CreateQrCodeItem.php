<?php

namespace App\Filament\Resources\QrCodeItemResource\Pages;

use App\Filament\Resources\QrCodeItemResource;
use App\Filament\Resources\Pages\Concerns\RedirectsToResourceIndex;
use Filament\Resources\Pages\CreateRecord;

class CreateQrCodeItem extends CreateRecord
{
    use RedirectsToResourceIndex;

    protected static string $resource = QrCodeItemResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
