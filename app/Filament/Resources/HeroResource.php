<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroResource\Pages;
use App\Filament\Resources\HeroResource\RelationManagers;
use App\Models\Hero;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HeroResource extends Resource
{
    protected static ?string $model = Hero::class;

    protected static ?string $navigationIcon = 'heroicon-o-photograph';

    protected static ?string $navigationGroup = 'Menagement';
    protected static ?string $navigationLabel = 'Hero';
    protected static ?string $label = 'Hero';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                    Forms\Components\Card::make()->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\Textarea::make('subtitle')
                    ->required()
                    ->maxLength(500),
                
                Forms\Components\FileUpload::make('image')
                    ->directory('hero-images')
                    ->image()
                    ->required()
                    ->helperText('Rekomendasi ukuran: 1920x1080 px'),
                
                Forms\Components\FileUpload::make('video_background')
                    ->directory('hero-videos')
                    ->acceptedFileTypes(['video/mp4'])
                    ->helperText('Upload video MP4 (opsional)'),
                
                Forms\Components\TextInput::make('cta_text')
                    ->label('Tombol Utama - Teks')
                    ->default('Daftar Sekarang'),
                
                Forms\Components\TextInput::make('cta_link')
                    ->label('Tombol Utama - Link')
                    ->default('#programs'),
                
                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
                
                Forms\Components\TextInput::make('order')
                    ->numeric()
                    ->default(0)
                     ])
                //
            ]);
    }

    public static function table(Table $table): Table
    {
         return $table->columns([
            Tables\Columns\ImageColumn::make('image')
                ->label('Gambar'),
                
            Tables\Columns\TextColumn::make('title')
                ->searchable()
                ->sortable(),
                
            Tables\Columns\IconColumn::make('is_active')
                ->boolean()
                ->label('Status'),
                
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime('d M Y')
                ->sortable()
        ])
        ->filters([
            Tables\Filters\Filter::make('active')
                ->query(fn ($query) => $query->where('is_active', true))
                ->label('Aktif Saja')
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
            'index' => Pages\ListHeroes::route('/'),
            'create' => Pages\CreateHero::route('/create'),
            'edit' => Pages\EditHero::route('/{record}/edit'),
        ];
    }    
}
