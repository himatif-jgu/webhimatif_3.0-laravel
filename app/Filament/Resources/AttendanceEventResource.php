<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceEventResource\Pages\CreateAttendanceEvent;
use App\Filament\Resources\AttendanceEventResource\Pages\EditAttendanceEvent;
use App\Filament\Resources\AttendanceEventResource\Pages\ListAttendanceEvents;
use App\Filament\Pages\AttendanceScanner;
use App\Models\AttendanceEvent;
use Filament\Actions\Action;
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
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Js;

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
                    DateTimePicker::make('starts_at')->required()->seconds(false)->timezone(config('app.timezone')),
                    DateTimePicker::make('ends_at')->seconds(false)->timezone(config('app.timezone')),
                    DateTimePicker::make('check_in_opens_at')->seconds(false)->timezone(config('app.timezone')),
                    DateTimePicker::make('check_in_closes_at')->seconds(false)->timezone(config('app.timezone')),
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
                        ->helperText('Bagikan QR atau link check-in ke peserta. Peserta yang belum login akan diarahkan login dulu.')
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
                TextColumn::make('starts_at')->dateTime(timezone: config('app.timezone'))->sortable(),
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
                Action::make('scanner')
                    ->label('Scanner')
                    ->icon('heroicon-o-camera')
                    ->url(fn (AttendanceEvent $record): string => AttendanceScanner::getUrl(['event' => $record->id]))
                    ->visible(fn (AttendanceEvent $record): bool => $record->is_active && self::canManageRecord($record)),
                Action::make('attendees')
                    ->label('Attendees')
                    ->icon('heroicon-o-users')
                    ->modalHeading(fn (AttendanceEvent $record): string => 'Attendance list - ' . $record->title)
                    ->modalWidth('6xl')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->modalContent(fn (AttendanceEvent $record): HtmlString => self::attendanceRecordsModalContent($record)),
                Action::make('exportPdf')
                    ->label('Export PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->url(fn (AttendanceEvent $record): string => route('attendance-events.export-pdf', $record))
                    ->openUrlInNewTab()
                    ->visible(fn (AttendanceEvent $record): bool => self::canManageRecord($record)),
                Action::make('viewQr')
                    ->label('View QR')
                    ->icon('heroicon-o-qr-code')
                    ->modalHeading(fn (AttendanceEvent $record): string => $record->title)
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->modalContent(fn (AttendanceEvent $record): HtmlString => self::qrModalContent($record)),
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

    public static function qrModalContent(AttendanceEvent $record): HtmlString
    {
        return new HtmlString(
            '<div style="display:grid; gap:1rem;">' .
            '<div style="display:flex; justify-content:center; border:1px solid #e5e7eb; border-radius:14px; padding:1rem; background:#fff;">' .
            '<img src="' . e($record->qrCodeDataUri()) . '" alt="' . e($record->title) . '" style="width:320px; max-width:100%; height:auto;" />' .
            '</div>' .
            '<div style="display:grid; gap:.35rem;">' .
            '<strong style="display:inline-block; width:max-content; border-radius:6px; background:#111827; color:#ffffff; padding:.18rem .45rem;">Check-in URL</strong>' .
            '<div style="display:flex; gap:.5rem; align-items:center; flex-wrap:wrap;">' .
            '<a href="' . e($record->checkInUrl()) . '" target="_blank" rel="noopener noreferrer" style="word-break:break-all; color:#d97706;">' . e($record->checkInUrl()) . '</a>' .
            '<button type="button" x-on:click="window.navigator.clipboard.writeText(' . e(Js::from($record->checkInUrl())) . '); $tooltip(&quot;Check-in URL disalin&quot;, { timeout: 1500 });" style="border:1px solid #d1d5db; border-radius:8px; background:#fff; color:#111827; padding:.35rem .65rem; font-weight:600;">Salin</button>' .
            '</div>' .
            '</div>' .
            '<div style="display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:.75rem;">' .
            '<div style="border-radius:10px; background:#f8fafc; color:#111827; padding:.85rem;"><strong>Jenis</strong><br>' . e(self::activityTypeOptions()[$record->activity_type] ?? $record->activity_type) . '</div>' .
            '<div style="border-radius:10px; background:#f8fafc; color:#111827; padding:.85rem;"><strong>Lokasi</strong><br>' . e($record->location ?: '-') . '</div>' .
            '<div style="border-radius:10px; background:#f8fafc; color:#111827; padding:.85rem;"><strong>Mulai</strong><br>' . e($record->starts_at?->format('d M Y H:i') ?: '-') . '</div>' .
            '<div style="border-radius:10px; background:#f8fafc; color:#111827; padding:.85rem;"><strong>Tenggat</strong><br>' . e(($record->check_in_closes_at ?? $record->ends_at)?->format('d M Y H:i') ?: '-') . '</div>' .
            '</div>' .
            '</div>',
        );
    }

    public static function attendanceRecordsModalContent(AttendanceEvent $record): HtmlString
    {
        $records = $record->records()
            ->with(['user.teamUnit', 'user.roles', 'checkedInBy'])
            ->orderByDesc('checked_in_at')
            ->orderBy('attendee_name')
            ->get();

        if ($records->isEmpty()) {
            return new HtmlString(
                '<div style="border:1px dashed #d1d5db; border-radius:14px; padding:1.25rem; color:#475569; background:#f8fafc;">' .
                '<strong style="display:block; color:#111827; margin-bottom:.25rem;">Belum ada peserta yang absen.</strong>' .
                'Data peserta akan muncul otomatis setelah user melakukan check-in lewat QR atau dicatat lewat scanner/manual input.' .
                '</div>',
            );
        }

        return new HtmlString(
            '<div style="display:grid; gap:1rem;">' .
            '<div style="display:flex; justify-content:space-between; gap:1rem; flex-wrap:wrap; align-items:flex-start;">' .
            '<div>' .
            '<div style="font-size:.8rem; text-transform:uppercase; letter-spacing:.06em; color:#64748b; font-weight:700;">Total hadir</div>' .
            '<div style="font-size:1.75rem; line-height:1; font-weight:800; color:#111827;">' . e((string) $records->count()) . ' peserta</div>' .
            '</div>' .
            '<a href="' . e(route('attendance-events.export-pdf', $record)) . '" target="_blank" rel="noopener noreferrer" style="border-radius:10px; background:#111827; color:#fff; padding:.65rem .9rem; font-weight:700; text-decoration:none;">Export PDF</a>' .
            '</div>' .
            '<div style="overflow-x:auto; border:1px solid #e5e7eb; border-radius:14px;">' .
            '<table style="width:100%; border-collapse:collapse; min-width:860px; font-size:.88rem;">' .
            '<thead><tr style="background:#f8fafc; color:#334155; text-align:left;">' .
            '<th style="padding:.75rem; border-bottom:1px solid #e5e7eb;">No</th>' .
            '<th style="padding:.75rem; border-bottom:1px solid #e5e7eb;">Nama</th>' .
            '<th style="padding:.75rem; border-bottom:1px solid #e5e7eb;">NPM</th>' .
            '<th style="padding:.75rem; border-bottom:1px solid #e5e7eb;">Jabatan</th>' .
            '<th style="padding:.75rem; border-bottom:1px solid #e5e7eb;">Divisi</th>' .
            '<th style="padding:.75rem; border-bottom:1px solid #e5e7eb;">Status</th>' .
            '<th style="padding:.75rem; border-bottom:1px solid #e5e7eb;">Waktu</th>' .
            '<th style="padding:.75rem; border-bottom:1px solid #e5e7eb;">Dicatat oleh</th>' .
            '</tr></thead>' .
            '<tbody>' . self::attendanceRowsHtml($records) . '</tbody>' .
            '</table>' .
            '</div>' .
            '</div>',
        );
    }

    private static function attendanceRowsHtml(Collection $records): string
    {
        return $records->map(function ($record, int $index): string {
            $user = $record->user;
            $roles = $user?->roles?->pluck('name')->map(fn (string $role): string => str($role)->replace('_', ' ')->title())->implode(', ');

            return '<tr>' .
                '<td style="padding:.75rem; border-bottom:1px solid #eef2f7; color:#64748b;">' . e((string) ($index + 1)) . '</td>' .
                '<td style="padding:.75rem; border-bottom:1px solid #eef2f7; font-weight:700; color:#111827;">' . e($record->attendee_name ?: $user?->name ?: '-') . '</td>' .
                '<td style="padding:.75rem; border-bottom:1px solid #eef2f7; color:#111827;">' . e($record->npm ?: $user?->npm ?: '-') . '</td>' .
                '<td style="padding:.75rem; border-bottom:1px solid #eef2f7; color:#334155;">' . e($roles ?: '-') . '</td>' .
                '<td style="padding:.75rem; border-bottom:1px solid #eef2f7; color:#334155;">' . e($user?->teamUnit?->name ?: '-') . '</td>' .
                '<td style="padding:.75rem; border-bottom:1px solid #eef2f7; color:#166534; font-weight:700;">' . e(str($record->status)->replace('_', ' ')->title()) . '</td>' .
                '<td style="padding:.75rem; border-bottom:1px solid #eef2f7; color:#334155;">' . e($record->checked_in_at?->format('d M Y H:i') ?: '-') . '</td>' .
                '<td style="padding:.75rem; border-bottom:1px solid #eef2f7; color:#334155;">' . e($record->checkedInBy?->name ?: '-') . '</td>' .
                '</tr>';
        })->implode('');
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
