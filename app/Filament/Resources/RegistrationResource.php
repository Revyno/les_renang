<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegistrationResource\Pages;
use App\Models\Registration;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use App\Exports\RegistrationsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

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
                Forms\Components\Select::make('user_id')
                    ->options(User::pluck('name', 'id')->all())
                    ->searchable()
                    ->required()
                    ->label('User'),

                Forms\Components\Select::make('class_id')
                    ->options(\App\Models\Classes::all()->pluck('title', 'id'))
                    ->searchable()
                    ->required()
                    ->label('Class'),

                Forms\Components\Select::make('program_id')
                    ->options(\App\Models\Program::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->label('Program'),

                Forms\Components\TextInput::make('parent_name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('parent_email')
                    ->email()
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('parent_phone')
                    ->tel()
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('student_name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('student_age')
                    ->required()
                    ->numeric(),

                Forms\Components\Select::make('student_gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                    ])
                    ->required(),

                Forms\Components\FileUpload::make('student_photo')
                    ->label('Child Photo')
                    ->directory('children-photos')
                    ->image()
                    ->maxSize(2048)
                    ->helperText('Upload a clear photo of the child (max 2MB)')
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('medical_notes')
                    ->columnSpanFull(),

                Forms\Components\DatePicker::make('registration_date')
                    ->default(now())
                    ->required(),

                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'cancelled' => 'Cancelled',
                        'completed' => 'Completed',
                    ])
                    ->default('pending')
                    ->required(),

                Forms\Components\FileUpload::make('payment_proof')
                    ->directory('payment-proofs')
                    ->visibility('private'),

                Forms\Components\Select::make('payment_status')
                    ->options([
                        'unpaid' => 'Unpaid',
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                    ])
                    ->default('unpaid')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('class.title')
                    ->label('Class')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('program.name')
                    ->label('Program')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('student_name')
                    ->label('Student Name')
                    ->searchable(),

                Tables\Columns\ImageColumn::make('student_photo')
                    ->label('Photo')
                    ->rounded()
                    ->size(40),

                Tables\Columns\TextColumn::make('registration_date')
                    ->date()
                    ->label('Registration Date')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->enum([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'cancelled' => 'Cancelled',
                        'completed' => 'Completed',
                    ])
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                        'secondary' => 'cancelled',
                        'primary' => 'completed',
                    ]),

                Tables\Columns\BadgeColumn::make('payment_status')
                    ->enum([
                        'unpaid' => 'Unpaid',
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                    ])
                    ->colors([
                        'danger' => 'unpaid',
                        'warning' => 'pending',
                        'success' => 'paid',
                    ]),
            ])
            ->headerActions([
                Tables\Actions\Action::make('export')
                    ->label('Export Data')
                    ->icon('heroicon-o-document-download')
                    ->color('success')
                    ->action(function () {
                        return Excel::download(
                            new RegistrationsExport(),
                            'registrations-'.now()->format('Y-m-d').'.xlsx'
                        );
                    })
                    ->tooltip('Export all registrations to Excel'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'cancelled' => 'Cancelled',
                        'completed' => 'Completed',
                    ]),
                Tables\Filters\SelectFilter::make('payment_status')
                    ->options([
                        'unpaid' => 'Unpaid',
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                    ]),
                Tables\Filters\Filter::make('registration_date')
                    ->form([
                        Forms\Components\DatePicker::make('from_date'),
                        Forms\Components\DatePicker::make('until_date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from_date'],
                                fn (Builder $query, $date): Builder => $query->whereDate('registration_date', '>=', $date),
                            )
                            ->when(
                                $data['until_date'],
                                fn (Builder $query, $date): Builder => $query->whereDate('registration_date', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
           ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
            Tables\Actions\BulkAction::make('export')
            ->label('Export Selected')
            ->icon('heroicon-o-document-download')
            ->action(function (Collection $records) {
            return Excel::download(
                new RegistrationsExport($records), // Kirim records yang dipilih
                'selected-registrations-'.now()->format('Y-m-d').'.xlsx'
            );
        }),
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