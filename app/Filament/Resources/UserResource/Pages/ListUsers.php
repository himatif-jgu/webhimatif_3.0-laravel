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
            Action::make('downloadUserImportExcelTemplate')
                ->label('Download Excel Template')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->visible(fn (): bool => UserResource::canCreate())
                ->action(fn (): StreamedResponse => $this->downloadUserImportExcelTemplate()),
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
                    '<p>Upload file CSV. Kalau lebih nyaman pakai Excel, download Excel Template, isi datanya, lalu Save As menjadi <strong>CSV UTF-8</strong> sebelum upload.</p>' .
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

    private function downloadUserImportExcelTemplate(): StreamedResponse
    {
        $headers = $this->userImportHeaders();
        $rows = $this->userImportExampleRows();

        return response()->streamDownload(function () use ($headers, $rows): void {
            echo '<html><head><meta charset="UTF-8"></head><body>';
            echo '<h3>HIMATIF User Import Template</h3>';
            echo '<p>Isi data di tabel ini. Setelah selesai, pilih File > Save As > CSV UTF-8, lalu upload lewat tombol Import Users.</p>';
            echo '<table border="1">';
            echo '<thead><tr>';

            foreach ($headers as $header) {
                echo '<th style="background:#f3f4f6;">' . e($header) . '</th>';
            }

            echo '</tr></thead><tbody>';

            foreach ($rows as $row) {
                echo '<tr>';

                foreach ($row as $cell) {
                    echo '<td>' . e($cell) . '</td>';
                }

                echo '</tr>';
            }

            echo '</tbody></table>';
            echo '<br><table border="1">';
            echo '<tr><th colspan="2" style="background:#fef3c7;">Panduan Field</th></tr>';
            echo '<tr><td>roles</td><td>Slug role, pisahkan koma. Contoh: anggota_divisi,sekretaris_1,bendahara_2</td></tr>';
            echo '<tr><td>division</td><td>Isi salah satu: humas, psda, ristek, danus, medinfo</td></tr>';
            echo '<tr><td>gender</td><td>male atau female</td></tr>';
            echo '<tr><td>birth_date</td><td>Format YYYY-MM-DD</td></tr>';
            echo '<tr><td>is_active</td><td>true atau false</td></tr>';
            echo '</table>';
            echo '</body></html>';
        }, 'himatif-user-import-template.xls', [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
        ]);
    }

    private function downloadUserImportTemplate(): StreamedResponse
    {
        $headers = $this->userImportHeaders();
        $rows = $this->userImportExampleRows();

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

    /**
     * @return array<int, string>
     */
    private function userImportHeaders(): array
    {
        return [
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
    }

    /**
     * @return array<int, array<int, string>>
     */
    private function userImportExampleRows(): array
    {
        return [
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
    }
}
