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
        Schema::create('actividades', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->foreignUuid('organizador_id')->constrained('users')->onDelete('cascade');
            $table->foreignUuid('tipo_id')->nullable()->constrained('tipos')->onDelete('set null');
            $table->foreignUuid('estado_id')->nullable()->constrained('estados')->onDelete('set null');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('modalidad', 50); // 'presencial', 'virtual', 'hibrida'
            $table->string('ubicacion')->nullable();
            $table->string('url_virtual')->nullable();
            $table->decimal('precio', 10, 2)->default(0.00);
            $table->integer('cupo_maximo')->nullable();
            $table->integer('horas_totales')->nullable();
            $table->decimal('porcentaje_asistencia_minima', 5, 2)->default(75.00); // Para certificado
            $table->string('imagen_url')->nullable();
            $table->boolean('requiere_pago')->default(false);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividades');
    }
};
