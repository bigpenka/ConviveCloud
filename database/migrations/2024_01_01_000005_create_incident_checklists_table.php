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
    Schema::create('incident_checklists', function (Blueprint $table) {
        $table->id();
        $table->foreignId('incident_id')->constrained('incidents')->onDelete('cascade');
        $table->foreignId('protocol_step_id')->constrained('protocol_steps')->onDelete('cascade');
        $table->boolean('is_completed')->default(false);
        $table->timestamp('completed_at')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incident_checklists');
    }
};
