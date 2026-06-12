<?php

namespace App\Filament\Resources\QrCodeItemResource\Pages;

use App\Filament\Resources\QrCodeItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListQrCodeItems extends ListRecords
{
    protected static string $resource = QrCodeItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
