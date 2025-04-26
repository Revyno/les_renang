<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JadwalLesResource\Pages;
use App\Filament\Resources\JadwalLesResource\RelationManagers;
use App\Models\JadwalLes;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JadwalLesResource extends Resource
{
    protected static ?string $model = JadwalLes::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationGroup = 'Menagement';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListJadwalLes::route('/'),
            'create' => Pages\CreateJadwalLes::route('/create'),
            'edit' => Pages\EditJadwalLes::route('/{record}/edit'),
        ];
    }    
}
