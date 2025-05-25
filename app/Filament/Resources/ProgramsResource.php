<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgramsResource\Pages;
use App\Models\Program;
use App\Models\Classes;
use App\Models\Instructor;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class ProgramsResource extends Resource
{
    protected static ?string $model = Program::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard';
    protected static ?string $navigationGroup = 'Menagement';
    protected static ?string $modelLabel = 'Program';
    protected static ?string $pluralModelLabel = 'Programs';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Select::make('class_id')
                        ->options(Classes::all()->pluck('title', 'id'))
                            // ->relationship('class', 'title')
                            ->label('Class')
                            ->searchable()
                            ->required(),
                        
                        Forms\Components\Select::make('instructor_id')
                        ->options(Instructor::all()->pluck('name', 'id'))
                            // ->relationship('instructor', 'name')
                            ->label('Instructor')
                            ->searchable()
                            ->required(),
                            
                        Forms\Components\TextInput::make('name')
                            ->label('Program Name')
                            ->required()
                            ->maxLength(255),
                            
                        // Forms\Components\TextInput::make('age_range')
                        //     ->label('Age Range')
                        //     ->required()
                        //     ->maxLength(50),
                            
                        Forms\Components\Select::make('age_range')
                        ->label('Age Range')
                        ->options([
                            '3-5 years' => '3-5 years',
                            '6-8 years' => '6-8 years', 
                            '9-12 years' => '9-12 years',
                            '13-15 years' => '13-15 years',
                            '16-18 years' => '16-18 years',
                            '18+ years' => '18+ years'
                        ])
                        ->required()
                        ->searchable(),
                        Forms\Components\DatePicker::make('schedule_date')
                            ->required(),
                       
                        Forms\Components\DatePicker::make('schadule_end')
                            ->required(),
                            
                            Forms\Components\Select::make('day')
                        ->label('Hari')
                            ->options([
                            'Senin' => 'Senin',
                            'Selasa' => 'Selasa',
                            'Rabu' => 'Rabu',
                            'Kamis' => 'Kamis',
                            'Jumat' => 'Jumat',
                            'Sabtu' => 'Sabtu',
                            'Minggu' => 'Minggu',
                            ])  
                    ->required(),
                        Forms\Components\TimePicker::make('start_time')
                            ->required(),
                            
                        Forms\Components\TimePicker::make('end_time')
                            ->required(),
                            
                            
                        Forms\Components\TextInput::make('capacity')
                            ->numeric()
                            ->required(),
                            
                        Forms\Components\Toggle::make('toggle')
                            ->label('Active Status')
                            ->onColor('success')
                            ->offColor('danger')
                            ->default(true),
                            
                        // Forms\Components\TextInput::make('price')
                        //     ->numeric()
                        //     ->required(),
                            
                        Forms\Components\Textarea::make('description')
                            ->columnSpan('full'),
                            
                        Forms\Components\FileUpload::make('thumbnail')
                            ->label('Thumbnail')
                            ->image()
                            ->directory('program-thumbnails')
                            ->visibility('public')
                            ->columnSpan('full'),
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('class.title')
                    ->label('Class')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('instructor.name')
                    ->label('Instructor')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('schedule_date')
                ->label('mulai')
                    ->date()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('schadule_end')
                ->label('end')
                    ->date()
                    ->sortable(),
                      
                Tables\Columns\TextColumn::make('day')
                    ->label('Hari')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('start_time')
                ->label('selesai')
                    ->time(),
                    
                Tables\Columns\TextColumn::make('end_time')
                    ->time(),
                    
                Tables\Columns\TextColumn::make('level'),
                    
                Tables\Columns\TextColumn::make('capacity')
                ->label('Kapasitas'),
                    
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                     ->trueIcon('heroicon-o-check')
                     ->falseIcon('heroicon-o-x')
                    ->trueColor('success')
                    ->falseColor('danger'),
                    
                Tables\Columns\TextColumn::make('formatted_price')
                    ->label('Price'),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->placeholder('All')
                    ->trueLabel('Active')
                    ->falseLabel('Inactive'),


            Tables\Filters\SelectFilter::make('day')
                    ->label('Filter Hari')
                    ->options([
                        'Senin' => 'Senin',
                        'Selasa' => 'Selasi',
                        'rabu' => 'Rabu',
                        'Kamis' => 'Kamis',
                        'Jumat' => 'Jumat',
                        'Sabtu' => 'Sabtu',
                        'Minggu' => 'Minggu',
                    ]),                    
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
            // Tambahkan relations jika diperlukan
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPrograms::route('/'),
            'create' => Pages\CreatePrograms::route('/create'),
            'edit' => Pages\EditPrograms::route('/{record}/edit'),
        ];
    }
}