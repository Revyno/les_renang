<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Instructor;
use Carbon\Carbon;

class ClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get all instructor IDs or use null if no instructors exist
        $instructorIds = Instructor::pluck('id')->toArray();
        
        $classes = [
            [
                'instructor_id' => !empty($instructorIds) ? $instructorIds[array_rand($instructorIds)] : null,
                'title' => 'Pelajaran Renang Anak-Anak',
                'level' => 'beginner',
                'description' => 'Perfect introduction to yoga practices for those who are just starting their journey. Learn basic poses, breathing techniques, and relaxation methods.',
                'price' => 100,000,
                'sessions' => 12,
                'duration_weeks' => 6,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'instructor_id' => !empty($instructorIds) ? $instructorIds[array_rand($instructorIds)] : null,
                'title' => 'Pelajaran renang untuk Dewasa',
                'level' => 'Advanced',
                'description' => 'Challenge yourself with complex pilates routines designed for experienced practitioners. Focus on core strength, flexibility, and precision movements.',
                'price' => 200,000,
                'sessions' => 16,
                'duration_weeks' => 8,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'instructor_id' => !empty($instructorIds) ? $instructorIds[array_rand($instructorIds)] : null,
                'title' => 'HIIT Workout',
                'level' => 'Intermediate',
                'description' => 'High-Intensity Interval Training that combines cardio and strength exercises. Burn calories and improve your fitness in short, intense workout sessions.',
                'price' => 500,000,
                'sessions' => 10,
                'duration_weeks' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'instructor_id' => !empty($instructorIds) ? $instructorIds[array_rand($instructorIds)] : null,
                'title' => 'Meditation & Mindfulness',
                'level' => 'bqginner',
                'description' => 'Learn meditation techniques to reduce stress and increase mindfulness in daily life. Suitable for practitioners of all experience levels.',
                'price' => 600,000,
                'sessions' => 8,
                'duration_weeks' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'instructor_id' => !empty($instructorIds) ? $instructorIds[array_rand($instructorIds)] : null,
                'title' => 'Strength Training Fundamentals',
                'level' => 'Beginner',
                'description' => 'Learn proper form and techniques for basic strength training exercises. Build a foundation for a stronger, healthier body.',
                'price' => 109.99,
                'sessions' => 12,
                'duration_weeks' => 6,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('classes')->insert($classes);
    }
}