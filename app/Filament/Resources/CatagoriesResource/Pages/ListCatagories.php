<?php

namespace App\Filament\Resources\CatagoriesResource\Pages;

use App\Filament\Resources\CatagoriesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCatagories extends ListRecords
{
    protected static string $resource = CatagoriesResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
