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

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Menagement';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Nama'),
                    
                  
                         Forms\Components\Select::make('jenis_kelamin')
                             ->label('Jenis Kelamin')
                             ->required()
                             ->options([
                             'Laki-laki' => 'Laki-laki',
                            'Perempuan' => 'Perempuan',
                                    ]),

              
                    Forms\Components\TextInput::make('specialization')
                    ->required()
                    ->label('Spesialisasi')
                    ->placeholder('Contoh: Renang Profesional'),
                    
                     Forms\Components\TextInput::make('certification')
                    ->required()
                    ->maxLength(255)
                    ->label('Sertifikasi'),
                
                    Forms\Components\TextInput::make('pengalaman_tahun')
                    ->required()
                    ->label('Pengalaman (Tahun)')
                    ->numeric()
                    ->default(0),
                    
                    Forms\Components\TextInput::make('telepon')
                    ->required()
                    ->label('No. Telepon')
                    ->tel()
                    ->placeholder('08123456789'),


                       Forms\Components\Textarea::make('bio')
                       ->required()
                       ->label('Bio')
                       ->required(),

                        Forms\Components\FileUpload::make('photo')
                            ->required() 
                            ->image()
                            ->directory('instructors')
                            ->maxSize(1024),
                        
               
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                    
                  
                        // Tables\Columns\TextColumn::make('email')
                        //     ->searchable()
                        //     ->sortable(),

                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->label('Jenis Kelamin'),

                Tables\Columns\TextColumn::make('telepon')
                    ->label('No. Telepon'),

                // Tables\Columns\TextColumn::make('alamat')
                //     ->label('Alamat'),

                Tables\Columns\TextColumn::make('specialization')
                    ->label('Spesialisasi')
                   ,
                Tables\Columns\TextColumn::make('certification')
                    ->label('Sertifikasi')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('pengalaman_tahun')
                    ->label('Pengalaman (Tahun)'),
              
               Tables\Columns\TextColumn::make('bio'),

                Tables\Columns\ImageColumn::make('photo')->circular(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
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
