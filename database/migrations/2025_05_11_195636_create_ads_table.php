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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image'); // Gambar iklan
            $table->string('url'); // Link tujuan iklan
            $table->enum('position', ['top', 'sidebar', 'bottom']); // Posisi tampilan
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->decimal('price', 12, 2);
            $table->foreignId('advertiser_id')->constrained('users'); // Pemilik iklan
            $table->enum('status', ['pending', 'active', 'expired', 'rejected'])->default('pending');
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
        Schema::dropIfExists('ads');
    }
};
