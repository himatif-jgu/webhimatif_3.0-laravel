<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages\CreateRole;
use App\Filament\Resources\RoleResource\Pages\EditRole;
use App\Filament\Resources\RoleResource\Pages\ListRoles;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Spatie\Permission\Models\Role;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-shield-check';

    protected static string|\UnitEnum|null $navigationGroup = 'Access Control';

    protected static ?string $navigationLabel = 'Roles';

    protected static ?int $navigationSort = 20;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Role')
                ->description('Use stable role names because they are used for admin access rules.')
                ->schema([
                    TextInput::make('name')
                        ->label('Role key')
                        ->helperText('Disimpan sebagai slug stabil, contoh: wakil_ketua. Di dropdown user akan tampil sebagai Wakil Ketua.')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),
                    Hidden::make('guard_name')
                        ->default('web'),
                    Select::make('permissions')
                        ->relationship('permissions', 'name')
                        ->multiple()
                        ->preload()
                        ->searchable()
                        ->columnSpanFull(),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn (string $state): string => self::formatRoleName($state)),
                TextColumn::make('users_count')
                    ->counts('users')
                    ->label('Users')
                    ->sortable(),
                TextColumn::make('permissions.name')
                    ->badge()
                    ->separator(',')
                    ->label('Permissions')
                    ->limitList(3)
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                EditAction::make()
                    ->url(fn (Role $record): string => self::getUrl('edit', ['record' => $record])),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRoles::route('/'),
            'create' => CreateRole::route('/create'),
            'edit' => EditRole::route('/{record}/edit'),
        ];
    }

    public static function formatRoleName(string $name): string
    {
        return str($name)
            ->replace('_', ' ')
            ->title()
            ->toString();
    }
}
