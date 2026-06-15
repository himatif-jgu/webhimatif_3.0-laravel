<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Filament\Resources\Pages\Concerns\RedirectsToResourceIndex;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditUser extends EditRecord
{
    use RedirectsToResourceIndex {
        getRedirectUrl as getResourceIndexRedirectUrl;
    }

    protected static string $resource = UserResource::class;

    protected ?string $oldAvatar = null;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->oldAvatar = $this->record->avatar;

        return $data;
    }

    protected function afterSave(): void
    {
        if (filled($this->oldAvatar) && $this->oldAvatar !== $this->record->avatar) {
            Storage::disk('public')->delete($this->oldAvatar);
        }
    }

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
