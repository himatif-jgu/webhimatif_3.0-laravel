<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LandingContentResource\Pages\CreateLandingContent;
use App\Filament\Resources\LandingContentResource\Pages\EditLandingContent;
use App\Filament\Resources\LandingContentResource\Pages\ListLandingContents;
use App\Models\LandingContent;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
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

class LandingContentResource extends Resource
{
    protected static ?string $model = LandingContent::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-group';

    protected static string|\UnitEnum|null $navigationGroup = 'CMS Landing Page';

    protected static ?string $navigationLabel = 'Landing Content';

    protected static ?string $modelLabel = 'landing content';

    protected static ?string $pluralModelLabel = 'landing contents';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Content')
                ->description('Write clear, reusable copy for one landing page section.')
                ->schema([
                    Select::make('section')
                        ->options(self::sectionOptions())
                        ->required()
                        ->searchable(),
                    TextInput::make('key')
                        ->helperText('Unique identifier, for example: hero-main or about-history.')
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),
                    TextInput::make('eyebrow')
                        ->maxLength(255),
                    TextInput::make('title')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('subtitle')
                        ->maxLength(255),
                    RichEditor::make('body')
                        ->columnSpanFull(),
                ])->columns(2),

            Section::make('Media and action')
                ->description('Keep button labels short and action-oriented.')
                ->schema([
                    FileUpload::make('image_path')
                        ->label('Image')
                        ->image()
                        ->disk('public')
                        ->directory('landing')
                        ->visibility('public'),
                    TextInput::make('button_label')
                        ->maxLength(80),
                    TextInput::make('button_url')
                        ->helperText('Use a full URL, a site path, or an anchor such as #programs.')
                        ->maxLength(255),
                ])->columns(3),

            Section::make('Publishing')
                ->schema([
                    TextInput::make('sort_order')
                        ->numeric()
                        ->default(0)
                        ->required(),
                    Toggle::make('is_active')
                        ->default(true)
                        ->required(),
                    DateTimePicker::make('published_at'),
                    KeyValue::make('settings')
                        ->helperText('Optional layout settings for advanced display needs.')
                        ->keyLabel('Setting')
                        ->valueLabel('Value')
                        ->columnSpanFull(),
                ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('section')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(45),
                TextColumn::make('key')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('sort_order')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('section')
                    ->options(self::sectionOptions()),
                TernaryFilter::make('is_active'),
            ])
            ->defaultSort('sort_order')
            ->recordActions([
                EditAction::make()
                    ->url(fn (LandingContent $record): string => self::getUrl('edit', ['record' => $record])),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLandingContents::route('/'),
            'create' => CreateLandingContent::route('/create'),
            'edit' => EditLandingContent::route('/{record}/edit'),
        ];
    }

    public static function sectionOptions(): array
    {
        return [
            'hero' => 'Hero',
            'about' => 'About',
            'history' => 'History',
            'foundation' => 'Foundation',
            'team' => 'Team',
            'program' => 'Program',
            'blog' => 'Blog',
            'contact' => 'Contact',
            'footer' => 'Footer',
        ];
    }
}
