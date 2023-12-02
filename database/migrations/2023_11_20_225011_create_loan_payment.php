<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loan_payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('total', 10, 2);
            
            $table->unsignedBigInteger('payment_id');
            $table->foreign('payment_id')->references('id')->on('payments');

            $table->unsignedBigInteger('loan_id');
            $table->foreign('loan_id')->references('id')->on('loans');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_payments');
    }
};
