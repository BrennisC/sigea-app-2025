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
        Schema::create('certificados', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('inscripcion_id')->constrained('inscripciones')->onDelete('cascade');
            $table->foreignUuid('actividad_id')->constrained('actividades')->onDelete('cascade');
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->string('codigo_validacion', 50)->unique();
            $table->date('fecha_emision');
            $table->string('url_pdf')->nullable();
            $table->decimal('porcentaje_asistencia', 5, 2)->nullable();
            $table->integer('horas_certificadas')->nullable();
            $table->foreignUuid('generado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificados');
    }
};
