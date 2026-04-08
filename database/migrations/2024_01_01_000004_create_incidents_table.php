<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            // Relaciones (Foreign Keys)
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('protocol_id')->constrained('protocols')->onDelete('cascade');
            
            // Datos del incidente
            $table->text('descripcion');
            $table->date('fecha_incidente');
            $table->string('estado')->default('Abierto'); // Abierto, En Proceso, Cerrado
            $table->dateTime('fecha_cierre')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};