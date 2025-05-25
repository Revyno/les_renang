<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $instructors = [
            'name' => 'Devina',
            'jenis_kelamin' => 'Perempuan',
            'certification' => 'Certified Instructor',
            'specialization'=> 'gaya dada',
            'telepon' => '08123456789',
            'pengalaman_tahun' => 5,
            'bio' => 'Instruktur renang berpengalaman dengan spesialisasi gaya dada.',
            'photo' => 'public/assets/img/teacher/20240804_072031.jpg',
        ];
      foreach ($instructors as $instructor) {
            \App\Models\Instructor::create([
                'name' => $instructor['name'],
                'jenis_kelamin' => $instructor['jenis_kelamin'],
                'certification' => $instructor['certification'],
                'specialization' => $instructor['specialization'],
                'telepon' => $instructor['telepon'],
                'pengalaman_tahun' => $instructor['pengalaman_tahun'],
                'bio' => $instructor['bio'],
                'photo' => $instructor['photo'],
            ]);
        }
    }
}
