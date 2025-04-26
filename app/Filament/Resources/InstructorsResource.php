<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InstructorsResource\Pages;
use App\Models\Instructor;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Forms\Components\FileUpload;   
class InstructorsResource extends Resource
{
    protected static ?string $model = Instructor::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'Menagement';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->label('Nama'),

                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\DatePicker::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->required(),

                Forms\Components\Select::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->required()
                    ->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan',
                    ]),

                Forms\Components\TextInput::make('telepon')
                    ->label('No. Telepon')
                    ->tel()
                    ->placeholder('08123456789'),

                Forms\Components\TextInput::make('alamat')
                    ->label('Alamat')
                    ->placeholder('Jl. Raya No. 123'),

                Forms\Components\TextInput::make('spesialisasi')
                    ->label('Spesialisasi')
                    ->placeholder('Contoh: Renang Profesional'),

                Forms\Components\TextInput::make('pengalaman_tahun')
                    ->label('Pengalaman (Tahun)')
                    ->numeric()
                    ->default(0),
                Forms\Components\FileUpload::make('image')
                ->image()
                ->directory('products') // Direktori penyimpanan di storage/app/public
                ->visibility('public')
                ->maxSize(1024) // Ukuran maksimal dalam KB
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->date(),

                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->label('Jenis Kelamin'),

                Tables\Columns\TextColumn::make('telepon')
                    ->label('No. Telepon'),

                Tables\Columns\TextColumn::make('alamat')
                    ->label('Alamat'),

                Tables\Columns\TextColumn::make('spesialisasi')
                    ->label('Spesialisasi'),

                Tables\Columns\TextColumn::make('pengalaman_tahun')
                    ->label('Pengalaman (Tahun)'),
                Tables\Columns\ImageColumn::make('image')
                ->label('Image'),
            ])
            ->filters([
                // bisa ditambahkan filter kalau mau
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
            // jika ada relasi lain
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInstructors::route('/'),
            'create' => Pages\CreateInstructors::route('/create'),
            'edit' => Pages\EditInstructors::route('/{record}/edit'),
        ];
    }
}
