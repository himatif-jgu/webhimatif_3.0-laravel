<?php

namespace App\Filament\Pages;

use App\Models\AttendanceEvent;
use App\Models\AttendanceRecord;
use App\Models\User;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class AttendanceScanner extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-camera';

    protected static string|\UnitEnum|null $navigationGroup = 'Attendance';

    protected static ?string $navigationLabel = 'Scanner';

    protected static ?int $navigationSort = 30;

    protected string $view = 'filament.pages.attendance-scanner';

    public ?array $data = [];

    public ?int $selectedEventId = null;

    public ?string $selectedEventTitle = null;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function canAccess(): bool
    {
        $user = auth()->user();

        if (! $user) {
            return false;
        }

        return $user->isAdmin()
            || AttendanceEvent::query()
                ->where(fn (Builder $query): Builder => $query
                    ->where('created_by', $user->id)
                    ->orWhere('assigned_to', $user->id))
                ->where('is_active', true)
                ->exists();
    }

    public function mount(): void
    {
        $eventId = request()->integer('event') ?: null;
        $event = $eventId ? $this->eventQuery()->find($eventId) : null;

        if ($eventId && ! $event) {
            abort(403);
        }

        $this->selectedEventId = $event?->id;
        $this->selectedEventTitle = $event?->title;

        $this->form->fill([
            'attendance_event_id' => $event?->id,
            'checked_in_at' => now()->format('Y-m-d H:i'),
            'status' => 'present',
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Hidden::make('attendance_event_id')
                    ->visible(fn (): bool => filled($this->selectedEventId)),
                Placeholder::make('selected_event')
                    ->label('Event')
                    ->content(fn (): string => $this->selectedEventTitle ?? '-')
                    ->visible(fn (): bool => filled($this->selectedEventId)),
                Select::make('attendance_event_id')
                    ->label('Event')
                    ->options(fn (): array => $this->eventQuery()
                        ->pluck('title', 'id')
                        ->all())
                    ->searchable()
                    ->required()
                    ->visible(fn (): bool => blank($this->selectedEventId)),
                TextInput::make('scan_payload')
                    ->label('QR card / NPM')
                    ->helperText('Scan kartu anggota atau ketik NPM. Sistem akan mengambil angka NPM dari isi QR.')
                    ->required()
                    ->autofocus(),
                Select::make('status')
                    ->options([
                        'present' => 'Present',
                        'late' => 'Late',
                        'excused' => 'Excused',
                    ])
                    ->default('present')
                    ->required(),
                Textarea::make('notes')
                    ->rows(3)
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }

    public function submit(): void
    {
        $state = $this->form->getState();
        $npm = $this->extractNpm($state['scan_payload']);

        if (blank($npm)) {
            Notification::make()
                ->title('QR tidak valid')
                ->body('Isi QR tidak memuat NPM yang bisa dibaca.')
                ->danger()
                ->send();

            return;
        }

        $event = $this->eventQuery()->findOrFail($state['attendance_event_id']);
        $user = User::where('npm', $npm)->first();

        AttendanceRecord::updateOrCreate(
            [
                'attendance_event_id' => $event->id,
                'npm' => $npm,
            ],
            [
                'user_id' => $user?->id,
                'attendee_name' => $user?->name,
                'status' => $state['status'],
                'source' => 'card_qr',
                'checked_in_at' => now(),
                'checked_in_by' => auth()->id(),
                'notes' => $state['notes'] ?? null,
            ],
        );

        Notification::make()
            ->title('Absensi tercatat')
            ->body(($user?->name ?? $npm) . ' berhasil dicatat untuk ' . $event->title . '.')
            ->success()
            ->send();

        $this->form->fill([
            'attendance_event_id' => $event->id,
            'status' => $state['status'],
            'scan_payload' => '',
            'notes' => null,
        ]);
    }

    private function extractNpm(string $payload): ?string
    {
        $payload = trim($payload);

        if (preg_match('/(?:npm|nim|student_number|studentNumber)\s*[:=]\s*([A-Za-z0-9.-]+)/i', $payload, $matches)) {
            return $matches[1];
        }

        if (preg_match('/[A-Za-z0-9.-]{6,}/', $payload, $matches)) {
            return Str::upper($matches[0]);
        }

        return null;
    }

    private function eventQuery(): Builder
    {
        $query = AttendanceEvent::query()
            ->where('is_active', true)
            ->orderByDesc('starts_at');

        if (! auth()->user()?->isAdmin()) {
            $query->where(fn (Builder $eventQuery): Builder => $eventQuery
                ->where('created_by', auth()->id())
                ->orWhere('assigned_to', auth()->id()));
        }

        return $query;
    }
}
