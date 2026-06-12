<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceEventResource\Pages\CreateAttendanceEvent;
use App\Filament\Resources\AttendanceEventResource\Pages\EditAttendanceEvent;
use App\Filament\Resources\AttendanceEventResource\Pages\ListAttendanceEvents;
use App\Models\AttendanceEvent;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
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

class AttendanceEventResource extends Resource
{
    protected static ?string $model = AttendanceEvent::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-qr-code';

    protected static string|\UnitEnum|null $navigationGroup = 'Attendance';

    protected static ?string $navigationLabel = 'Events';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Event details')
                ->description('Create a meeting or activity. The assigned officer is automatically set to the current user.')
                ->schema([
                    TextInput::make('title')->required()->maxLength(255),
                    Select::make('activity_type')
                        ->options(self::activityTypeOptions())
                        ->default('meeting')
                        ->required(),
                    TextInput::make('location')->maxLength(255),
                    Placeholder::make('assigned_officer')
                        ->label('Assigned officer')
                        ->content(fn (?AttendanceEvent $record): string => $record?->assignee?->name ?? auth()->user()?->name ?? '-'),
                    RichEditor::make('description')->columnSpanFull(),
                ])->columns(2),

            Section::make('Schedule')
                ->schema([
                    DateTimePicker::make('starts_at')->required()->seconds(false),
                    DateTimePicker::make('ends_at')->seconds(false),
                    DateTimePicker::make('check_in_opens_at')->seconds(false),
                    DateTimePicker::make('check_in_closes_at')->seconds(false),
                    Toggle::make('is_active')->default(true)->required(),
                ])->columns(2),

            Section::make('QR check-in')
                ->description('This token is generated automatically. The QR code is available after saving.')
                ->schema([
                    TextInput::make('qr_token')
                        ->disabled()
                        ->dehydrated(false),
                    Textarea::make('check_in_url')
                        ->label('Check-in URL')
                        ->formatStateUsing(fn (?AttendanceEvent $record): ?string => $record?->checkInUrl())
                        ->disabled()
                        ->dehydrated(false)
                        ->helperText('Open the QR image at: /attendance/{token}/qr.svg')
                        ->columnSpanFull(),
                    Placeholder::make('qr_preview')
                        ->label('QR preview')
                        ->content(fn (?AttendanceEvent $record): HtmlString => new HtmlString(
                            $record
                                ? '<img src="' . e($record->qrCodeDataUri()) . '" alt="Attendance QR" style="width: 280px; max-width: 100%;" />'
                                : 'Save the event first to generate the QR code.',
                        )),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('activity_type')->badge()->formatStateUsing(fn (string $state): string => self::activityTypeOptions()[$state] ?? $state),
                TextColumn::make('starts_at')->dateTime()->sortable(),
                TextColumn::make('assignee.name')->label('Officer')->toggleable(),
                TextColumn::make('records_count')->counts('records')->label('Attendance')->sortable(),
                IconColumn::make('is_active')->boolean()->sortable(),
            ])
            ->filters([
                SelectFilter::make('activity_type')->options(self::activityTypeOptions()),
                TernaryFilter::make('is_active'),
            ])
            ->defaultSort('starts_at', 'desc')
            ->recordActions([
                EditAction::make()
                    ->visible(fn (AttendanceEvent $record): bool => self::canManageRecord($record))
                    ->url(fn (AttendanceEvent $record): string => self::getUrl('edit', ['record' => $record])),
                DeleteAction::make()
                    ->visible(fn (AttendanceEvent $record): bool => self::canManageRecord($record)),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if (! $user || $user->isAdmin()) {
            return $query;
        }

        return $query->where('created_by', $user->id);
    }

    public static function canEdit(Model $record): bool
    {
        return $record instanceof AttendanceEvent && self::canManageRecord($record);
    }

    public static function canCreate(): bool
    {
        return auth()->check();
    }

    public static function canDelete(Model $record): bool
    {
        return $record instanceof AttendanceEvent && self::canManageRecord($record);
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function canManageRecord(AttendanceEvent $record): bool
    {
        $user = auth()->user();

        if (! $user) {
            return false;
        }

        return $user->isAdmin()
            || (int) $record->created_by === (int) $user->id
            || (int) $record->assigned_to === (int) $user->id;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAttendanceEvents::route('/'),
            'create' => CreateAttendanceEvent::route('/create'),
            'edit' => EditAttendanceEvent::route('/{record}/edit'),
        ];
    }

    public static function activityTypeOptions(): array
    {
        return [
            'meeting' => 'Meeting',
            'seminar' => 'Seminar',
            'workshop' => 'Workshop',
            'committee' => 'Committee',
            'training' => 'Training',
            'event' => 'Event',
            'other' => 'Other',
        ];
    }
}
