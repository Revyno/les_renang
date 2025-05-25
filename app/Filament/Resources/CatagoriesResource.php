<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CatagoriesResource\Pages;
use App\Filament\Resources\CatagoriesResource\RelationManagers;
use App\Models\Categories;
use Doctrine\DBAL\Query\From;
use Filament\Forms;
use Filament\Forms\Components\Component;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CatagoriesResource extends Resource
{
    protected static ?string $model = Categories::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $title = 'Categories';
    protected static ?string $navigationLabel = 'Categories';
    protected static ?string $navigationGroup = 'Menagement';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textinput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->disableAutocomplete()
                    ->dehydrateStateUsing(fn ($state) => str($state)->slug()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Category Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->sortable()
                    ->searchable(),
                //
                // Forms\Components\Text::make('name')
                //     ->label('Category Name')
                //     ->sortable()
                //     ->searchable(),
                // Forms\Components\Text::make('slug')
                //     ->label('Slug')
                //     ->sortable()
                //     ->searchable(),
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
            'index' => Pages\ListCatagories::route('/'),
            'create' => Pages\CreateCatagories::route('/create'),
            'edit' => Pages\EditCatagories::route('/{record}/edit'),
        ];
    }    
}
