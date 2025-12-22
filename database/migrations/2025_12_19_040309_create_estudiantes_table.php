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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            
            // --- Agregamos estos campos ---
            $table->string('rut')->unique();      // El RUT no puede repetirse
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('curso');              // Ej: "1° Medio A"
            $table->string('email')->nullable();  // Correo es opcional
            // ------------------------------

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
