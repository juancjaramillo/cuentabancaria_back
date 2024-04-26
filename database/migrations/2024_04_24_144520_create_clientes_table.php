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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string("nombre");
            $table->string("apellido");
            $table->string("documento")->unique();
            $table->string('numero_cuenta', 30)->unique();
            $table->longText("foto");  // longText  tamaño de imagen puedes ser muy largo
            $table->string("direccion");
            $table->decimal('longitud', 10, 6)->nullable()->default(0.0); // Nullable y valor predeterminado
            $table->decimal('latitud', 10, 6)->nullable()->default(0.0); // Nullable y valor predeterminado         
            $table->decimal('saldo', 30, 2)->default(0.00);
            $table->string('email')->unique();
            $table->string('password');
            $table->string('tipo')->default('cliente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
