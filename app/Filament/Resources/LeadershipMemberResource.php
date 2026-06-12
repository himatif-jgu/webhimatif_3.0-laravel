<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadershipMemberResource\Pages\CreateLeadershipMember;
use App\Filament\Resources\LeadershipMemberResource\Pages\EditLeadershipMember;
use App\Filament\Resources\LeadershipMemberResource\Pages\ListLeadershipMembers;
use App\Models\LeadershipMember;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
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

class LeadershipMemberResource extends Resource
{
    protected static ?string $model = LeadershipMember::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user-group';

    protected static string|\UnitEnum|null $navigationGroup = 'CMS Landing Page';

    protected static ?string $navigationLabel = 'Leadership Structure';

    protected static ?int $navigationSort = 70;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Leadership member')
                ->description('Photo is optimized to 600x600 px and limited to 512 KB.')
                ->schema([
                    TextInput::make('name')->required()->maxLength(255),
                    TextInput::make('position')->required()->maxLength(255),
                    TextInput::make('department')->maxLength(255),
                    TextInput::make('profile_url')->url()->maxLength(255),
                    FileUpload::make('photo_path')
                        ->label('Photo')
                        ->image()
                        ->disk('public')
                        ->directory('leadership')
                        ->visibility('public')
                        ->maxSize(512)
                        ->imageCropAspectRatio('1:1')
                        ->imageResizeMode('cover')
                        ->imageResizeTargetWidth('600')
                        ->imageResizeTargetHeight('600')
                        ->helperText('Max 512 KB. Required ratio 1:1. Recommended 600x600 px, JPG/WebP.'),
                    TextInput::make('sort_order')->numeric()->default(0)->required(),
                    Toggle::make('is_active')->default(true)->required(),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo_path')->disk('public')->circular(),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('position')->searchable()->sortable(),
                TextColumn::make('department')->toggleable(),
                TextColumn::make('sort_order')->sortable(),
                IconColumn::make('is_active')->boolean()->sortable(),
            ])
            ->filters([TernaryFilter::make('is_active')])
            ->defaultSort('sort_order')
            ->recordActions([
                EditAction::make()->url(fn (LeadershipMember $record): string => self::getUrl('edit', ['record' => $record])),
                DeleteAction::make(),
            ])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLeadershipMembers::route('/'),
            'create' => CreateLeadershipMember::route('/create'),
            'edit' => EditLeadershipMember::route('/{record}/edit'),
        ];
    }
}
