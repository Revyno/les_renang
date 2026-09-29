<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EnrollmentResource\Pages;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Classes;
use App\Models\Program;
use App\Models\Instructor;
use Filament\Forms;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Resources\Form;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;

class EnrollmentResource extends Resource
{
    protected static ?string $model = Enrollment::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark';
    protected static ?string $navigationLabel = 'Pendaftaran Kelas';
    protected static ?string $navigationGroup = 'Manajemen Les';
    protected static ?int $navigationSort = 4;
    protected static ?string $modelLabel = 'Pendaftaran Kelas';
    protected static ?string $pluralModelLabel = 'Pendaftaran Kelas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Select::make('registration_id')
                            ->label('Student')
                            ->options(\App\Models\Registration::all()->pluck('student_name', 'id'))
                            ->searchable()
                            ->required(),

                        Forms\Components\Select::make('class_id')
                            ->label('Class')
                            ->options(Classes::all()->pluck('title', 'id'))
                            ->searchable()
                            ->required(),

                        Forms\Components\Select::make('program_id')
                            ->label('Program')
                            ->options(Program::all()->pluck('name', 'id'))
                            ->searchable()
                            ->required(),

                        Forms\Components\Select::make('instructor_id')
                            ->label('Instructor')
                            ->options(Instructor::all()->pluck('name', 'id'))
                            ->searchable()
                            ->required(),

                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Pending',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                                'completed' => 'Completed',
                            ])
                            ->default('pending')
                            ->required(),

                        Forms\Components\Select::make('payment_status')
                            ->label('Payment Status')
                            ->options([
                                'unpaid' => 'Unpaid',
                                'paid' => 'Paid',
                            ])
                            ->default('unpaid')
                            ->required(),

                        Forms\Components\DatePicker::make('created_at')
                            ->label('Enrollment Date')
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table):Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('registration_id')
                    ->label('Registration')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('program.name')
                    ->label('Program')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('instructor.name')
                    ->label('Instructor')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                        'primary' => 'completed',
                    ]),

                Tables\Columns\BadgeColumn::make('payment_status')
                    ->label('Payment Status')
                    ->colors([
                        'danger' => 'unpaid',
                        'success' => 'paid',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Enrollment Date')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Add filters here if necessary
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['program', 'instructor']);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEnrollments::route('/'),
            'create' => Pages\CreateEnrollment::route('/create'),
            'edit' => Pages\EditEnrollment::route('/{record}/edit'),
        ];
    }
}
