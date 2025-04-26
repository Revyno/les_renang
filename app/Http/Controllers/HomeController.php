<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Program;
use App\Models\Instructor;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        // Total pendaftaran
        $registrationCount = Registration::count();

        // Pendaftaran hari ini
        $registrationToday = Registration::whereDate('created_at', Carbon::today())->count();

        // Total program
        $programCount = Program::count();

        // Total instruktur
        $instructorCount = Instructor::count();

        // Data chart pendaftaran bulanan (dummy jika belum ada datanya)
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = Registration::whereMonth('created_at', $i)->count();
        }

        // Pendaftaran terbaru (5 terakhir)
        $latestRegistrations = Registration::latest()->take(5)->get();

        return view('home', compact(
            'registrationCount',
            'registrationToday',
            'programCount',
            'instructorCount',
            'chartData',
            'latestRegistrations'
        ));
    }
}
