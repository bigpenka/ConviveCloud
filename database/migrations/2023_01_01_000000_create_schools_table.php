<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    // 🔥 TIENE QUE DECIR 'schools', NO 'colegios'
    Schema::create('schools', function (Blueprint $table) {
        $table->id();
        $table->string('nombre'); 
        $table->string('slug')->unique();
        $table->string('rut_institucion')->unique()->nullable();
        $table->string('direccion')->nullable();
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
