<?php

namespace App\Filament\Resources\JadwalLesResource\Pages;

use App\Filament\Resources\JadwalLesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateJadwalLes extends CreateRecord
{
    protected static string $resource = JadwalLesResource::class;

protected function mutateFormDataBeforeCreate(array $data): array
{
    // Simpan instructors terpisah agar tidak error karena bukan kolom di tabel `classes`
    // $this->instructors = $data['instructors'] ?? [];

    // // Hapus dari $data sebelum insert ke tabel classes
    // unset($data['instructors']);

    // return $data;
    // Simpan instructors terpisah agar tidak error karena bukan kolom di tabel `classes`
    $this->instructors = $data['instructors'] ?? [];

    // Hapus dari $data sebelum insert ke tabel classes
    unset($data['instructors']);

    return $data;
}
protected function afterCreate(): void
{
    // Sync relasi setelah data kelas dibuat
    $this->record->instructors()->sync($this->instructors);
}

}