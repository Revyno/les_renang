<?php

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
       
            Schema::create('registrations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('students_id')->constrained()->onDelete('cascade');
                $table->foreignId('classes_id')->constrained('classes')->onDelete('cascade');
                $table->date('registration_date');
                $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
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
        Schema::dropIfExists('registrations');
    }
};
