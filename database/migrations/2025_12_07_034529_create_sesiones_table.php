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
        Schema::create('sesiones', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('actividad_id')->constrained('actividades')->onDelete('cascade');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->dateTime('fecha_hora_inicio');
            $table->dateTime('fecha_hora_fin');
            $table->integer('duracion_minutos')->nullable();
            $table->string('ubicacion')->nullable();
            $table->string('url_virtual')->nullable();
            $table->string('instructor')->nullable();
            $table->boolean('asistencia_tomada')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesiones');
    }
};
