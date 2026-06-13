<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Concerns\CmsResourceAccess;
use App\Filament\Resources\BlogResource\Pages\CreateBlog;
use App\Filament\Resources\BlogResource\Pages\EditBlog;
use App\Filament\Resources\BlogResource\Pages\ListBlogs;
use App\Models\Blog;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
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

class BlogResource extends Resource
{
    use CmsResourceAccess;

    protected static ?string $model = Blog::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-newspaper';

    protected static string|\UnitEnum|null $navigationGroup = 'CMS Landing Page';

    protected static ?string $navigationLabel = 'Blog Posts';

    protected static ?int $navigationSort = 30;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Article')
                ->description('Write useful, specific content for HIMATIF readers.')
                ->schema([
                    TextInput::make('title')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('slug')
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),
                    Select::make('blog_category_id')
                        ->label('Category')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->preload(),
                    Select::make('author_id')
                        ->label('Author')
                        ->relationship('author', 'name')
                        ->searchable()
                        ->preload()
                        ->default(auth()->id())
                        ->required(),
                    Textarea::make('excerpt')
                        ->rows(3)
                        ->columnSpanFull(),
                    RichEditor::make('content')
                        ->required()
                        ->columnSpanFull(),
                ])->columns(2),

            Section::make('Media and SEO')
                ->description('Use accurate metadata so articles are easier to find and share.')
                ->schema([
                    FileUpload::make('featured_image')
                        ->image()
                        ->disk('public')
                        ->directory('blogs')
                        ->visibility('public')
                        ->columnSpanFull(),
                    TextInput::make('meta_title')
                        ->maxLength(255),
                    Textarea::make('meta_description')
                        ->rows(3),
                    TextInput::make('meta_keywords')
                        ->helperText('Separate keywords with commas.')
                        ->maxLength(255)
                        ->columnSpanFull(),
                ])->columns(2),

            Section::make('Publishing')
                ->schema([
                    Toggle::make('is_published')
                        ->default(false)
                        ->required(),
                    DateTimePicker::make('published_at'),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featured_image')
                    ->disk('public')
                    ->square()
                    ->toggleable(),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(45),
                TextColumn::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->sortable(),
                TextColumn::make('author.name')
                    ->label('Author')
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('is_published')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('views_count')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('blog_category_id')
                    ->label('Category')
                    ->relationship('category', 'name'),
                TernaryFilter::make('is_published'),
            ])
            ->defaultSort('published_at', 'desc')
            ->recordActions([
                EditAction::make()
                    ->url(fn (Blog $record): string => self::getUrl('edit', ['record' => $record])),
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
            'index' => ListBlogs::route('/'),
            'create' => CreateBlog::route('/create'),
            'edit' => EditBlog::route('/{record}/edit'),
        ];
    }
}
