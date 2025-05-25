<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            
            // Foreign keys
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');
                
            $table->foreignId('class_id')
                ->constrained('classes')
                ->onDelete('cascade');
                
            $table->foreignId('program_id')
                ->constrained('programs')
                ->onDelete('cascade');
            
            // Data orang tua
            $table->string('parent_name');
            $table->string('parent_email');
            $table->string('parent_phone');
            
            // Data siswa
            $table->string('student_name');
            $table->integer('student_age');
            $table->enum('student_gender', ['male', 'female']);
            $table->string('student_photo')->nullable();
            $table->text('medical_notes')->nullable();
            
            // Status
            $table->enum('status', [
                'pending', 
                'approved', 
                'rejected', 
                'cancelled', 
                'completed'
            ])->default('pending');
            
            // Pembayaran
            $table->string('payment_proof')->nullable();
            $table->enum('payment_status', [
                'unpaid', 
                'pending', 
                'paid',
                'refunded'
            ])->default('unpaid');
            
            // Tanggal
            $table->date('registration_date');
            $table->timestamps();
            
            // Index untuk pencarian
            $table->index(['user_id', 'class_id', 'status']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('registrations');
    }
};