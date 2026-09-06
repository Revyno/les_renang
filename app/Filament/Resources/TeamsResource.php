<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeamsResource\Pages;
use App\Filament\Resources\TeamsResource\RelationManagers;
use App\Models\Teams;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeamsResource extends Resource
{
    protected static ?string $model = Teams::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                FileUpload::make('imgUrl')
                    ->label('Image')
                    ->image()->columnSpan(2)
                    ->required(),
                TextInput::make('name')->required(),
                Select::make('position')->options([
                    'instructor'=> 'Instructor',
                    'founder'=>'Founder',
                    'developer' => 'Web Developer',
                    'it head' => 'IT Head'
                ])->required(),
                TextInput::make('fblink')->label('Facebook Handle'),
                TextInput::make('instalink')->label('Instagram Handle'),
                TextInput::make('twitterlink')->label('Twitter Handle'),
                Select::make('status')
                ->options([
                    '1' => 'Show',
                    '0' => 'Hide',
                ])->default(1),



            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('position')->label('Designation'),
                ImageColumn::make('imgUrl')->label('Image')

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListTeams::route('/'),
            'create' => Pages\CreateTeams::route('/create'),
            'edit' => Pages\EditTeams::route('/{record}/edit'),
        ];
    }
}
