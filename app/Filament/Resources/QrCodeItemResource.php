<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QrCodeItemResource\Pages\CreateQrCodeItem;
use App\Filament\Resources\QrCodeItemResource\Pages\EditQrCodeItem;
use App\Filament\Resources\QrCodeItemResource\Pages\ListQrCodeItems;
use App\Models\QrCodeItem;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\ColorPicker;
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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

class QrCodeItemResource extends Resource
{
    protected static ?string $model = QrCodeItem::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-qr-code';

    protected static string|\UnitEnum|null $navigationGroup = 'Utilities';

    protected static ?string $navigationLabel = 'QR Generator';

    protected static ?int $navigationSort = 20;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('QR content')
                ->description('Generate reusable QR codes for links, text, contact details, or Wi-Fi access.')
                ->schema([
                    TextInput::make('title')
                        ->required()
                        ->maxLength(255),
                    Select::make('type')
                        ->options(self::typeOptions())
                        ->default('url')
                        ->required(),
                    Textarea::make('payload')
                        ->label('QR payload')
                        ->required()
                        ->rows(5)
                        ->maxLength(4096)
                        ->helperText('For URL QR, paste the full URL. For Wi-Fi use: WIFI:T:WPA;S:NetworkName;P:Password;;')
                        ->columnSpanFull(),
                    Toggle::make('is_active')
                        ->default(true)
                        ->required(),
                ])->columns(2),

            Section::make('Output')
                ->description('Recommended size: 320px. Maximum saved payload is 4KB to keep QR generation efficient.')
                ->schema([
                    ColorPicker::make('foreground_color')
                        ->default('#111827'),
                    ColorPicker::make('background_color')
                        ->default('#ffffff'),
                    TextInput::make('size')
                        ->numeric()
                        ->minValue(160)
                        ->maxValue(800)
                        ->default(320)
                        ->required()
                        ->helperText('Allowed range: 160-800 px.'),
                    Placeholder::make('image_url')
                        ->label('SVG URL')
                        ->content(fn (?QrCodeItem $record): string => $record?->imageUrl() ?? 'Save first to generate the image URL.'),
                    Placeholder::make('qr_preview')
                        ->label('QR preview')
                        ->content(fn (?QrCodeItem $record): HtmlString => new HtmlString(
                            $record
                                ? '<img src="' . e($record->qrCodeSvgDataUri()) . '" alt="Generated QR" style="width: ' . e((string) min($record->size, 320)) . 'px; max-width: 100%;" />'
                                : 'Save first to generate the QR code.',
                        ))
                        ->columnSpanFull(),
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
                    ->limit(45),
                TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => self::typeOptions()[$state] ?? $state),
                TextColumn::make('image_url')
                    ->label('SVG URL')
                    ->state(fn (QrCodeItem $record): string => $record->imageUrl())
                    ->copyable()
                    ->limit(45),
                TextColumn::make('views_count')
                    ->numeric()
                    ->sortable()
                    ->label('Views'),
                TextColumn::make('user.name')
                    ->label('Owner')
                    ->toggleable(),
                IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')->options(self::typeOptions()),
                TernaryFilter::make('is_active'),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                EditAction::make()
                    ->visible(fn (QrCodeItem $record): bool => self::canManageRecord($record))
                    ->url(fn (QrCodeItem $record): string => self::getUrl('edit', ['record' => $record])),
                DeleteAction::make()
                    ->visible(fn (QrCodeItem $record): bool => self::canManageRecord($record)),
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
        return $record instanceof QrCodeItem && self::canManageRecord($record);
    }

    public static function canDelete(Model $record): bool
    {
        return $record instanceof QrCodeItem && self::canManageRecord($record);
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function canManageRecord(QrCodeItem $record): bool
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
            'index' => ListQrCodeItems::route('/'),
            'create' => CreateQrCodeItem::route('/create'),
            'edit' => EditQrCodeItem::route('/{record}/edit'),
        ];
    }

    public static function typeOptions(): array
    {
        return [
            'url' => 'URL',
            'text' => 'Text',
            'email' => 'Email',
            'phone' => 'Phone',
            'wifi' => 'Wi-Fi',
            'vcard' => 'vCard',
        ];
    }
}
