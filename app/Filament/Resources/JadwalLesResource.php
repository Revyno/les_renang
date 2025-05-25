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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables;
use App\Models\Instructor;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use PhpParser\Builder\Class_;

class JadwalLesResource extends Resource
{
    protected static ?string $model = Classes::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Classes';
    protected static ?string $navigationGroup = 'Menagement';
    

    public static function form(Form $form): Form
    {
        return $form
        
            ->schema([
                
              Forms\Components\Select::make('instructors')
                     ->label('Instruktur')
                     ->multiple()
                     ->options(Instructor::all()->pluck('name', 'id'))
                                    // ->relationship('instructors', 'name')
                     ->searchable()
                     ->required(),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->label('Nama Kelas'),
                // Forms\Components\DatePicker::make('schedule_date')
                //     ->required()
                //     ->label('Tanggal Mulai'),

                // Forms\Components\TimePicker::make('schedule_time')
                //     ->required()
                //     ->label('Jam'),
            
                Forms\Components\Select::make('level')
                ->label('Level')
                ->required()
                ->options([
                    'beginner' => 'Beginner',
                    'intermediate' => 'Intermediate',
                    'advanced' => 'Advanced',
                ]),

                Forms\Components\Textarea::make('description')
                ->rows(10)
                ->cols(20)
                ->minLength(5)
                ->maxLength(500)
                ->required()
                ->label('Deskripsi'),

                Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->required()
                            ->prefix('Rp'),
                
                 Forms\Components\TextInput::make('sessions')
                            ->numeric()
                            ->required()
                            ->label('Jumlah Sesi'),
                // Tables\Columns\TextColumn::make('instructors.name')
                // ->label('Instruktur')
                // ->formatStateUsing(function ($record) {
                //   $instructors = $record->instructors->pluck('name')->toArray();
                //     return implode(', ', $instructors);
                // }),
            
                // Forms\Components\TextInput::make('capacity')
                //     ->required()
                //     ->numeric()
                //     ->label('Kapasitas'),

                // Forms\Components\Select::make('is_active')
                //     ->required()
                //     ->options([
                //         '1' => 'Active',
                //         '0' => 'Inactive',
                //     ])
                //     ->default('1')
                //     ->label('Status'),
                Forms\Components\TextInput::make('duration_weeks')
                            ->numeric()
                            ->required()
                            ->label('Durasi (Minggu)'),


    ]);
           
    }

    public static function table(Table $table): Table
    {
        return $table
                ->columns([
                    Tables\Columns\TextColumn::make('title')->label('Nama Kelas')->searchable(),
                    
                    Tables\Columns\TextColumn::make('instructors.name')
                        ->label('Instruktur')
                        ->formatStateUsing(function ($record) {
                            $instructors = $record->instructors->pluck('name')->toArray();
                            return implode(', ', $instructors);
                        }),
                    
                    // Tables\Columns\TextColumn::make('schedule_date')->date()->label('Tanggal'),
                    // Tables\Columns\TextColumn::make('schedule_time')->label('Jam'),
                    Tables\Columns\BadgeColumn::make('level')
                    ->colors([
                        'primary' => 'beginner',
                        'warning' => 'intermediate',
                        'success' => 'advanced',
                    ]),
                    // Tables\Columns\TextColumn::make('capacity')->label('Kapasitas'),
                    
                    // Tables\Columns\IconColumn::make('is_active')
                    //     ->label('Status')
                    //     ->boolean(),

                    Tables\Columns\TextColumn::make('sessions'),
                
                Tables\Columns\TextColumn::make('duration_weeks')
                    ->label('Durasi')
                    ->suffix(' minggu'),
                        
                    Tables\Columns\TextColumn::make('description')->limit(50)->label('Deskripsi'),

                    Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                    
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