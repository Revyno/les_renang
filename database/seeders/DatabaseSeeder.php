<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            AdminUserSeeder::class,
            InstructorSeeder::class,
            // StudentSeeder::class,
            ProgramSeeder::class,
            // Tambahkan seeder lain jika ada
        ]);
    }
}