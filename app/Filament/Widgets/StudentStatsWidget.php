<?php

namespace App\Filament\Widgets;

use App\Models\Registration;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\DB;

class StudentStatsWidget extends BaseWidget
{
    protected function getCards(): array
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $previousMonth = now()->subMonth()->month;
        $previousYear = now()->subMonth()->year;

        // Get current month registrations count
        $currentMonthRegistrations = Registration::whereMonth('registration_date', $currentMonth)
            ->whereYear('registration_date', $currentYear)
            ->count();

        // Get previous month registrations count
        $previousMonthRegistrations = Registration::whereMonth('registration_date', $previousMonth)
            ->whereYear('registration_date', $previousYear)
            ->count();

        // Calculate percentage change
        $percentageChange = $previousMonthRegistrations > 0 
            ? (($currentMonthRegistrations - $previousMonthRegistrations) / $previousMonthRegistrations) * 100
            : ($currentMonthRegistrations > 0 ? 100 : 0);

        // Get most popular program
        $mostPopularProgram = Registration::select('program_id', DB::raw('count(*) as total'))
            ->with('program')
            ->groupBy('program_id')
            ->orderByDesc('total')
            ->first();

        return [
            Card::make('Total Registrations', Registration::count())
                ->description('All time registrations')
                ->descriptionIcon('heroicon-s-document-text')
                ->color('primary'),
                
            Card::make('Approved Registrations', Registration::where('status', 'approved')->count())
                ->description('Successfully approved')
                ->descriptionIcon('heroicon-s-check-circle')
                ->color('success'),
                
            Card::make('Pending Actions', Registration::whereIn('status', ['pending'])
                ->orWhere('payment_status', 'pending')
                ->count())
                ->description('Requiring attention')
                ->descriptionIcon('heroicon-s-exclamation-circle')
                ->color('warning'),
                
            Card::make('New Registrations', $currentMonthRegistrations)
                ->description(
                    $percentageChange >= 0 
                        ? '↑ ' . number_format($percentageChange, 1) . '% from last month' 
                        : '↓ ' . number_format(abs($percentageChange), 1) . '% from last month'
                )
                ->descriptionIcon($percentageChange >= 0 ? 'heroicon-s-trending-up' : 'heroicon-s-trending-down')
                ->color($percentageChange >= 0 ? 'success' : 'danger'),
                
            Card::make('Paid Registrations', Registration::where('payment_status', 'paid')->count())
                ->description(number_format(Registration::count() > 0 
                    ? (Registration::where('payment_status', 'paid')->count() / Registration::count()) * 100 
                    : 0, 1) . '% payment completion')
                ->descriptionIcon('heroicon-s-currency-dollar')
                ->color('success'),
                
            Card::make('Most Popular Program', $mostPopularProgram ? $mostPopularProgram->program->name : 'N/A')
                ->description($mostPopularProgram ? $mostPopularProgram->total . ' registrations' : 'No data')
                ->descriptionIcon('heroicon-s-star')
                ->color('info'),
        ];
    }
}