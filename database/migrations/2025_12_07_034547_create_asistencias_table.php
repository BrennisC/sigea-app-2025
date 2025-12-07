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
        Schema::create('asistencias', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('inscripcion_id')->constrained('inscripciones')->onDelete('cascade');
            $table->foreignUuid('sesion_id')->constrained('sesiones')->onDelete('cascade');
            $table->boolean('presente')->default(false);
            $table->dateTime('fecha_hora_registro')->nullable();
            $table->foreignUuid('registrado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->text('observaciones')->nullable();
            $table->timestamps();
            
            // Evitar duplicados
            $table->unique(['inscripcion_id', 'sesion_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
