<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeamsResource\Pages;
use App\Filament\Components\CloudinaryUpload;
use App\Models\Teams;
use App\Support\Media;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class TeamsResource extends Resource
{
    protected static ?string $model = Teams::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Tim & Pelatih';
    protected static ?string $navigationGroup = 'Konten Website';
    protected static ?int $navigationSort = 17;
    protected static ?string $modelLabel = 'Tim & Pelatih';
    protected static ?string $pluralModelLabel = 'Tim & Pelatih';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        CloudinaryUpload::make('imgUrl')
                            ->label('Team Member Image')
                            ->image()
                            ->directory('les-renang/cms/teams')
                            ->required(),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nama')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('position')
                                    ->label('Posisi')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('fblink')
                                    ->label('Facebook Link')
                                    ->url()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('instalink')
                                    ->label('Instagram Link')
                                    ->url()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('twitterlink')
                                    ->label('Twitter Link')
                                    ->url()
                                    ->maxLength(255),
                            ]),
                        Forms\Components\Toggle::make('status')
                            ->label('Active Status')
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('imgUrl')
                    ->label('Image')
                    ->getStateUsing(fn ($record) => Media::url($record->imgUrl)),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('position')
                    ->label('Posisi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('status')
                    ->label('Status')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('active')
                    ->label('Active Only')
                    ->query(fn (Builder $query): Builder => $query->where('status', true)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListTeams::route('/'),
            'create' => Pages\CreateTeams::route('/create'),
            'edit' => Pages\EditTeams::route('/{record}/edit'),
        ];
    }
}
