<?php

namespace App\Filament\Widgets;

use App\Models\Registration;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestRegistrations extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        return Registration::query()
            ->with(['user', 'class'])
            ->latest()
            ->limit(5);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('user.name')
                ->label('Nama Orang Tua'),
                
            Tables\Columns\TextColumn::make('student_name')
                ->label('Nama Anak'),
                
            // Tables\Columns\TextColumn::make('swimLevel.name')
            //     ->label('Tingkatan'),
                
            Tables\Columns\BadgeColumn::make('status')
                ->enum([
                    'pending' => 'Pending',
                    'approved' => 'Disetujui',
                    'rejected' => 'Ditolak',
                ])
                ->colors([
                    'warning' => 'pending',
                    'success' => 'approved',
                    'danger' => 'rejected',
                ]),
                
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->label('Tanggal Daftar'),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\Action::make('view')
                ->url(fn (Registration $record): string => route('filament.resources.registrations.edit', $record))
                ->icon('heroicon-o-eye'),
        ];
    }
}