<?php
use Illuminate\Database\Seeder;
use App\Models\Registration;

class RegistrationSeeder extends Seeder
{
    public function run()
    {
        Registration::create([
            'name' => 'Devina Almirah Firdaus',
            'alamat' => 'Jl. Mawar No. 1',
            'no_telepon' => '08123456789',
            'email' => 'devina@example.com',
            'usia' => 25,
            'program' => 'Les Private',
            'jadwal' => 'Senin - Rabu',
            'tingkat_kemampuan' => 'Beginner',
            'password' => bcrypt('123456'),
            'status' => 'Enrolled',
        ]);

        // Tambah data lainnya kalau perlu
    }
}
