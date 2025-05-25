<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
        'name' => 'Admin',
        'email' => 'admin@admin.com',
        'password' => 'admin123',
        'role' => 'admin',
        'email_verified_at' => now(),
        'remember_token' => null,
        'created_at' => now(),
    ]);
    }
}
