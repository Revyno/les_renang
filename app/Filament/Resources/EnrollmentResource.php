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
    protected static ?string $navigationLabel = 'Enrollments';
    protected static ?string $navigationGroup = 'Enrollment Management';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('registration_id')
                    ->label('Student')
                    // ->options(User::all()->pluck('name', 'id'))
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
                        'cancelled' => 'Cancelled',
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
            ]);
    }

    public static function table(Table $table):Table
    {
        return $table
            ->columns([
               Tables\Columns\TextColumn::make('student_name')->label('Student')->searchable(),
               Tables\Columns\TextColumn::make('classes_title')->label('Class')->searchable(),
               Tables\Columns\TextColumn::make('program_name')->label('Program')->searchable(),
               Tables\Columns\TextColumn::make('instructor_name')->label('Instructor')->searchable(),
               Tables\Columns\TextColumn::make('status')->label('Status')->sortable(),
               Tables\Columns\TextColumn::make('payment_status')->label('Payment Status')->sortable(),
               Tables\Columns\TextColumn::make('created_at')->label('Enrollment Date')->date(),
            ])
            ->filters([
                // Add filters here if necessary
            ]);
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
