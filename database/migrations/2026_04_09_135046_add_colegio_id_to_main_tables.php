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
    // Lista de tablas que ahora pertenecen a un colegio
    $tablas = ['users', 'students', 'protocols', 'emergency_alerts'];

    foreach ($tablas as $tabla) {
        Schema::table($tabla, function (Blueprint $table) {
            // 🔥 Usamos school_id para ser consistentes con el modelo School
            $table->foreignId('school_id')->nullable()->constrained('schools')->onDelete('cascade');
        });
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('main_tables', function (Blueprint $table) {
            //
        });
    }
};
