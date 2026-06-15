<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnnouncementResource\Pages\CreateAnnouncement;
use App\Filament\Resources\AnnouncementResource\Pages\EditAnnouncement;
use App\Filament\Resources\AnnouncementResource\Pages\ListAnnouncements;
use App\Models\Announcement;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-megaphone';

    protected static string|\UnitEnum|null $navigationGroup = 'CMS Landing Page';

    protected static ?string $navigationLabel = 'Announcements';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Announcement')
                ->description('Write a clear announcement with a short summary for landing page and dashboard cards.')
                ->schema([
                    TextInput::make('title')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('slug')
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),
                    Select::make('category')
                        ->options(self::categoryOptions())
                        ->default('general')
                        ->required(),
                    Select::make('visibility')
                        ->label('Display location')
                        ->options(self::visibilityOptions())
                        ->default('public')
                        ->required()
                        ->helperText('Landing Page & Dashboard: tampil di website publik dan dashboard app. Landing Page only: hanya di website publik. Dashboard only: hanya di dashboard user login.'),
                    Select::make('audience')
                        ->options(self::audienceOptions())
                        ->default('all')
                        ->required(),
                    Textarea::make('summary')
                        ->maxLength(500)
                        ->rows(3)
                        ->helperText('Max 500 characters. Used in landing page cards and dashboard previews.')
                        ->columnSpanFull(),
                    RichEditor::make('content')
                        ->required()
                        ->columnSpanFull(),
                    FileUpload::make('image')
                        ->label('Cover image')
                        ->image()
                        ->disk('public')
                        ->directory('announcements')
                        ->visibility('public')
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->maxSize(2048)
                        ->helperText('Recommended 1200 x 675 px, JPG/PNG/WebP, max 2 MB. This image is used on the landing page carousel.')
                        ->columnSpanFull(),
                ])->columns(2),

            Section::make('Publishing')
                ->schema([
                    Toggle::make('is_pinned')
                        ->label('Pin announcement')
                        ->helperText('Pinned announcements appear first. Keep only the most important items pinned.'),
                    Toggle::make('is_published')
                        ->label('Published')
                        ->default(false)
                        ->required(),
                    DateTimePicker::make('published_at')
                        ->seconds(false)
                        ->timezone(config('app.timezone'))
                        ->helperText('Required for the announcement to be visible publicly.'),
                    DateTimePicker::make('expires_at')
                        ->seconds(false)
                        ->timezone(config('app.timezone'))
                        ->helperText('Optional. Leave empty if the announcement should not expire.'),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Cover')
                    ->disk('public')
                    ->square()
                    ->toggleable(),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(45),
                TextColumn::make('category')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => self::categoryOptions()[$state] ?? $state)
                    ->sortable(),
                TextColumn::make('visibility')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => self::visibilityOptions()[$state] ?? $state),
                TextColumn::make('audience')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => self::audienceOptions()[$state] ?? $state)
                    ->toggleable(),
                IconColumn::make('is_pinned')
                    ->label('Pinned')
                    ->boolean()
                    ->sortable(),
                IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('published_at')
                    ->dateTime(timezone: config('app.timezone'))
                    ->sortable(),
                TextColumn::make('expires_at')
                    ->dateTime(timezone: config('app.timezone'))
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('creator.name')
                    ->label('Created by')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')->options(self::categoryOptions()),
                SelectFilter::make('visibility')->options(self::visibilityOptions()),
                TernaryFilter::make('is_pinned'),
                TernaryFilter::make('is_published'),
            ])
            ->defaultSort('published_at', 'desc')
            ->recordActions([
                EditAction::make()
                    ->url(fn (Announcement $record): string => self::getUrl('edit', ['record' => $record])),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return self::canManageAnnouncements();
    }

    public static function canViewAny(): bool
    {
        return self::canManageAnnouncements();
    }

    public static function canCreate(): bool
    {
        return self::canManageAnnouncements();
    }

    public static function canEdit(Model $record): bool
    {
        return self::canManageAnnouncements();
    }

    public static function canDelete(Model $record): bool
    {
        return self::canManageAnnouncements();
    }

    public static function canDeleteAny(): bool
    {
        return self::canManageAnnouncements();
    }

    public static function canManageAnnouncements(): bool
    {
        return (bool) auth()->user()?->can('manage_announcements');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAnnouncements::route('/'),
            'create' => CreateAnnouncement::route('/create'),
            'edit' => EditAnnouncement::route('/{record}/edit'),
        ];
    }

    public static function categoryOptions(): array
    {
        return [
            'general' => 'General',
            'academic' => 'Academic',
            'event' => 'Event',
            'recruitment' => 'Recruitment',
            'urgent' => 'Urgent',
            'division' => 'Division',
        ];
    }

    public static function visibilityOptions(): array
    {
        return [
            'public' => 'Landing Page & Dashboard',
            'landing_only' => 'Landing Page only',
            'dashboard_only' => 'Dashboard only',
        ];
    }

    public static function audienceOptions(): array
    {
        return [
            'all' => 'All',
            'members' => 'Members',
            'officers' => 'Officers',
            'department_heads' => 'Department Heads',
        ];
    }
}
