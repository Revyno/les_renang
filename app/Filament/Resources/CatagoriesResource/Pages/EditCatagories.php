<?php

namespace App\Filament\Resources\CatagoriesResource\Pages;

use App\Filament\Resources\CatagoriesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCatagories extends EditRecord
{
    protected static string $resource = CatagoriesResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
