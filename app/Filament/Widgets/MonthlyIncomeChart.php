<?php

namespace App\Filament\Widgets;

use App\Models\Income;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\LineChartWidget;

class MonthlyIncomeChart extends LineChartWidget
{
    protected static ?string $heading = 'Pendapatan Bulanan';

    protected function getData(): array
    {
        $data = Trend::model(Income::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->sum('net_income');

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan Bersih',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#4f46e5',
                    'borderColor' => '#4f46e5',
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }
}