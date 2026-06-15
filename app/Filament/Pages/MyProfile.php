<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Pages\Page;

class MyProfile extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $slug = 'my-profile';

    protected static bool $shouldRegisterNavigation = false;

    protected string $view = 'filament.pages.my-profile';

    public static function canAccess(): bool
    {
        return auth()->check();
    }

    public function getTitle(): string
    {
        return 'My Profile';
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('editProfile')
                ->label('Edit Profile')
                ->icon('heroicon-o-pencil-square')
                ->url(EditMyProfile::getUrl()),
        ];
    }
}
