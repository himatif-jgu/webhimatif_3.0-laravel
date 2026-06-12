<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HistoryEntryResource\Pages\CreateHistoryEntry;
use App\Filament\Resources\HistoryEntryResource\Pages\EditHistoryEntry;
use App\Filament\Resources\HistoryEntryResource\Pages\ListHistoryEntries;
use App\Models\HistoryEntry;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
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

class HistoryEntryResource extends Resource
{
    protected static ?string $model = HistoryEntry::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-clock';

    protected static string|\UnitEnum|null $navigationGroup = 'CMS Landing Page';

    protected static ?string $navigationLabel = 'History';

    protected static ?int $navigationSort = 40;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('History content')
                ->description('Use FAQ for accordion items and Journey for timeline items.')
                ->schema([
                    Select::make('type')
                        ->options(['faq' => 'FAQ', 'journey' => 'Journey'])
                        ->default('journey')
                        ->required(),
                    TextInput::make('title')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('period')
                        ->maxLength(255),
                    RichEditor::make('body')
                        ->columnSpanFull(),
                    TextInput::make('sort_order')
                        ->numeric()
                        ->default(0)
                        ->required(),
                    Toggle::make('is_active')
                        ->default(true)
                        ->required(),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')->badge()->sortable(),
                TextColumn::make('title')->searchable()->sortable()->limit(50),
                TextColumn::make('period')->toggleable(),
                TextColumn::make('sort_order')->sortable(),
                IconColumn::make('is_active')->boolean()->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')->options(['faq' => 'FAQ', 'journey' => 'Journey']),
                TernaryFilter::make('is_active'),
            ])
            ->defaultSort('sort_order')
            ->recordActions([
                EditAction::make()->url(fn (HistoryEntry $record): string => self::getUrl('edit', ['record' => $record])),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHistoryEntries::route('/'),
            'create' => CreateHistoryEntry::route('/create'),
            'edit' => EditHistoryEntry::route('/{record}/edit'),
        ];
    }
}
