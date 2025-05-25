<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogsResource\Pages;
use App\Filament\Resources\BlogsResource\RelationManagers;
use App\Models\Blogs;
use Filament\Forms;
use App\Models\Categories;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BlogsResource extends Resource
{
    protected static ?string $model = Blogs::class;

    protected static ?string $navigationIcon = 'heroicon-o-template';
    protected static ?string $navigationGroup = 'Menagement';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
            Forms\Components\Select::make('categories_id')
                    // ->relationship('categories', 'id')
                    ->options(Categories::query()->pluck('name', 'id'))
                    ->required(),
            Forms\Components\RichEditor::make('description')
                    ->label('Description')
                    ->required()
                    ->maxLength(65535),
            Forms\Components\TextInput::make('short_desc')
                    ->label('Short Description')
                    ->required()
                    ->maxLength(255),
            Forms\Components\FileUpload::make('imgUrl')
                    ->label('Thumbnail')
                    ->image()
                    ->disk('public')
                    ->directory('blogs/thumbnails')
                    ->required(),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlogs::route('/create'),
            'edit' => Pages\EditBlogs::route('/{record}/edit'),
        ];
    }    
}
