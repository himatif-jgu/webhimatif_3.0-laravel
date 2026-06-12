<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Resources\UserResource\Pages\ViewUser;
use App\Models\TeamUnit;
use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-users';

    protected static string|\UnitEnum|null $navigationGroup = 'Access Control';

    protected static ?string $navigationLabel = 'Users';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Account')
                ->description('Give each person the least role they need for their work.')
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('username')
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),
                    TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),
                    TextInput::make('password')
                        ->password()
                        ->revealable()
                        ->required(fn (string $operation): bool => $operation === 'create')
                        ->dehydrated(fn (?string $state): bool => filled($state))
                        ->helperText('Leave blank when you do not want to change the password.'),
                    Select::make('roles')
                        ->relationship('roles', 'name')
                        ->getOptionLabelFromRecordUsing(fn (Role $record): string => self::formatRoleName($record->name))
                        ->multiple()
                        ->preload()
                        ->searchable()
                        ->required()
                        ->visible(fn (): bool => (bool) auth()->user()?->isAdmin()),
                    Select::make('permissions')
                        ->relationship('permissions', 'name')
                        ->multiple()
                        ->preload()
                        ->searchable()
                        ->helperText('Use direct permissions only for exceptions. Prefer assigning permissions through roles.')
                        ->visible(fn (): bool => (bool) auth()->user()?->isAdmin()),
                    Toggle::make('is_active')
                        ->default(true)
                        ->required()
                        ->visible(fn (): bool => (bool) auth()->user()?->isAdmin()),
                ])->columns(2),

            Section::make('Profile')
                ->schema([
                    FileUpload::make('avatar')
                        ->image()
                        ->disk('public')
                        ->directory('users/avatars')
                        ->visibility('public'),
                    TextInput::make('npm')
                        ->label('NPM')
                        ->maxLength(255),
                    TextInput::make('batch_year')
                        ->label('Batch year')
                        ->numeric()
                        ->minValue(2000)
                        ->maxValue(2100),
                    Select::make('team_unit_id')
                        ->label('Division / Department')
                        ->options(fn (): array => self::divisionOptions())
                        ->searchable()
                        ->helperText('Role menentukan jabatan, field ini menentukan divisi/departemennya.'),
                    Select::make('gender')
                        ->options([
                            'male' => 'Male',
                            'female' => 'Female',
                        ]),
                    DatePicker::make('birth_date'),
                    TextInput::make('phone')
                        ->tel()
                        ->maxLength(255),
                    Textarea::make('address')
                        ->rows(3)
                        ->columnSpanFull(),
                    Textarea::make('bio')
                        ->rows(3)
                        ->columnSpanFull(),
                ])->columns(3),

            Section::make('Social links')
                ->schema([
                    TextInput::make('instagram_url')
                        ->url()
                        ->maxLength(255),
                    TextInput::make('linkedin_url')
                        ->url()
                        ->maxLength(255),
                    TextInput::make('website_url')
                        ->url()
                        ->maxLength(255),
                ])->columns(3),
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Profile')
                ->schema([
                    ImageEntry::make('avatar')
                        ->disk('public')
                        ->circular()
                        ->hiddenLabel(),
                    TextEntry::make('name'),
                    TextEntry::make('email'),
                    TextEntry::make('username')
                        ->placeholder('-'),
                    TextEntry::make('npm')
                        ->label('NPM')
                        ->placeholder('-'),
                    TextEntry::make('batch_year')
                        ->label('Batch year')
                        ->placeholder('-'),
                    TextEntry::make('teamUnit.name')
                        ->label('Division')
                        ->placeholder('-'),
                    TextEntry::make('roles.name')
                        ->label('Roles')
                        ->badge()
                        ->separator(',')
                        ->formatStateUsing(fn (string $state): string => self::formatRoleName($state)),
                    IconEntry::make('is_active')
                        ->label('Active')
                        ->boolean(),
                ])->columns(3),

            Section::make('Personal Information')
                ->schema([
                    TextEntry::make('gender')
                        ->placeholder('-')
                        ->formatStateUsing(fn (?string $state): string => $state ? str($state)->title()->toString() : '-'),
                    TextEntry::make('birth_date')
                        ->date()
                        ->placeholder('-'),
                    TextEntry::make('phone')
                        ->placeholder('-'),
                    TextEntry::make('address')
                        ->placeholder('-')
                        ->columnSpanFull(),
                    TextEntry::make('bio')
                        ->placeholder('-')
                        ->columnSpanFull(),
                ])->columns(3),

            Section::make('Social Links')
                ->schema([
                    TextEntry::make('instagram_url')
                        ->label('Instagram')
                        ->url(fn (?string $state): ?string => $state)
                        ->openUrlInNewTab()
                        ->placeholder('-'),
                    TextEntry::make('linkedin_url')
                        ->label('LinkedIn')
                        ->url(fn (?string $state): ?string => $state)
                        ->openUrlInNewTab()
                        ->placeholder('-'),
                    TextEntry::make('website_url')
                        ->label('Website')
                        ->url(fn (?string $state): ?string => $state)
                        ->openUrlInNewTab()
                        ->placeholder('-'),
                ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')
                    ->disk('public')
                    ->circular()
                    ->toggleable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('npm')
                    ->label('NPM')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('teamUnit.name')
                    ->label('Division')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('roles.name')
                    ->badge()
                    ->separator(',')
                    ->label('Roles')
                    ->formatStateUsing(fn (string $state): string => self::formatRoleName($state)),
                IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('last_seen_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('roles')
                    ->relationship('roles', 'name')
                    ->getOptionLabelFromRecordUsing(fn (Role $record): string => self::formatRoleName($record->name))
                    ->multiple(),
                SelectFilter::make('team_unit_id')
                    ->label('Division')
                    ->options(fn (): array => self::divisionOptions()),
                TernaryFilter::make('is_active'),
            ])
            ->recordActions([
                ViewAction::make()
                    ->visible(fn (User $record): bool => self::canView($record))
                    ->url(fn (User $record): string => self::getUrl('view', ['record' => $record])),
                EditAction::make()
                    ->visible(fn (User $record): bool => self::canEdit($record))
                    ->url(fn (User $record): string => self::getUrl('edit', ['record' => $record])),
                DeleteAction::make()
                    ->visible(fn (User $record): bool => self::canDelete($record)),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn (): bool => self::canDeleteAny()),
                ])->visible(fn (): bool => self::canDeleteAny()),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if (! $user || $user->isAdmin()) {
            return $query;
        }

        return $query->whereKey($user->id);
    }

    public static function canViewAny(): bool
    {
        return auth()->check();
    }

    public static function canCreate(): bool
    {
        return (bool) auth()->user()?->isAdmin();
    }

    public static function canView(Model $record): bool
    {
        return $record instanceof User && self::canManageProfile($record);
    }

    public static function canEdit(Model $record): bool
    {
        return $record instanceof User && self::canManageProfile($record);
    }

    public static function canDelete(Model $record): bool
    {
        return $record instanceof User
            && (bool) auth()->user()?->isAdmin()
            && (int) $record->id !== (int) auth()->id();
    }

    public static function canDeleteAny(): bool
    {
        return (bool) auth()->user()?->isAdmin();
    }

    public static function canManageProfile(User $record): bool
    {
        $user = auth()->user();

        if (! $user) {
            return false;
        }

        return $user->isAdmin() || (int) $record->id === (int) $user->id;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'view' => ViewUser::route('/{record}'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }

    public static function formatRoleName(string $name): string
    {
        return str($name)
            ->replace('_', ' ')
            ->title()
            ->toString();
    }

    public static function divisionOptions(): array
    {
        return TeamUnit::query()
            ->whereIn('slug', self::divisionSlugs())
            ->orderBy('sort_order')
            ->pluck('name', 'id')
            ->all();
    }

    public static function divisionSlugs(): array
    {
        return [
            'humas',
            'psda',
            'ristek',
            'danus',
            'medinfo',
        ];
    }
}
