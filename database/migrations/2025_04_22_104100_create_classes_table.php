<?php

use App\Models\Instructor;
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
        Schema::create('classes', function (Blueprint $table) {
            // $table->id();
            // $table->foreignId('instructor_id')->nullable()->constrained('instructors')->OnDelete('cascade');
            // $table->string('title');
            // $table->date('schedule_date');
            // $table->string('level');
            
            // $table->time('schedule_time');
            // $table->integer('capacity');
            // $table->boolean('is_active')->default(true);
            // // $table->decimal('price', 10, 2);
            // $table->string('description')->nullable();
            // $table->string('thumbnail')->nullable();
            // $table->timestamps();

                $table->id();
                $table->foreignId('instructor_id')->nullable()->constrained('instructors')->OnDelete('cascade');
                $table->string('title');
                $table->string('level');
                $table->text('description');
                $table->decimal('price', 10, 2);
                $table->integer('sessions');
                $table->integer('duration_weeks');
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
        Schema::dropIfExists('classes');
        Schema::table('classes', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
};
