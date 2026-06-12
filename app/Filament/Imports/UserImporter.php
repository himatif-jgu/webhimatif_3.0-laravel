<?php

namespace App\Filament\Imports;

use App\Models\TeamUnit;
use App\Models\User;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserImporter extends Importer
{
    protected static ?string $model = User::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->requiredMapping()
                ->example('Budi Santoso')
                ->rules(['required', 'max:255']),
            ImportColumn::make('email')
                ->requiredMapping()
                ->example('budi.santoso@himatif-jgu.ac.id')
                ->rules(['required', 'email', 'max:255']),
            ImportColumn::make('username')
                ->example('budi_santoso')
                ->rules(['nullable', 'max:255']),
            ImportColumn::make('npm')
                ->label('NPM')
                ->example('230101001')
                ->rules(['nullable', 'max:255']),
            ImportColumn::make('password')
                ->sensitive()
                ->example('Himatif@2026')
                ->rules(['nullable', 'min:8', 'max:255'])
                ->fillRecordUsing(fn (): null => null),
            ImportColumn::make('roles')
                ->example('anggota_divisi')
                ->helperText('Pisahkan banyak role dengan koma. Contoh: anggota_divisi,sekretaris_1')
                ->rules(['nullable', 'max:255', self::rolesExistRule()])
                ->fillRecordUsing(fn (): null => null),
            ImportColumn::make('division')
                ->example('humas')
                ->helperText('Isi salah satu: humas, psda, ristek, danus, medinfo.')
                ->rules(['nullable', 'max:255', self::divisionExistsRule()])
                ->fillRecordUsing(fn (): null => null),
            ImportColumn::make('batch_year')
                ->label('Batch year')
                ->integer()
                ->example('2023')
                ->rules(['nullable', 'integer', 'min:2000', 'max:2100']),
            ImportColumn::make('phone')
                ->example('081234567890')
                ->rules(['nullable', 'max:255']),
            ImportColumn::make('gender')
                ->example('male')
                ->rules(['nullable', 'in:male,female']),
            ImportColumn::make('birth_date')
                ->example('2004-08-17')
                ->rules(['nullable', 'date']),
            ImportColumn::make('address')
                ->example('Depok')
                ->rules(['nullable', 'max:1000']),
            ImportColumn::make('bio')
                ->example('Mahasiswa Teknik Informatika JGU.')
                ->rules(['nullable', 'max:1000']),
            ImportColumn::make('instagram_url')
                ->example('https://instagram.com/username')
                ->rules(['nullable', 'url', 'max:255']),
            ImportColumn::make('linkedin_url')
                ->example('https://www.linkedin.com/in/username')
                ->rules(['nullable', 'url', 'max:255']),
            ImportColumn::make('website_url')
                ->example('https://example.com')
                ->rules(['nullable', 'url', 'max:255']),
            ImportColumn::make('is_active')
                ->boolean()
                ->example('true')
                ->rules(['nullable', 'boolean']),
        ];
    }

    public function resolveRecord(): ?Model
    {
        return User::firstOrNew([
            'email' => Str::lower(trim((string) ($this->data['email'] ?? ''))),
        ]);
    }

    protected function beforeValidate(): void
    {
        $this->data['email'] = Str::lower(trim((string) ($this->data['email'] ?? '')));
        $this->data['username'] = filled($this->data['username'] ?? null)
            ? Str::slug((string) $this->data['username'], '_')
            : null;
        $this->data['roles'] = $this->normalizeList($this->data['roles'] ?? null);
        $this->data['division'] = $this->normalizeSlug($this->data['division'] ?? null);

        if (array_key_exists('is_active', $this->data) && blank($this->data['is_active'])) {
            $this->data['is_active'] = true;
        }
    }

    protected function beforeFill(): void
    {
        if (blank($this->data['password'] ?? null)) {
            unset($this->data['password']);
        } else {
            $this->data['password'] = Hash::make((string) $this->data['password']);
        }

        if (blank($this->data['division'] ?? null)) {
            return;
        }

        $teamUnit = TeamUnit::query()
            ->where('slug', $this->data['division'])
            ->first();

        if ($teamUnit) {
            $this->data['team_unit_id'] = $teamUnit->id;
        }
    }

    protected function beforeCreate(): void
    {
        if (blank($this->data['password'] ?? null)) {
            $this->record->password = Hash::make('Himatif@2026');
        }

        if (! array_key_exists('is_active', $this->data)) {
            $this->record->is_active = true;
        }
    }

    protected function afterSave(): void
    {
        if (blank($this->data['roles'] ?? null)) {
            return;
        }

        $this->record->syncRoles($this->data['roles']);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Import user selesai. ' . number_format($import->successful_rows) . ' baris berhasil diproses.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' baris gagal, silakan unduh file gagal untuk diperbaiki.';
        }

        return $body;
    }

    private function normalizeList(mixed $value): ?string
    {
        if (blank($value)) {
            return null;
        }

        return collect(preg_split('/[,|;]/', (string) $value))
            ->map(fn (string $item): string => $this->normalizeSlug($item))
            ->filter()
            ->implode(',');
    }

    private function normalizeSlug(mixed $value): ?string
    {
        if (blank($value)) {
            return null;
        }

        return Str::of((string) $value)
            ->trim()
            ->lower()
            ->replace([' ', '-'], '_')
            ->toString();
    }

    private static function rolesExistRule(): callable
    {
        return function (string $attribute, mixed $value, callable $fail): void {
            if (blank($value)) {
                return;
            }

            $roles = collect(preg_split('/[,|;]/', (string) $value))
                ->map(fn (string $role): string => Str::of($role)->trim()->lower()->replace([' ', '-'], '_')->toString())
                ->filter();
            $missingRoles = $roles
                ->reject(fn (string $role): bool => Role::where('name', $role)->exists())
                ->values();

            if ($missingRoles->isNotEmpty()) {
                $fail('Role tidak ditemukan: ' . $missingRoles->implode(', ') . '.');
            }
        };
    }

    private static function divisionExistsRule(): callable
    {
        return function (string $attribute, mixed $value, callable $fail): void {
            if (blank($value)) {
                return;
            }

            $division = Str::of((string) $value)->trim()->lower()->replace([' ', '-'], '_')->toString();

            if (! TeamUnit::where('slug', $division)->exists()) {
                $fail('Divisi tidak ditemukan. Gunakan salah satu: humas, psda, ristek, danus, medinfo.');
            }
        };
    }
}
