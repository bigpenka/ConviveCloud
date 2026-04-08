<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('protocols', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Ej: Maltrato físico, Ciberacoso
            $table->string('gravedad'); // Leve, Grave, Gravísima
            $table->integer('plazo_dias'); // Días para resolver según ley
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('protocols');
    }
};