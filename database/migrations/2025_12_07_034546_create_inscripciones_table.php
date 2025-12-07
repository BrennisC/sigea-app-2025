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
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignUuid('actividad_id')->constrained('actividades')->onDelete('cascade');
            $table->foreignUuid('estado_id')->nullable()->constrained('estados')->onDelete('set null');
            $table->date('fecha_inscripcion');
            $table->boolean('pago_requerido')->default(false);
            $table->boolean('pago_completado')->default(false);
            $table->text('observaciones')->nullable();
            $table->timestamps();
            
            // Evitar inscripciones duplicadas
            $table->unique(['user_id', 'actividad_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscripciones');
    }
};
