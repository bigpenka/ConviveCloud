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
        // 🔥 Relaciones
        $table->foreignId('school_id')->nullable()->constrained('schools')->onDelete('cascade');
        $table->foreignId('student_id')->nullable()->constrained('students')->onDelete('cascade');
        $table->foreignId('protocol_id')->constrained('protocols');

        // 🔥 Datos básicos
        $table->date('fecha_incidente');
        $table->text('descripcion');
        $table->string('estado')->default('abierto');

        // 🔥 Campos que daban error (Checklist y Datos de Seguro/Informe)
        $table->json('checklist')->nullable(); 
        $table->json('seguro_escolar_data')->nullable();
        $table->json('informe_accidente_data')->nullable();

        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};