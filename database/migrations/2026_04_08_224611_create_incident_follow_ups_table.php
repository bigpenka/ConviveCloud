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
    Schema::create('incident_follow_ups', function (Blueprint $table) {
        $table->id();
        $table->foreignId('incident_id')->constrained()->onDelete('cascade');
        $table->foreignId('user_id')->constrained(); // Quién hace el seguimiento
        $table->date('fecha');
        $table->text('comentario');
        $table->string('tipo_contacto'); // Ej: Entrevista, Llamada, Visita
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incident_follow_ups');
    }
};
