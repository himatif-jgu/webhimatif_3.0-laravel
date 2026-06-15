<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Filament\Resources\Pages\Concerns\RedirectsToResourceIndex;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    use RedirectsToResourceIndex {
        getRedirectUrl as getResourceIndexRedirectUrl;
    }

    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->visible(fn (): bool => UserResource::canDelete($this->record)),
        ];
    }

    protected function getRedirectUrl(): string
    {
        if (auth()->user()?->isAdmin()) {
            return $this->getResourceIndexRedirectUrl();
        }

        return UserResource::getUrl('view', ['record' => $this->record]);
    }
}
