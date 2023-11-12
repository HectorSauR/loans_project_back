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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->decimal('total', 10, 2);
            $table->decimal('remaining', 10, 2)->nullable();
            $table->decimal('interest', 10, 2)->default(10.00);
            $table->decimal('interest_generated', 10, 2)->nullable();
            $table->enum('deadline', ['week', 'month'])->default('month');

            $table->datetime('ended_date')->nullable();
            $table->text('guarantee')->nullable();
            $table->enum('kind', ['cash', 'card'])->default('cash');

            $table->unsignedBigInteger('investor_id');
            $table->foreign('investor_id')->references('id')->on('investors');

            $table->unsignedBigInteger('debtor_id');
            $table->foreign('debtor_id')->references('id')->on('debtors');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
