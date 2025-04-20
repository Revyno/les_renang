<?php
// database/migrations/xxxx_xx_xx_create_registrations_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('alamat');
            $table->string('no_telepon');
            $table->string('email')->unique();
            $table->integer('usia');
            $table->string('program');
            $table->string('jadwal');
            $table->string('tingkat_kemampuan');
            $table->string('passsword');
            // Tambahkan kolom lainnya sesuai kebutuhan
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('registrations');
    }
};