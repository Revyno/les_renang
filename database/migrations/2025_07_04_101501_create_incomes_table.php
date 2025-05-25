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
       Schema::create('incomes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('payment_id')->constrained()->cascadeOnDelete();;
        $table->decimal('amount', 12, 2);
        $table->decimal('tax', 12, 2);
        $table->decimal('operational_fee', 12, 2);
        $table->decimal('instructor_fee', 12, 2);
        $table->decimal('net_income', 12, 2); // Tambahkan ini
        $table->date('income_date');
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
        Schema::dropIfExists('incomes');
    }
};
