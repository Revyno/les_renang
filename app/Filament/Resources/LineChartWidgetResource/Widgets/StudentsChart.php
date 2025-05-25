<?php

namespace App\Filament\Resources\LineChartWidgetResource\Widgets;

use Filament\Widgets\BarChartWidget;

class StudentsChart extends BarChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        return [
            //
        ];
    }
}
