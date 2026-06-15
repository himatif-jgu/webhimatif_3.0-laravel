<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class EditMyProfile extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-pencil-square';

    protected static ?string $slug = 'my-profile/edit';

    protected static bool $shouldRegisterNavigation = false;

    protected string $view = 'filament.pages.edit-my-profile';

    public ?array $data = [];

    public static function canAccess(): bool
    {
        return auth()->check();
    }

    public function mount(): void
    {
        $user = auth()->user();

        abort_unless($user, 403);

        $this->form->fill($user->only([
            'avatar',
            'name',
            'username',
            'phone',
            'gender',
            'birth_date',
            'address',
            'bio',
            'instagram_url',
            'linkedin_url',
            'website_url',
        ]));
    }

    public function getTitle(): string
    {
        return 'Edit My Profile';
    }

    public function form(Schema $schema): Schema
    {
        $user = auth()->user();

        return $schema
            ->statePath('data')
            ->components([
                Section::make('Account Identity')
                    ->description('Data akses seperti email, NPM, role, dan division dikelola admin agar data organisasi tetap konsisten.')
                    ->schema([
                        Placeholder::make('email')
                            ->label('Email')
                            ->content($user?->email ?? '-'),
                        Placeholder::make('npm')
                            ->label('NPM')
                            ->content($user?->npm ?? '-'),
                        Placeholder::make('roles')
                            ->label('Role')
                            ->content($user?->roles?->pluck('name')
                                ->map(fn (string $role): string => str($role)->replace('_', ' ')->title()->toString())
                                ->implode(', ') ?: '-'),
                        Placeholder::make('team_unit')
                            ->label('Division')
                            ->content($user?->teamUnit?->name ?? '-'),
                    ])
                    ->columns(2),

                Section::make('Profile')
                    ->schema([
                        FileUpload::make('avatar')
                            ->label('Profile Image')
                            ->image()
                            ->disk('public')
                            ->directory('users/avatars')
                            ->visibility('public')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(2048)
                            ->maxFiles(1)
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth('512')
                            ->imageResizeTargetHeight('512')
                            ->previewable()
                            ->openable()
                            ->downloadable()
                            ->deleteUploadedFileUsing(fn ($file): bool => is_string($file) && filled($file) && Storage::disk('public')->delete($file))
                            ->getUploadedFileUsing(function (FileUpload $component, string $file): ?array {
                                $storage = Storage::disk($component->getDiskName());

                                if (! $storage->exists($file)) {
                                    return null;
                                }

                                return [
                                    'name' => basename($file),
                                    'size' => $storage->size($file),
                                    'type' => $storage->mimeType($file),
                                    'url' => url('/storage/' . ltrim($file, '/')),
                                ];
                            })
                            ->helperText('JPG/PNG/WebP, max 2 MB. Foto akan dibuat rasio 1:1 agar rapi di header.')
                            ->columnSpanFull(),
                        TextInput::make('name')
                            ->label('Full Name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('username')
                            ->nullable()
                            ->maxLength(255)
                            ->rule(fn () => Rule::unique('users', 'username')->ignore(auth()->id())),
                        TextInput::make('phone')
                            ->tel()
                            ->maxLength(255),
                        Select::make('gender')
                            ->options([
                                'male' => 'Male',
                                'female' => 'Female',
                            ]),
                        DatePicker::make('birth_date')
                            ->label('Birth date'),
                        Textarea::make('address')
                            ->rows(3)
                            ->columnSpanFull(),
                        Textarea::make('bio')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Social Links')
                    ->schema([
                        TextInput::make('instagram_url')
                            ->label('Instagram')
                            ->url()
                            ->maxLength(255),
                        TextInput::make('linkedin_url')
                            ->label('LinkedIn')
                            ->url()
                            ->maxLength(255),
                        TextInput::make('website_url')
                            ->label('Website')
                            ->url()
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public function save(): void
    {
        $user = auth()->user();

        abort_unless($user, 403);

        $oldAvatar = $user->avatar;

        $data = Arr::only($this->form->getState(), [
            'avatar',
            'name',
            'username',
            'phone',
            'gender',
            'birth_date',
            'address',
            'bio',
            'instagram_url',
            'linkedin_url',
            'website_url',
        ]);

        $user->update($data);

        if (filled($oldAvatar) && $oldAvatar !== ($data['avatar'] ?? null)) {
            Storage::disk('public')->delete($oldAvatar);
        }

        auth()->setUser($user->refresh());

        Notification::make()
            ->title('Profile updated')
            ->body('Data profil kamu berhasil diperbarui.')
            ->success()
            ->send();

        $this->redirect(MyProfile::getUrl());
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Back to Profile')
                ->icon('heroicon-o-arrow-left')
                ->url(MyProfile::getUrl())
                ->color('gray'),
        ];
    }
}
