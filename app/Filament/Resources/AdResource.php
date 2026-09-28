<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdResource\Pages;
use App\Filament\Resources\AdResource\RelationManagers;
use App\Filament\Components\CloudinaryUpload;
use App\Models\Ad;
use App\Support\Media;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdResource extends Resource
{
    protected static ?string $model = Ad::class;

    protected static ?string $navigationIcon = 'heroicon-o-speakerphone';
    protected static ?string $navigationLabel = 'Iklan';
    protected static ?string $navigationGroup = 'Konten Website';
    protected static ?int $navigationSort = 18;
    protected static ?string $modelLabel = 'Iklan';
    protected static ?string $pluralModelLabel = 'Iklan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi')
                            ->minLength(25)
                            ->maxLength(5000)
                            ->columnSpanFull(),
                        CloudinaryUpload::make('image')
                            ->cloudinaryResourceType('auto')
                            ->directory('les-renang/cms/ads')
                            ->required(),
                        Forms\Components\TextInput::make('url')->url()->required(),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('position')
                                    ->options([
                                        'top' => 'Header',
                                        'sidebar' => 'Sidebar',
                                        'bottom' => 'Footer'
                                    ])->required(),
                                Forms\Components\Select::make('status')
                                    ->options([
                                        'pending' => 'Pending',
                                        'active' => 'Active',
                                        'expired' => 'Expired',
                                        'rejected' => 'Rejected'
                                    ])->required(),
                                Forms\Components\DateTimePicker::make('start_date')->required(),
                                Forms\Components\DateTimePicker::make('end_date')->required(),
                            ]),
                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->prefix('Rp')
                            ->required(),
                        Forms\Components\Select::make('advertiser_id')
                            ->relationship('advertiser', 'name')
                            ->required(),
                    ]),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
           ->columns([
                Tables\Columns\ImageColumn::make('image')->getStateUsing(fn ($record) => Media::url($record->image)),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('position'),
                Tables\Columns\TextColumn::make('price')->money('IDR', true),
                Tables\Columns\BadgeColumn::make('status')
                    ->enum([
                        'pending' => 'Pending',
                        'active' => 'Active',
                        'expired' => 'Expired',
                        'rejected' => 'Rejected'
                    ])
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'active',
                        'secondary' => 'expired',
                        'danger' => 'rejected',
                    ]),
                Tables\Columns\TextColumn::make('start_date')->dateTime(),
                Tables\Columns\TextColumn::make('end_date')->dateTime(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'active' => 'Active',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('approve')
                    ->action(fn (Ad $record) => $record->update(['status' => 'active']))
                    ->requiresConfirmation()
                    ->color('success')
                    ->visible(fn (Ad $record) => $record->status === 'pending'),
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
            'index' => Pages\ListAds::route('/'),
            'create' => Pages\CreateAd::route('/create'),
            'edit' => Pages\EditAd::route('/{record}/edit'),
        ];
    }
}
