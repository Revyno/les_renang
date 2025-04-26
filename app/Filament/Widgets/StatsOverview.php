<?php

namespace App\Filament\Widgets;
use App\Models\Instructor;
use App\Models\Student;
use App\Models\User;
use App\Models\Booking;
use App\Models\Payment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            // Card::make('Total Murid', User::where('role', 'student')->count())
            //     ->description('Jumlah murid terdaftar')
            //     ->descriptionIcon('heroicon-o-users')
            //     ->color('primary'),
            // // Card::make('Booking Aktif', Booking::where('status', 'confirmed')->count())
            //     ->description('Total booking aktif')
            //     ->descriptionIcon('heroicon-o-calendar')
            //     ->color('success'),
            // Card::make('Pendapatan Total', 'Rp ' . number_format(Payment::where('status', 'completed')->sum('amount'), 0, ',', '.'))
            //     ->description('Total pendapatan')
            //     ->descriptionIcon('heroicon-o-cash')
            //     ->color('warning'),
            // Stat::make('Total Siswa', Student::count())
            // ->description('3% kenaikan')
            // ->descriptionIcon('heroicon-m-arrow-trending-up')
            // ->color('primary'),
            //  Stat::make('Total Instruktur', Instructor::count())
            // ->color('success'),
            //  Stat::make('Pendapatan Bulan Ini', 'Rp ' . number_format(Pembayaran::whereMonth('created_at', now()->month)->sum('jumlah') / 1000000, 1) . ' jt')
            // ->description('12% kenaikan')
            // ->descriptionIcon('heroicon-m-arrow-trending-up')
            // ->color('warning'),
        ];
    }
}
