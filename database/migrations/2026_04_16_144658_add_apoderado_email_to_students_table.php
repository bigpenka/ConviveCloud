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
    Schema::table('students', function (Blueprint $table) {
        // Agregamos el trío de datos del apoderado
        $table->string('nombre_apoderado')->nullable()->after('rut');
        $table->string('parentesco_apoderado')->nullable()->after('nombre_apoderado'); // Ej: Padre, Madre, Tutor Legal
        $table->string('email_apoderado')->nullable()->after('parentesco_apoderado');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            //
        });
    }
};
