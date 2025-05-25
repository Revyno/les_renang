<?php

namespace App\Filament\Resources\JadwalLesResource\Pages;

use App\Filament\Resources\JadwalLesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJadwalLes extends EditRecord
{
    protected static string $resource = JadwalLesResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function mutateFormDataBeforeSave(array $data): array
{
    $this->instructors = $data['instructors'] ?? [];

    unset($data['instructors']);

    return $data;
}

protected function afterSave(): void
{
    $this->record->instructors()->sync($this->instructors);
}
}
