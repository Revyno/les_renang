<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Program;
use App\Models\Classes;
use App\Models\Instructor;
use Carbon\Carbon;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // First check if we have classes and instructors to work with
        $classCount = Classes::count();
        $instructorCount = Instructor::count();

        if ($classCount == 0 || $instructorCount == 0) {
            $this->command->info('Please run the ClassSeeder and InstructorSeeder first!');
            return;
        }

        // Get all class and instructor IDs to use for random assignment
        $classIds = Classes::pluck('id')->toArray();
        $instructorIds = Instructor::pluck('id')->toArray();

        // Sample program data
        $programs = [
            [
                'class_id' => $classIds[array_rand($classIds)],
                'instructor_id' => $instructorIds[array_rand($instructorIds)],
                'age_range' => '6-8 years',
                'day' => 'Senin',
                'schedule_date' => Carbon::now()->format('Y-m-d'),
                'schadule_end' => Carbon::now()->addMonths(3)->format('Y-m-d'),
                'start_time' => '09:00:00',
                'end_time' => '11:00:00',
                'capacity' => 15,
                'toggle' => true,
                'description' => 'Program dasar untuk anak-anak dengan fokus pada pengembangan kreativitas.',
                'thumbnail' => 'program-thumbnails/program1.jpg',
            ],
            [
                'class_id' => $classIds[array_rand($classIds)],
                'instructor_id' => $instructorIds[array_rand($instructorIds)],
                'age_range' => '9-12 years',
                'day' => 'Selasa',
                'schedule_date' => Carbon::now()->format('Y-m-d'),
                'schadule_end' => Carbon::now()->addMonths(3)->format('Y-m-d'),
                'start_time' => '13:00:00',
                'end_time' => '15:00:00',
                'capacity' => 20,
                'toggle' => true,
                'description' => 'Program menengah untuk anak-anak dengan fokus pada keterampilan pemecahan masalah.',
                'thumbnail' => 'program-thumbnails/program2.jpg',
            ],
            [
                'class_id' => $classIds[array_rand($classIds)],
                'instructor_id' => $instructorIds[array_rand($instructorIds)],
                'age_range' => '13-15 years',
                'day' => 'Rabu',
                'schedule_date' => Carbon::now()->format('Y-m-d'),
                'schadule_end' => Carbon::now()->addMonths(3)->format('Y-m-d'),
                'start_time' => '15:30:00',
                'end_time' => '17:30:00',
                'capacity' => 18,
                'toggle' => true,
                'description' => 'Program lanjutan untuk remaja dengan fokus pada persiapan kompetisi.',
                'thumbnail' => 'program-thumbnails/program3.jpg',
            ],
            [
                'class_id' => $classIds[array_rand($classIds)],
                'instructor_id' => $instructorIds[array_rand($instructorIds)],
                'age_range' => '16-18 years',
                'day' => 'Kamis',
                'schedule_date' => Carbon::now()->format('Y-m-d'),
                'schadule_end' => Carbon::now()->addMonths(4)->format('Y-m-d'),
                'start_time' => '16:00:00',
                'end_time' => '18:00:00',
                'capacity' => 15,
                'toggle' => true,
                'description' => 'Program khusus untuk persiapan olimpiade.',
                'thumbnail' => 'program-thumbnails/program4.jpg',
            ],
            [
                'class_id' => $classIds[array_rand($classIds)],
                'instructor_id' => $instructorIds[array_rand($instructorIds)],
                'age_range' => '3-5 years',
                'day' => 'Jumat',
                'schedule_date' => Carbon::now()->format('Y-m-d'),
                'schadule_end' => Carbon::now()->addMonths(2)->format('Y-m-d'),
                'start_time' => '10:00:00',
                'end_time' => '11:30:00',
                'capacity' => 12,
                'toggle' => true,
                'description' => 'Program pengenalan untuk balita dengan kegiatan yang menyenangkan.',
                'thumbnail' => 'program-thumbnails/program5.jpg',
            ],
            [
                'class_id' => $classIds[array_rand($classIds)],
                'instructor_id' => $instructorIds[array_rand($instructorIds)],
                'age_range' => '18+ years',
                'day' => 'Sabtu',
                'schedule_date' => Carbon::now()->format('Y-m-d'),
                'schadule_end' => Carbon::now()->addMonths(6)->format('Y-m-d'),
                'start_time' => '09:00:00',
                'end_time' => '12:00:00',
                'capacity' => 25,
                'toggle' => true,
                'description' => 'Program untuk orang dewasa yang ingin mempelajari keterampilan baru.',
                'thumbnail' => 'program-thumbnails/program6.jpg',
            ],
            [
                'class_id' => $classIds[array_rand($classIds)],
                'instructor_id' => $instructorIds[array_rand($instructorIds)],
                'age_range' => '6-8 years',
                'day' => 'Minggu',
                'schedule_date' => Carbon::now()->format('Y-m-d'),
                'schadule_end' => Carbon::now()->addMonths(3)->format('Y-m-d'),
                'start_time' => '14:00:00',
                'end_time' => '16:00:00',
                'capacity' => 15,
                'toggle' => false, // Inactive program
                'description' => 'Program akhir pekan untuk anak-anak dengan suasana santai.',
                'thumbnail' => 'program-thumbnails/program7.jpg',
            ],
        ];

        // Insert all programs
        foreach ($programs as $program) {
            Program::create($program);
        }

        $this->command->info('Program seeder has been run successfully! Created ' . count($programs) . ' programs.');
    }
}