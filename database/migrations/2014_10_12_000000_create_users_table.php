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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->char('usuario', '50')->unique();
            $table->string('password');
            $table->char('nombre', '100');
            $table->char('email', '100')->unique();
            $table->decimal('saldo_disponible', 12, 2)->nullable();
            $table->decimal('saldo_por_cobrar', 12, 2)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
