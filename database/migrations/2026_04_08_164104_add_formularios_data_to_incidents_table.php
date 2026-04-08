<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('incidents', function (Blueprint $table) {
        $table->json('seguro_escolar_data')->nullable()->after('checklist');
        $table->json('informe_accidente_data')->nullable()->after('seguro_escolar_data');
    });
}

public function down(): void
{
    Schema::table('incidents', function (Blueprint $table) {
        $table->dropColumn(['seguro_escolar_data', 'informe_accidente_data']);
    });
}
};
