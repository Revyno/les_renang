<?php

namespace App\Filament\Resources\InstructorsResource\Pages;

use App\Filament\Resources\InstructorsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInstructors extends EditRecord
{
    protected static string $resource = InstructorsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
