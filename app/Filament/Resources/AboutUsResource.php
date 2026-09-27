<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutUsResource\Pages;
use App\Filament\Resources\AboutUsResource\RelationManagers;
use App\Filament\Components\CloudinaryUpload;
use App\Models\AboutUs;
use App\Support\Media;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AboutUsResource extends Resource
{
    protected static ?string $model = AboutUs::class;

    protected static ?string $navigationGroup = 'Menagement';
    protected static ?string $navigationLabel = 'About Us';
    protected static ?string $navigationIcon = 'heroicon-o-information-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),

                Forms\Components\RichEditor::make('description')
                    ->label('Description')
                    // ->colomnSpan('2')
                    ->required()
                    ->maxLength(100),

                CloudinaryUpload::make('img')
                    ->label('Thumbnail')
                    ->image()
                    ->directory('les-renang/cms/about')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

             Tables\Columns\TextColumn::make('title')
                ->label('Title')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('description')
                ->label('Description')
                ->html()
                ->limit(50),
            Tables\Columns\ImageColumn::make('img')
                ->label('Thumbnail')
                ->getStateUsing(fn ($record) => Media::url($record->img)),
                // Forms\Components\TextInput::make('title')
                //     ->label('Title'),
                //     // ->sortable(),
                //     // ->searchable(),
                // Forms\Components\RichEditor::make('description')
                //     ->label('Description'),
                //     // ->sortable(),
                //     // ->searchable(),
                // Forms\Components\FileUpload::make('img')  
                //     ->label('Thumbnail')
                    // ->disk('public')
                    // ->directory('aboutus/thumbnails')

            //         ->sortable()
            //         ->searchable()
            //         ->formatStateUsing(fn ($state) => '<img src="' . asset('storage/' . $state) . '" width="50" height="50" />')
            //         ->html(),
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
            
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAboutUs::route('/'),
            'create' => Pages\CreateAboutUs::route('/create'),
            'edit' => Pages\EditAboutUs::route('/{record}/edit'),
        ];
    }    
}
