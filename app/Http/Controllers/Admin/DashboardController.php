<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Program;
use App\Models\Teacher;

class DashboardController extends Controller
{
    public function index()
    {
        $registrationCount = Registration::count();
        $registrationToday = Registration::whereDate('created_at', today())->count();
        $programCount = Program::count();
        $instructorCount = Teacher::count();
        
        $latestRegistrations = Registration::latest()->take(5)->get();
        
        $monthlyCounts = Registration::selectRaw('COUNT(*) as count, MONTH(created_at) as month')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();
        
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $monthlyCounts[$i] ?? 0;
        }
        
        return view('admin.dashboard', compact(
            'registrationCount', 
            'registrationToday', 
            'programCount', 
            'instructorCount', 
            'latestRegistrations',
            'chartData'
        ));
    }
}