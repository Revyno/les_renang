<?php

namespace App\Filament\Widgets;

use App\Http\Controllers\Auth\RegisterController;
use App\Models\Registration;
use App\Models\Student;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Carbon\Carbon;

class StudentsChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Grafik Siswa';
    
    // Opsional: mengatur polling untuk update otomatis
    // protected static ?string $pollingInterval = '10s';
    
    // Mengatur ukuran chart, nilai default 'md'
    protected int | string | array $columnSpan = 'full';
    
    // Jenis chart: line, bar, pie, doughnut, polarArea, radar
    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        // Contoh: Mendapatkan jumlah siswa per bulan dalam 6 bulan terakhir
        $data = Trend::model(Registration::class)
            ->between(
                start: now()->subMonths(6),
                end: now(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Siswa Baru',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#36A2EB',
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => Carbon::parse($value->date)->format('M')),
        ];
    }

    // Opsional: Konfigurasi chart lanjutan
    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
        ];
    }
}