<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegistrationResource\Pages;
use App\Filament\Resources\RegistrationResource\RelationManagers;
use App\Models\Registration;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RegistrationResource extends Resource
{
    protected static ?string $model = Registration::class;
   

    protected static ?string $navigationIcon = 'heroicon-o-pencil-alt';
    protected static ?string $navigationLabel = 'Registrasi';
    protected static ?string $navigationGroup = 'Menagement';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Select::make('student_id')
                ->relationship('student', 'name')
                ->searchable()
                ->required()
                ->label('Siswa'),

            Forms\Components\Select::make('class_id')
                ->relationship('class', 'title')
                ->searchable()
                ->required()
                ->label('Kelas Renang'),

            Forms\Components\DatePicker::make('registration_date')
                ->default(now())
                ->required()
                ->label('Tanggal Daftar'),

            Forms\Components\Select::make('status')
                ->options([
                    'pending' => 'Pending',
                    'confirmed' => 'Confirmed',
                    'cancelled' => 'Cancelled',
                ])
                ->default('pending')
                ->required()
                ->label('Status'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('student.name')->label('Nama Siswa')->searchable(),
            Tables\Columns\TextColumn::make('class.title')->label('Kelas Renang')->searchable(),
            Tables\Columns\TextColumn::make('registration_date')->date()->label('Tanggal Daftar'),
            Tables\Columns\BadgeColumn::make('status')
                ->enum([
                    'pending' => 'Pending',
                    'confirmed' => 'Confirmed',
                    'cancelled' => 'Cancelled',
                ])
                ->colors([
                    'secondary' => 'pending',
                    'success' => 'confirmed',
                    'danger' => 'cancelled',
                ])
                ->label('Status'),
            
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListRegistrations::route('/'),
            'create' => Pages\CreateRegistration::route('/create'),
            'edit' => Pages\EditRegistration::route('/{record}/edit'),
        ];
    }    
}
