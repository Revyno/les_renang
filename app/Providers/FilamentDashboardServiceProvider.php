<?php

namespace App\Providers;

use App\Filament\Widgets\LatestStudentsWidget;
use App\Filament\Widgets\LatestRegistrations;
use App\Filament\Widgets\MonthlyIncomeChart;
use App\Filament\Widgets\StudentStatsWidget;
use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;

class FilamentDashboardServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Mendaftarkan widget untuk ditampilkan di dashboard
        Filament::registerWidgets([
            StudentStatsWidget::class,
            LatestRegistrations::class,
            MonthlyIncomeChart::class,

        ]);
    }
}