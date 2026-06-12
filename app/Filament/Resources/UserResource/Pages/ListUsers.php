<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Imports\UserImporter;
use App\Filament\Resources\UserResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\HtmlString;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('downloadUserImportTemplate')
                ->label('Download CSV Template')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->visible(fn (): bool => UserResource::canCreate())
                ->action(fn (): StreamedResponse => $this->downloadUserImportTemplate()),
            ImportAction::make('importUsers')
                ->label('Import Users')
                ->icon('heroicon-o-arrow-up-tray')
                ->importer(UserImporter::class)
                ->modalHeading('Import Users')
                ->modalDescription(new HtmlString(
                    '<div class="space-y-2 text-sm">' .
                    '<p>Upload file CSV yang sudah diisi dari template. File CSV bisa dibuka dan diedit menggunakan Microsoft Excel atau Google Sheets.</p>' .
                    '<p><strong>Wajib:</strong> name, email. Password opsional; jika user baru tanpa password, sistem memakai default <code>Himatif@2026</code>.</p>' .
                    '<p><strong>Roles:</strong> isi slug role, pisahkan koma. Contoh: <code>anggota_divisi</code>, <code>sekretaris_1</code>, <code>bendahara_2</code>.</p>' .
                    '<p><strong>Division:</strong> isi salah satu: <code>humas</code>, <code>psda</code>, <code>ristek</code>, <code>danus</code>, <code>medinfo</code>.</p>' .
                    '<p>Jika email sudah ada, data user akan di-update.</p>' .
                    '</div>'
                ))
                ->visible(fn (): bool => UserResource::canCreate()),
            CreateAction::make()
                ->visible(fn (): bool => UserResource::canCreate()),
        ];
    }

    private function downloadUserImportTemplate(): StreamedResponse
    {
        $headers = [
            'name',
            'email',
            'username',
            'npm',
            'password',
            'roles',
            'division',
            'batch_year',
            'phone',
            'gender',
            'birth_date',
            'address',
            'bio',
            'instagram_url',
            'linkedin_url',
            'website_url',
            'is_active',
        ];

        $rows = [
            [
                'Budi Santoso',
                'budi.santoso@himatif-jgu.ac.id',
                'budi_santoso',
                '230101001',
                'Himatif@2026',
                'anggota_divisi',
                'humas',
                '2023',
                '081234567890',
                'male',
                '2004-08-17',
                'Depok',
                'Mahasiswa Teknik Informatika JGU.',
                'https://instagram.com/username',
                'https://www.linkedin.com/in/username',
                'https://example.com',
                'true',
            ],
        ];

        return response()->streamDownload(function () use ($headers, $rows): void {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, $headers);

            foreach ($rows as $row) {
                fputcsv($handle, $row);
            }

            fclose($handle);
        }, 'himatif-user-import-template.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
