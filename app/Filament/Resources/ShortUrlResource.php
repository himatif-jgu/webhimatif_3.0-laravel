<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShortUrlResource\Pages\CreateShortUrl;
use App\Filament\Resources\ShortUrlResource\Pages\EditShortUrl;
use App\Filament\Resources\ShortUrlResource\Pages\ListShortUrls;
use App\Models\ShortUrl;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

class ShortUrlResource extends Resource
{
    protected static ?string $model = ShortUrl::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-link';

    protected static string|\UnitEnum|null $navigationGroup = 'Utilities';

    protected static ?string $navigationLabel = 'Short URLs';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Short URL')
                ->description('Create short links for HIMATIF campaigns, forms, and event materials.')
                ->schema([
                    TextInput::make('title')
                        ->label('Link title')
                        ->helperText('Nama link yang tampil di dashboard, bukan kode URL pendek.')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('original_url')
                        ->label('Destination URL')
                        ->helperText('URL tujuan yang akan dibuka saat short link diklik.')
                        ->url()
                        ->required()
                        ->maxLength(2048),
                    TextInput::make('code')
                        ->label('Short code')
                        ->helperText('Opsional. Kosongkan untuk auto-generate, contoh hasil: /s/rapat-himatif.')
                        ->maxLength(32)
                        ->regex('/^[A-Za-z0-9-]+$/')
                        ->unique(ignoreRecord: true),
                    Select::make('expires_preset')
                        ->label('Expiration')
                        ->dehydrated(false)
                        ->default('never')
                        ->live()
                        ->options([
                            'never' => 'Never expires',
                            '7_days' => 'Expires in 7 days',
                            '30_days' => 'Expires in 30 days',
                            '90_days' => 'Expires in 90 days',
                            'custom' => 'Custom date',
                        ])
                        ->afterStateUpdated(function ($state, callable $set): void {
                            $set('expires_at', match ($state) {
                                '7_days' => now()->addDays(7)->format('Y-m-d H:i:s'),
                                '30_days' => now()->addDays(30)->format('Y-m-d H:i:s'),
                                '90_days' => now()->addDays(90)->format('Y-m-d H:i:s'),
                                'never' => null,
                                default => null,
                            });
                        }),
                    DateTimePicker::make('expires_at')
                        ->label('Custom expires at')
                        ->seconds(false)
                        ->helperText('Kosongkan kalau expiration dipilih Never expires.'),
                    Textarea::make('description')
                        ->rows(3)
                        ->columnSpanFull(),
                    Toggle::make('is_active')
                        ->default(true)
                        ->required(),
                ])->columns(2),

            Section::make('Generated assets')
                ->schema([
                    Placeholder::make('short_url')
                        ->label('Short URL')
                        ->content(fn (?ShortUrl $record): string => $record?->shortUrl() ?? 'Save first to generate the URL.'),
                    Placeholder::make('destination')
                        ->label('Destination')
                        ->content(fn (?ShortUrl $record): string => $record?->original_url ?? 'Save first to show the destination.'),
                    Placeholder::make('qr_preview')
                        ->label('QR preview')
                        ->content(fn (?ShortUrl $record): HtmlString => new HtmlString(
                            $record
                                ? '<img src="' . e($record->qrCodeDataUri()) . '" alt="Short URL QR" style="width: 220px; max-width: 100%;" />'
                                : 'Save first to generate the QR code.',
                        )),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                TextColumn::make('code')
                    ->searchable()
                    ->copyable()
                    ->label('Code'),
                TextColumn::make('short_url')
                    ->label('Short URL')
                    ->state(fn (ShortUrl $record): string => $record->shortUrl())
                    ->copyable()
                    ->limit(45),
                TextColumn::make('clicks_count')
                    ->numeric()
                    ->sortable()
                    ->label('Clicks'),
                TextColumn::make('user.name')
                    ->label('Owner')
                    ->toggleable(),
                IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('expires_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                TernaryFilter::make('is_active'),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                EditAction::make()
                    ->visible(fn (ShortUrl $record): bool => self::canManageRecord($record))
                    ->url(fn (ShortUrl $record): string => self::getUrl('edit', ['record' => $record])),
                DeleteAction::make()
                    ->visible(fn (ShortUrl $record): bool => self::canManageRecord($record)),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if (! $user || $user->isAdmin()) {
            return $query;
        }

        return $query->where('user_id', $user->id);
    }

    public static function canCreate(): bool
    {
        return auth()->check();
    }

    public static function canEdit(Model $record): bool
    {
        return $record instanceof ShortUrl && self::canManageRecord($record);
    }

    public static function canDelete(Model $record): bool
    {
        return $record instanceof ShortUrl && self::canManageRecord($record);
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function canManageRecord(ShortUrl $record): bool
    {
        $user = auth()->user();

        if (! $user) {
            return false;
        }

        return $user->isAdmin() || (int) $record->user_id === (int) $user->id;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListShortUrls::route('/'),
            'create' => CreateShortUrl::route('/create'),
            'edit' => EditShortUrl::route('/{record}/edit'),
        ];
    }
}
