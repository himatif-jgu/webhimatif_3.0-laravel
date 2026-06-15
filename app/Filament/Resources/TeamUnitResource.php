<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Concerns\CmsResourceAccess;
use App\Filament\Resources\TeamUnitResource\Pages\CreateTeamUnit;
use App\Filament\Resources\TeamUnitResource\Pages\EditTeamUnit;
use App\Filament\Resources\TeamUnitResource\Pages\ListTeamUnits;
use App\Models\TeamUnit;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
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
            Section::make('Team unit')
                ->description('Konten ini tampil di Meet Our Team. Saat card diklik, user akan melihat deskripsi divisi dan anggota aktif yang terhubung ke divisi ini.')
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
                    TextInput::make('icon')
                        ->default('users')
                        ->helperText('Use a Feather icon name, for example users, code, file-text, credit-card.'),
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
                        ->maxSize(512)
                        ->imageResizeMode('cover')
                        ->imageResizeTargetWidth('800')
                        ->imageResizeTargetHeight('600')
                        ->helperText('Max 512 KB. Recommended 800x600 px.'),
                    TextInput::make('sort_order')->numeric()->default(0)->required(),
                    Toggle::make('is_active')->default(true)->required(),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')->disk('public')->square()->toggleable(),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('subtitle')->searchable()->toggleable(),
                TextColumn::make('sort_order')->sortable(),
                IconColumn::make('is_active')->boolean()->sortable(),
            ])
            ->filters([TernaryFilter::make('is_active')])
            ->defaultSort('sort_order')
            ->recordActions([
                EditAction::make()->url(fn (TeamUnit $record): string => self::getUrl('edit', ['record' => $record])),
                DeleteAction::make(),
            ])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTeamUnits::route('/'),
            'create' => CreateTeamUnit::route('/create'),
            'edit' => EditTeamUnit::route('/{record}/edit'),
        ];
    }
}
