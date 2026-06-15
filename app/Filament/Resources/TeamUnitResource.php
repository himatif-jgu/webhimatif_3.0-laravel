<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Concerns\CmsResourceAccess;
use App\Filament\Resources\TeamUnitResource\Pages\CreateTeamUnit;
use App\Filament\Resources\TeamUnitResource\Pages\EditTeamUnit;
use App\Filament\Resources\TeamUnitResource\Pages\ListTeamUnits;
use App\Models\TeamUnit;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TeamUnitResource extends Resource
{
    use CmsResourceAccess;

    protected static ?string $model = TeamUnit::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-squares-2x2';

    protected static string|\UnitEnum|null $navigationGroup = 'CMS Landing Page';

    protected static ?string $navigationLabel = 'Meet Our Team';

    protected static ?int $navigationSort = 60;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Team / Division')
                ->description('Konten ini tampil di card Meet Our Team. Saat card diklik, landing page akan membuka detail divisi, deskripsi, dan list anggota aktif dari Access Control.')
                ->schema([
                    TextInput::make('name')
                        ->label('Team / division name')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('slug')
                        ->helperText('Kosongkan untuk auto-generate dari nama.')
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),
                    TextInput::make('subtitle')
                        ->label('Short subtitle')
                        ->helperText('Teks pendek yang tampil di card Meet Our Team.')
                        ->maxLength(255),
                    Select::make('icon')
                        ->options(self::iconOptions())
                        ->searchable()
                        ->default('users')
                        ->required()
                        ->helperText('Icon diambil dari Feather Icons. Pilih nama icon yang tersedia, misalnya users, code, file-text, award, atau shopping-cart. Icon ini hanya tampil di card Meet Our Team pada landing page.'),
                    RichEditor::make('description')
                        ->label('About description')
                        ->helperText('Isi penjelasan tentang divisi, fungsi, program kerja, dan tanggung jawabnya.')
                        ->columnSpanFull(),
                    FileUpload::make('image_path')
                        ->label('Cover image')
                        ->image()
                        ->disk('public')
                        ->directory('team-units')
                        ->visibility('public')
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->maxSize(512)
                        ->imageResizeMode('cover')
                        ->imageResizeTargetWidth('800')
                        ->imageResizeTargetHeight('600')
                        ->helperText('Opsional untuk halaman detail divisi. Max 512 KB, JPG/PNG/WebP, recommended 800x600 px.'),
                    TextInput::make('sort_order')->numeric()->default(0)->required(),
                    Toggle::make('is_active')->default(true)->required(),
                ])->columns(2),
            Section::make('How members are shown')
                ->description('Anggota tidak diinput dari CRUD ini. List anggota otomatis diambil dari Access Control -> Users berdasarkan field Division / Department. Jika user aktif dipilih ke divisi ini, user tersebut akan tampil di halaman detail Meet Our Team.')
                ->schema([
                    Placeholder::make('members_source')
                        ->hiddenLabel()
                        ->content('Untuk menambah anggota ke divisi, buka Access Control -> Users, lalu isi field Division / Department pada user tersebut.'),
                ])
                ->collapsed(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')->disk('public')->square()->toggleable(),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('subtitle')->searchable()->toggleable(),
                TextColumn::make('icon')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => $state ? (self::iconOptions()[$state] ?? $state) : '-')
                    ->toggleable(),
                TextColumn::make('users_count')
                    ->label('Members')
                    ->sortable(),
                TextColumn::make('sort_order')->sortable(),
                IconColumn::make('is_active')->boolean()->sortable(),
            ])
            ->filters([TernaryFilter::make('is_active')])
            ->defaultSort('sort_order')
            ->recordActions([
                Action::make('openLanding')
                    ->label('View')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn (TeamUnit $record): string => route('team.show', $record->slug))
                    ->openUrlInNewTab(),
                EditAction::make()->url(fn (TeamUnit $record): string => self::getUrl('edit', ['record' => $record])),
                DeleteAction::make(),
            ])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withCount('users');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTeamUnits::route('/'),
            'create' => CreateTeamUnit::route('/create'),
            'edit' => EditTeamUnit::route('/{record}/edit'),
        ];
    }

    public static function iconOptions(): array
    {
        return [
            'user' => 'User',
            'users' => 'Users',
            'user-check' => 'User check',
            'briefcase' => 'Briefcase',
            'message-square' => 'Message square',
            'file-text' => 'File text',
            'credit-card' => 'Credit card',
            'code' => 'Code',
            'award' => 'Award',
            'shopping-cart' => 'Shopping cart',
            'camera' => 'Camera',
            'globe' => 'Globe',
            'book-open' => 'Book open',
            'target' => 'Target',
            'layers' => 'Layers',
            'cpu' => 'CPU',
        ];
    }
}
