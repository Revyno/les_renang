<?php

use App\Models\Classes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('instructors', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
        //     $table->foreignId('instructor_id')->constrained('instructors')->onDelete('cascade');
        //     $table->string('nama');
        //     $table->string('email')->unique();
        //     $table->date('tanggal_lahir');
        //     $table->string('jenis_kelamin');
        //     $table->string('telepon')->nullable();
        //     $table->string('alamat')->nullable(); 
        //     $table->string('spesialisasi')->nullable();
        //     $table->integer('pengalaman_tahun')->default(0);
        //     $table->string('image')->nullable();
        //     $table->timestamps();
        // });
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->string('name');
            $table->string('jenis_kelamin');
            $table->string('certification');
            $table->string('specialization');
            $table->string('telepon')->nullable();
            $table->integer('pengalaman_tahun')->default(0);
            $table->text('bio');
            $table->string('photo')->nullable();
            $table->json('social');
             $table->string('twitter')->nullable();
             $table->string('facebook')->nullable();
             $table->string('instagram')->nullable();
             $table->string('linkedin')->nullable();
            $table->timestamps();
        });
    }   

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instructors');
    }
};
