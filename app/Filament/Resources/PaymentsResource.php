<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentsResource\Pages;
use App\Filament\Resources\PaymentsResource\RelationManagers;
use App\Models\Payment;
use App\Models\Student;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Filament\Tables\Filters\DateFilter;

class PaymentsResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationLabel = 'Payment';
    protected static ?string $navigationGroup = 'Revenues';
    protected static ?string $navigationIcon = 'heroicon-o-cash';

  
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Select::make('registration_id')
                            ->relationship('registration', 'id', fn ($query) => $query->with('user', 'class'))
                            ->getOptionLabelFromRecordUsing(fn ($record) => 
                                "{$record->user->name} - {$record->class->title} (Rp " . number_format($record->class->price, 0, ',', '.') . ")"
                            )
                            ->required()
                            ->searchable(),

                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->required()
                            ->default(auth()->id()), 

                        Forms\Components\TextInput::make('amount')
                            ->numeric()
                            ->required()
                            ->prefix('Rp'),

                        Forms\Components\Select::make('method')
                            ->options([
                                'transfer' => 'Transfer Bank',
                                'cash' => 'Tunai',
                                'qris' => 'QRIS',
                                'edc' => 'Kartu Kredit/Debit'
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('transaction_id')
                            ->label('ID Transaksi'),

                        Forms\Components\FileUpload::make('proof')
                            ->directory('payment-proofs')
                            ->image()
                            ->enableDownload()
                            ->enableOpen(),

                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'paid' => 'Dibayar',
                                'failed' => 'Gagal',
                                'refunded' => 'Dikembalikan'
                            ])
                            ->required(),

                        Forms\Components\DateTimePicker::make('paid_at')
                            ->displayFormat('d F Y H:i'),

                        Forms\Components\Textarea::make('notes')
                            ->columnSpan('full')
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('registration.user.name')
                    ->label('Siswa/Orang Tua')
                    ->searchable(),

                Tables\Columns\TextColumn::make('registration.class.title')
                    ->label('Kelas'),

                Tables\Columns\TextColumn::make('amount')
                    ->money('IDR', true)
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->enum([
                        'pending' => 'Pending',
                        'paid' => 'Dibayar',
                        'failed' => 'Gagal',
                        'refunded' => 'Dikembalikan'
                    ])
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                        'danger' => 'failed',
                        'secondary' => 'refunded'
                    ]),

                Tables\Columns\TextColumn::make('paid_at')
                    ->dateTime('d M Y H:i')
                    ->sortable()
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Dibayar'
                    ]),

                Tables\Filters\Filter::make('paid_at')
                    ->form([
                        Forms\Components\DatePicker::make('paid_from'),
                        Forms\Components\DatePicker::make('paid_until')
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['paid_from'],
                                fn ($q) => $q->whereDate('paid_at', '>=', $data['paid_from']))
                            ->when($data['paid_until'],
                                fn ($q) => $q->whereDate('paid_at', '<=', $data['paid_until']));
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('verify')
                    ->action(fn (Payment $record) => $record->update([
                        'status' => 'paid',
                        'paid_at' => now()
                    ]))
                    ->requiresConfirmation()
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->visible(fn (Payment $record) => $record->status === 'pending')
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayments::route('/create'),
            'edit' => Pages\EditPayments::route('/{record}/edit'),
        ];
    }    
}