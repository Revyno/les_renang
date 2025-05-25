<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\FilamentServiceProvider as BaseFilamentServiceProvider;
use Filament\Navigation\NavigationItem;
use Filament\Pages;

class FilamentServiceProvider extends BaseFilamentServiceProvider
{
    public function boot()
    {
        parent::boot();

        Filament::serving(function () {
            // Register navigation items
            Filament::registerNavigationItems([
                NavigationItem::make('Website')
                    ->url('/')
                    ->icon('heroicon-o-home')
                    ->sort(3),
            ]);
        });
    }

    protected function panel(): void
    {
        Filament::panel('admin', [
            'id' => 'admin',
            'path' => 'admin',
            'login' => true,
            'colors' => [
                'primary' => '#4f46e5',
            ],
            'resources' => app_path('Filament/Resources'),
            'pages' => [
                Pages\Dashboard::class,
            ],
            'widgets' => [
                \App\Filament\Widgets\StatsOverview::class,
            ],
        ]);
    }
}