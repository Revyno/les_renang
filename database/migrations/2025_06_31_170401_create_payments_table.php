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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained(); // Added to match the model
            $table->decimal('amount', 12, 2);
            $table->string('method')->default('transfer'); // transfer/cash/qris/edc
            $table->string('transaction_id')->nullable(); // Added to match the model
            $table->string('proof')->nullable(); // Bukti pembayaran
            $table->enum('status', ['pending', 'paid', 'failed', 'refunded']);
            $table->dateTime('paid_at')->nullable();
            $table->text('notes')->nullable();
            // $table->morphs('payable'); // For polymorphic relationship
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
        Schema::dropIfExists('payments');
    }
};