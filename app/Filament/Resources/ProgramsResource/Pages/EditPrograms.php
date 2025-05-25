<?php

namespace App\Filament\Resources\ProgramsResource\Pages;

use App\Filament\Resources\ProgramsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPrograms extends EditRecord
{
    protected static string $resource = ProgramsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
