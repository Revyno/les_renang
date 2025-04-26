<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JadwalLesResource\Pages;
use App\Filament\Resources\JadwalLesResource\RelationManagers;
use App\Models\JadwalLes;
use App\Models\JadwalKelas;
use App\Models\Classes;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use PhpParser\Builder\Class_;

class JadwalLesResource extends Resource
{
    protected static ?string $model = Classes::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Programs';
    protected static ?string $navigationGroup = 'Menagement';
    

    public static function form(Form $form): Form
    {
        return $form
        
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->label('Nama Kelas'),

                Forms\Components\DatePicker::make('schedule_date')
                    ->required()
                    ->label('Tanggal'),

                Forms\Components\TimePicker::make('schedule_time')
                    ->required()
                    ->label('Jam'),

                Forms\Components\Select::make('isntructor_id')
                ->required()
                ->relationship('instructors','name')
                ->searchable()
                ->label('instruktur'),


                Forms\Components\TextInput::make('capacity')
                    ->numeric()
                    ->required()
                    ->label('Kapasitas'),

                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->prefix('Rp')
                    ->required()
                    ->label('Harga'),
            ]);
           
    }

    public static function table(Table $table): Table
    {
        return $table
                ->columns([
                    Tables\Columns\TextColumn::make('title')->label('Nama Kelas')->searchable(),
                    Tables\Columns\TextColumn::make('schedule_date')->date()->label('Tanggal'),
                    Tables\Columns\TextColumn::make('schedule_time')->label('Jam'),
                    Tables\Columns\TextColumn::make('capacity')->label('Kapasitas'),
                    Tables\Columns\TextColumn::make('price')->money('IDR')->label('Harga'),
                    Tables\Columns\TextColumn::make('instructors.name')->label('instruktur')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
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
