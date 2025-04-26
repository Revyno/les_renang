<?php

namespace App\Filament\Resources\RegistrationResource\Pages;

use App\Filament\Resources\RegistrationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRegistration extends EditRecord
{
    protected static string $resource = RegistrationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
