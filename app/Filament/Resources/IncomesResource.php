<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IncomesResource\Pages;
use App\Filament\Resources\IncomesResource\RelationManagers;
use App\Models\Income;
use App\Models\Payment;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use PhpOffice\PhpSpreadsheet\Calculation\Financial\CashFlow\Constant\Periodic\Payments;

class IncomesResource extends Resource
{
    protected static ?string $model = Income::class;
    protected static ?string $navigationLabel = 'Income';
    protected static ?string $navigationGroup = 'Revenues';

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    public static function form(Form $form): Form
    {
       return $form
        ->schema([
            Forms\Components\Card::make()
                ->schema([
                    Forms\Components\Select::make('payment_id')
                        ->relationship('payment', 'id', fn ($query) => $query->paid()->with('registration'))
                        ->getOptionLabelFromRecordUsing(fn ($record) => 
                            "Pembayaran #{$record->id} - Rp " . number_format($record->amount, 0, ',', '.')
                        )
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set) {
                            if ($payments = Payment::find($state)) {
                                $set('amount', $payments->amount);
                            }
                            else {
                                $set('amount', 0);
                            }
                        })
                        ->searchable(),

                    Forms\Components\TextInput::make('amount')
                        ->numeric()
                        ->required()
                        ->prefix('Rp')
                        ->disabled(),

                    Forms\Components\TextInput::make('tax')
                        ->numeric()
                        ->prefix('Rp')
                        ->default(0)
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $get, callable $set) {
                            $set('net_income', 
                                $get('amount') - $state - $get('operational_fee') - $get('instructor_fee')
                            );
                        }),

                    Forms\Components\TextInput::make('operational_fee')
                        ->numeric()
                        ->prefix('Rp')
                        ->default(0)
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $get, callable $set) {
                            $set('net_income', 
                                $get('amount') - $get('tax') - $state - $get('instructor_fee')
                            );
                        }),
                        
                         Forms\Components\TextInput::make('instructor_fee')
                        ->numeric()
                        ->prefix('Rp')
                        ->default(0)
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $get, callable $set) {
                            $set('net_income', 
                                $get('amount') - $get('tax') - $get('operational_fee') - $state
                            );
                        }),
                   
                    Forms\Components\TextInput::make('net_income')
                        ->numeric()
                        ->prefix('Rp')
                        ->disabled(),

                    Forms\Components\DatePicker::make('income_date')
                        ->required()
                        ->default(now())
                    ])  
                 ]);
    }

    public static function table(Table $table): Table
    {
       return $table
            ->columns([
                Tables\Columns\TextColumn::make('payment.registration.user.name')
                    ->label('Siswa'),

                Tables\Columns\TextColumn::make('payment.amount')
                    ->money('IDR', true)
                    ->label('Jumlah Kotor'),

                Tables\Columns\TextColumn::make('net_income')
                    ->money('IDR', true)
                    ->label('Pendapatan Bersih'),

                Tables\Columns\TextColumn::make('income_date')
                    ->date('d M Y')
                    ->sortable()
            ])
            ->filters([
                Tables\Filters\Filter::make('income_date')
                    ->form([
                        Forms\Components\DatePicker::make('from_date'),
                        Forms\Components\DatePicker::make('to_date')
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from_date'],
                                fn ($q) => $q->whereDate('income_date', '>=', $data['from_date']))
                            ->when($data['to_date'],
                                fn ($q) => $q->whereDate('income_date', '<=', $data['to_date']));
                    })
                       ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListIncomes::route('/'),
            'create' => Pages\CreateIncomes::route('/create'),
            'edit' => Pages\EditIncomes::route('/{record}/edit'),
        ];
    }    
}
