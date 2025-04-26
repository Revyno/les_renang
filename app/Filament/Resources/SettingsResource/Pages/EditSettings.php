<?php

namespace App\Filament\Resources\SettingsResource\Pages;

use App\Filament\Resources\SettingsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSettings extends EditRecord
{
    protected static string $resource = SettingsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
