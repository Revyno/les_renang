<?php

namespace App\Filament\Resources\JadwalLesResource\Pages;

use App\Filament\Resources\JadwalLesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJadwalLes extends ListRecords
{
    protected static string $resource = JadwalLesResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
