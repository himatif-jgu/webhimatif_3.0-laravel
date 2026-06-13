<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Concerns\CmsResourceAccess;
use App\Filament\Resources\FoundationContentResource\Pages\CreateFoundationContent;
use App\Filament\Resources\FoundationContentResource\Pages\EditFoundationContent;
use App\Filament\Resources\FoundationContentResource\Pages\ListFoundationContents;
use App\Models\FoundationContent;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class FoundationContentResource extends Resource
{
    use CmsResourceAccess;

    protected static ?string $model = FoundationContent::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-flag';

    protected static string|\UnitEnum|null $navigationGroup = 'CMS Landing Page';

    protected static ?string $navigationLabel = 'Foundation';

    protected static ?int $navigationSort = 50;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Foundation content')
                ->schema([
                    Select::make('type')
                        ->options(['vision' => 'Vision', 'mission' => 'Mission', 'value' => 'Value'])
                        ->default('vision')
                        ->required(),
                    TextInput::make('title')->required()->maxLength(255),
                    TextInput::make('slug')->maxLength(255)->unique(ignoreRecord: true),
                    Textarea::make('summary')->rows(3)->columnSpanFull(),
                    RichEditor::make('body')->columnSpanFull(),
                    FileUpload::make('image_path')
                        ->image()
                        ->disk('public')
                        ->directory('foundation')
                        ->visibility('public')
                        ->maxSize(512)
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
                TextColumn::make('type')->badge()->sortable(),
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('sort_order')->sortable(),
                IconColumn::make('is_active')->boolean()->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')->options(['vision' => 'Vision', 'mission' => 'Mission', 'value' => 'Value']),
                TernaryFilter::make('is_active'),
            ])
            ->defaultSort('sort_order')
            ->recordActions([
                EditAction::make()->url(fn (FoundationContent $record): string => self::getUrl('edit', ['record' => $record])),
                DeleteAction::make(),
            ])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFoundationContents::route('/'),
            'create' => CreateFoundationContent::route('/create'),
            'edit' => EditFoundationContent::route('/{record}/edit'),
        ];
    }
}
