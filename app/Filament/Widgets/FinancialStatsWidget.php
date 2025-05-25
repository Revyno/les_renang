<?php

namespace App\Filament\Widgets;

use App\Models\Income;
use App\Models\Payment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class FinancialStatsWidget extends BaseWidget
{
    protected function getCards(): array
    {
        $monthlyIncome = Income::whereMonth('income_date', now()->month)->sum('net_income');
        $annualIncome = Income::whereYear('income_date', now()->year)->sum('net_income');

        return [
            Card::make('Pendapatan Bulan Ini', 'Rp ' . number_format($monthlyIncome, 0, ',', '.'))
                ->icon('heroicon-o-trending-up')
                ->color('success'),

            Card::make('Pendapatan Tahunan', 'Rp ' . number_format($annualIncome, 0, ',', '.'))
                ->icon('heroicon-o-calendar')
                ->color('primary'),

            Card::make('Pembayaran Tertunda', Payment::where('status', 'pending')->count())
                ->icon('heroicon-o-clock')
                ->color('warning'),
        ];
    }
}