<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Concerns\CmsResourceAccess;
use App\Filament\Resources\ContactInformationResource\Pages\CreateContactInformation;
use App\Filament\Resources\ContactInformationResource\Pages\EditContactInformation;
use App\Filament\Resources\ContactInformationResource\Pages\ListContactInformation;
use App\Models\ContactInformation;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
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

class ContactInformationResource extends Resource
{
    use CmsResourceAccess;

    protected static ?string $model = ContactInformation::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-phone';

    protected static string|\UnitEnum|null $navigationGroup = 'CMS Landing Page';

    protected static ?string $navigationLabel = 'Contact Us';

    protected static ?int $navigationSort = 80;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Contact item')
                ->schema([
                    TextInput::make('label')->required()->maxLength(255),
                    Select::make('type')
                        ->options([
                            'address' => 'Address',
                            'email' => 'Email',
                            'phone' => 'Phone',
                            'social' => 'Social',
                            'text' => 'Text',
                        ])
                        ->default('text')
                        ->required(),
                    Textarea::make('value')->required()->rows(3)->columnSpanFull(),
                    TextInput::make('url')
                        ->helperText('Use mailto:, tel:, https://, or leave blank.')
                        ->maxLength(255),
                    FileUpload::make('icon_path')
                        ->image()
                        ->disk('public')
                        ->directory('contact-icons')
                        ->visibility('public')
                        ->maxSize(128)
                        ->imageResizeMode('contain')
                        ->imageResizeTargetWidth('128')
                        ->imageResizeTargetHeight('128')
                        ->helperText('Max 128 KB. Recommended 128x128 px PNG/WebP.'),
                    TextInput::make('sort_order')->numeric()->default(0)->required(),
                    Toggle::make('is_active')->default(true)->required(),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('icon_path')->disk('public')->square()->toggleable(),
                TextColumn::make('label')->searchable()->sortable(),
                TextColumn::make('type')->badge()->sortable(),
                TextColumn::make('value')->limit(45)->searchable(),
                TextColumn::make('sort_order')->sortable(),
                IconColumn::make('is_active')->boolean()->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')->options([
                    'address' => 'Address',
                    'email' => 'Email',
                    'phone' => 'Phone',
                    'social' => 'Social',
                    'text' => 'Text',
                ]),
                TernaryFilter::make('is_active'),
            ])
            ->defaultSort('sort_order')
            ->recordActions([
                EditAction::make()->url(fn (ContactInformation $record): string => self::getUrl('edit', ['record' => $record])),
                DeleteAction::make(),
            ])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContactInformation::route('/'),
            'create' => CreateContactInformation::route('/create'),
            'edit' => EditContactInformation::route('/{record}/edit'),
        ];
    }
}
