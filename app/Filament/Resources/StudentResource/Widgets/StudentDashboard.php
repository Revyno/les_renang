<?php

namespace App\Filament\Resources\StudentResource\Widgets;

use Filament\Widgets\Widget;

class StudentDashboard extends Widget
{
    protected static string $view = 'filament.resources.student-resource.widgets.student-dashboard';

     protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        return auth()->user()->isStudent();
    }
}
