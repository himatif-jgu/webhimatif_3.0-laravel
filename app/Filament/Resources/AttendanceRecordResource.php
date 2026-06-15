<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceRecordResource\Pages\CreateAttendanceRecord;
use App\Filament\Resources\AttendanceRecordResource\Pages\EditAttendanceRecord;
use App\Filament\Resources\AttendanceRecordResource\Pages\ListAttendanceRecords;
use App\Models\AttendanceEvent;
use App\Models\AttendanceRecord;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AttendanceRecordResource extends Resource
{
    protected static ?string $model = AttendanceRecord::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static string|\UnitEnum|null $navigationGroup = 'Attendance';

    protected static ?string $navigationLabel = 'Attendance History';

    protected static ?int $navigationSort = 20;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Attendance record')
                ->schema([
                    Select::make('attendance_event_id')
                        ->label('Event')
                        ->options(fn (): array => self::visibleEventQuery()
                            ->pluck('title', 'id')
                            ->all())
                        ->searchable()
                        ->required(),
                    Select::make('user_id')
                        ->label('User')
                        ->relationship('user', 'name')
                        ->searchable(['name', 'npm', 'email'])
                        ->preload()
                        ->afterStateUpdated(function ($state, callable $set): void {
                            $user = User::find($state);

                            if (! $user) {
                                return;
                            }

                            $set('npm', $user->npm);
                            $set('attendee_name', $user->name);
                        }),
                    TextInput::make('npm')->label('NPM')->required()->maxLength(255),
                    TextInput::make('attendee_name')->maxLength(255),
                    Select::make('status')
                        ->options([
                            'present' => 'Present',
                            'late' => 'Late',
                            'excused' => 'Excused',
                            'absent' => 'Absent',
                        ])
                        ->default('present')
                        ->required(),
                    Select::make('source')
                        ->options([
                            'self_qr' => 'Self QR',
                            'card_qr' => 'Card QR',
                            'manual' => 'Manual',
                        ])
                        ->default('manual')
                        ->required(),
                    DateTimePicker::make('checked_in_at')->default(now())->seconds(false)->timezone(config('app.timezone')),
                    Textarea::make('notes')->columnSpanFull(),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('event.title')->label('Event')->searchable()->sortable(),
                TextColumn::make('event.activity_type')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => $state ? str($state)->replace('_', ' ')->title()->toString() : '-')
                    ->toggleable(),
                TextColumn::make('event.location')->label('Location')->toggleable(),
                TextColumn::make('npm')->label('NPM')->searchable()->toggleable(),
                TextColumn::make('attendee_name')->label('Attendee')->searchable()->sortable()->toggleable(),
                TextColumn::make('status')->badge()->sortable(),
                TextColumn::make('source')->badge()->sortable(),
                TextColumn::make('checked_in_at')->dateTime(timezone: config('app.timezone'))->sortable(),
                TextColumn::make('checkedInBy.name')->label('Checked by')->toggleable(),
            ])
            ->filters([
                SelectFilter::make('attendance_event_id')
                    ->label('Event')
                    ->options(fn (): array => self::visibleEventQuery()
                        ->pluck('title', 'id')
                        ->all()),
                SelectFilter::make('status')->options([
                    'present' => 'Present',
                    'late' => 'Late',
                    'excused' => 'Excused',
                    'absent' => 'Absent',
                ]),
                SelectFilter::make('source')->options([
                    'self_qr' => 'Self QR',
                    'card_qr' => 'Card QR',
                    'manual' => 'Manual',
                ]),
            ])
            ->defaultSort('checked_in_at', 'desc')
            ->recordActions([
                EditAction::make()
                    ->visible(fn (AttendanceRecord $record): bool => self::canManageRecord($record))
                    ->url(fn (AttendanceRecord $record): string => self::getUrl('edit', ['record' => $record])),
                DeleteAction::make()
                    ->visible(fn (AttendanceRecord $record): bool => self::canManageRecord($record)),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if (! $user || $user->isAdmin()) {
            return $query;
        }

        return $query->where(function (Builder $recordQuery) use ($user): Builder {
            $recordQuery->where('user_id', $user->id);

            if (filled($user->npm)) {
                $recordQuery->orWhere('npm', $user->npm);
            }

            return $recordQuery;
        });
    }

    public static function canCreate(): bool
    {
        return (bool) auth()->user()?->isAdmin();
    }

    public static function canEdit(Model $record): bool
    {
        return $record instanceof AttendanceRecord && (bool) auth()->user()?->isAdmin();
    }

    public static function canDelete(Model $record): bool
    {
        return $record instanceof AttendanceRecord && (bool) auth()->user()?->isAdmin();
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function canManageRecord(AttendanceRecord $record): bool
    {
        $user = auth()->user();

        if (! $user) {
            return false;
        }

        return $user->isAdmin();
    }

    private static function visibleEventQuery(): Builder
    {
        $query = AttendanceEvent::query()->orderByDesc('starts_at');
        $user = auth()->user();

        return $query;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAttendanceRecords::route('/'),
            'create' => CreateAttendanceRecord::route('/create'),
            'edit' => EditAttendanceRecord::route('/{record}/edit'),
        ];
    }
}
