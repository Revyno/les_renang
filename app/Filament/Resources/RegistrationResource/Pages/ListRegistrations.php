<?php

namespace App\Filament\Resources\RegistrationResource\Pages;

use App\Filament\Resources\RegistrationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRegistrations extends ListRecords
{
    protected static string $resource = RegistrationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
