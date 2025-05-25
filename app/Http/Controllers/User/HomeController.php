<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Instructor;
use App\Models\Program;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class HomeController extends Controller
{
    /**
     * Tampilan utama
     */
    public function index()
    {

        // $kontenHome = Konten::where('halaman', 'home')
        // ->where('status', 'active')
        // ->get();

        return view('frontend.home', [
            'featuredClasses' => Classes::with(['instructors', 'programs'])
                ->whereHas('programs', function($query) {
                    $query->where('is_featured', true);
                })
                ->take(4)
                ->get(),
                
            'instructors' => Instructor::withCount('classes')
                ->orderBy('classes_count', 'desc')
                ->take(4)
                ->get(),
                
            'testimonials' => Registration::with(['user', 'class'])
                ->where('status', 'completed')
                ->whereNotNull('rating')
                ->take(6)
                ->get()
        ]);
    }

    /**
     * Tampilan semua program/kursus
     */
    public function programs(Request $request)
    {
        $query = Program::query()->withCount('classes');

        // Filter berdasarkan level
        if ($request->has('level')) {
            $query->whereHas('classes', function($q) use ($request) {
                $q->where('level', $request->level);
            });
        }

        return view('frontend.programs', [
            'programs' => $query->paginate(6),
            'levels' => [
                'beginner' => 'Pemula',
                'intermediate' => 'Menengah',
                'advanced' => 'Lanjutan'
            ]
        ]);
    }

    /**
     * Tampilan detail program
     */
    public function showProgram(Program $program)
    {
        return view('frontend.program-detail', [
            'program' => $program->load(['classes.instructors']),
            'relatedPrograms' => Program::where('id', '!=', $program->id)
                ->whereHas('classes')
                ->take(3)
                ->get()
        ]);
    }

    /**
     * Tampilan semua pelatih
     */
    public function instructors()
    {
        return view('frontend.instructors', [
            'instructors' => Instructor::withCount('classes')
                ->orderBy('classes_count', 'desc')
                ->paginate(8)
        ]);
    }

    /**
     * Tampilan detail pelatih
     */
    public function showInstructor(Instructor $instructor)
    {
        return view('frontend.instructor-detail', [
            'instructor' => $instructor->load(['classes.programs']),
            'classes' => $instructor->classes()
                ->withCount('registrations')
                ->paginate(4)
        ]);
    }

    /**
     * Tampilan jadwal kelas
     */
    public function program(Request $request)
    {
        $query = Program::query()
            ->with(['instructors', 'programs'])
            ->whereHas('registrations', function($q) {
                $q->where('status', 'approved');
            },
              '<', \DB::raw('capacity'));

        // Filter berdasarkan program
        if ($request->has('program')) {
            $query->whereHas('programs', function($q) use ($request) {
                $q->where('id', $request->program);
            });
        }

        // Filter berdasarkan level
        if ($request->has('level')) {
            $query->where('level', $request->level);
        }

        return view('frontend.schedule', [
            'classes' => $query->paginate(6),
            'programs' => Program::has('classes')->get(),
            'levels' => [
                'beginner' => 'Pemula',
                'intermediate' => 'Menengah',
                'advanced' => 'Lanjutan'
            ]
        ]);
    }

    /**
     * Tampilan detail kelas
     */
    public function showClass(Classes $class)
    {
        $class->load(['instructors', 'programs', 'registrations.user']);

        // Hitung slot tersedia
        $availableSlots = $class->max_participants - $class->registrations()
            ->where('status', 'approved')
            ->count();

        return view('frontend.class-detail', [
            'class' => $class,
            'availableSlots' => $availableSlots,
            'relatedClasses' => Classes::where('id', '!=', $class->id)
                ->whereHas('programs', function($q) use ($class) {
                    $q->whereIn('id', $class->programs->pluck('id'));
                })
                ->take(3)
                ->get()
        ]);
    }

    /**
     * Handle pencarian
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        $classes = Classes::where('title', 'like', "%$query%")
            ->orWhere('description', 'like', "%$query%")
            ->with(['instructors', 'programs'])
            ->paginate(6);

        $instructors = Instructor::where('name', 'like', "%$query%")
            ->orWhere('specialization', 'like', "%$query%")
            ->paginate(6);

        return view('frontend.search', [
            'classes' => $classes,
            'instructors' => $instructors,
            'searchQuery' => $query
        ]);
    }
}