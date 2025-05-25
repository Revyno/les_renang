<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class AdminDashboard extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total Users', User::count()),
            Card::make('Admins', User::where('role', 'admin')->count()),
            Card::make('Students', User::where('role', 'student')->count()),
        ];
    }

    public static function canView(): bool
    {
        return auth()->user()->isAdmin();
    }
}